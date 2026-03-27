<?php
require_once "Controller.php";
class PosSalesReportController extends Controller
{
    public function index()
    {
        $action = $_GET['action'] ?? null;

        $paymentModes = $this->query("
            SELECT DISTINCT TRIM(BOTH '\"' FROM payment_name) AS payment_name
            FROM biggs_loyalty.master_data
            WHERE payment_name IS NOT NULL AND payment_name <> ''
            ORDER BY payment_name
        ");

        $stores = $this->query("
            SELECT DISTINCT branch
            FROM biggs_loyalty.master_data
            WHERE branch IS NOT NULL AND branch <> ''
            ORDER BY branch
        ");

        $discounts = $this->query("
            SELECT DISTINCT TRIM(BOTH '\"' FROM discount_name) AS discount_name
            FROM biggs_loyalty.master_data
            WHERE discount_name IS NOT NULL AND discount_name <> ''
            ORDER BY discount_name
        ");

        $productNames = $this->query("
            SELECT DISTINCT TRIM(BOTH '\"' FROM product_name) AS product_name
            FROM biggs_loyalty.master_data
            WHERE product_name IS NOT NULL AND product_name <> ''
            ORDER BY product_name
        ");

        $departments = $this->query("
            SELECT DISTINCT TRIM(BOTH '\"' FROM department_name) AS department_name
            FROM biggs_loyalty.master_data
            WHERE department_name IS NOT NULL AND department_name <> ''
            ORDER BY department_name
        ");

        $transactionTypes = $this->query("
            SELECT DISTINCT TRIM(BOTH '\"' FROM transaction_type) AS transaction_type
            FROM biggs_loyalty.master_data
            WHERE transaction_type IS NOT NULL AND transaction_type <> ''
            ORDER BY transaction_type
        ");

        $dateRange = $this->query("
            SELECT MIN(date) AS min_date
            FROM biggs_loyalty.master_data
        ");

        $minDate = isset($dateRange[0]['min_date']) ? $dateRange[0]['min_date'] : null;

        $currentDateTime = $this->getDate();
        if ($currentDateTime && $currentDateTime !== "Failed to retrieve datetime.") {
            $currentDate = substr($currentDateTime, 0, 10);
            $yesterday = date('Y-m-d', strtotime($currentDate . ' -1 day'));
        } else {
            $yesterday = date('Y-m-d', strtotime('-1 day'));
        }

        // Check if user has set any filters or explicitly clicked Generate
        $hasUserInput = isset($_GET['start_date']) || isset($_GET['end_date']) || 
                       isset($_GET['payment_mode']) || isset($_GET['store']) || 
                       isset($_GET['discount']) || isset($_GET['product_name']) || 
                       isset($_GET['department_name']) || isset($_GET['transaction_type']);
        
        if ($action === 'filter_generate' && !$hasUserInput) {
            // No filters set - use complete date range to show all data
            $startDate = $minDate;
            $endDate = null; // No end date limit = all future data
            $defaultStartDate = $minDate;
            $defaultEndDate = date('Y-m-d');
        } else {
            // User provided inputs or initial page load - use defaults
            $startDate = $_GET['start_date'] ?? $minDate;
            $endDate = $_GET['end_date'] ?? $yesterday;
            $defaultStartDate = $minDate;
            $defaultEndDate = $yesterday;
        }

        $paymentModesFilter = [];
        if (isset($_GET['payment_mode'])) {
            $raw = $_GET['payment_mode'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $paymentModesFilter[] = $value;
                }
            }
        }

        $storesFilter = [];
        if (isset($_GET['store'])) {
            $raw = $_GET['store'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $storesFilter[] = $value;
                }
            }
        }

        $discountsFilter = [];
        if (isset($_GET['discount'])) {
            $raw = $_GET['discount'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $discountsFilter[] = $value;
                }
            }
        }

        $officialReceipt = $_GET['official_receipt'] ?? null;
        $phoneNumber = $_GET['phone_number'] ?? null;
        $productNamesFilter = [];
        if (isset($_GET['product_name'])) {
            $raw = $_GET['product_name'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $productNamesFilter[] = $value;
                }
            }
        }

        $departmentsFilter = [];
        if (isset($_GET['department_name'])) {
            $raw = $_GET['department_name'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $departmentsFilter[] = $value;
                }
            }
        }

        $transactionTypesFilter = [];
        if (isset($_GET['transaction_type'])) {
            $raw = $_GET['transaction_type'];
            $values = is_array($raw) ? $raw : [$raw];
            foreach ($values as $value) {
                if ($value !== '') {
                    $transactionTypesFilter[] = $value;
                }
            }
        }

        // Determine report mode based on user input
        $isGenerateAction = $action === 'filter_generate' || $action === 'filter';
        $isExportAction = $action === 'export';
        
        // Check if export_mode is explicitly set (passed from form)
        $exportModeOverride = isset($_GET['export_mode']) ? $_GET['export_mode'] : null;
        
        // During export, use the export_mode if provided; otherwise determine from inputs
        if ($isExportAction && $exportModeOverride === 'all_columns') {
            $showAllColumnsMode = true;
        } elseif ($isExportAction && $exportModeOverride === 'aggregated') {
            $showAllColumnsMode = false;
        } else {
            // Normal generation - determine mode from inputs
            $hasExplicitReportConfig = isset($_GET['index_field']) || isset($_GET['column_field']);
            
            // Show all columns mode: No explicit report configuration (regardless of filters)
            // Filters will be applied to show only matching rows
            $showAllColumnsMode = !$hasExplicitReportConfig;
        }
        
        if ($showAllColumnsMode) {
            // Display all raw columns
            $indexFields = [];
            $columnFields = [];
        } else {
            // User explicitly configured report fields
            $indexFields = isset($_GET['index_field']) && !empty($_GET['index_field']) ? (array)$_GET['index_field'] : [];
            $columnFields = isset($_GET['column_field']) && !empty($_GET['column_field']) ? (array)$_GET['column_field'] : [];
        }
        
        $valueField = isset($_GET['value_field']) && !empty($_GET['value_field']) ? $_GET['value_field'] : 'amount';

        $dimensionMap = [
            'date' => 'date',
            'payment_name' => 'TRIM(BOTH \'\"\' FROM payment_name)',
            'branch' => 'branch',
            'discount_name' => 'TRIM(BOTH \'\"\' FROM discount_name)',
            'product_name' => 'TRIM(BOTH \'\"\' FROM product_name)',
            'department_name' => 'TRIM(BOTH \'\"\' FROM department_name)',
            'transaction_type' => 'TRIM(BOTH \'\"\' FROM transaction_type)',
            'official_receipt' => 'official_receipt',
            'phone_number' => 'phone_number',
        ];

        $dimensionLabels = [
            'date' => 'Date',
            'payment_name' => 'Payment Mode',
            'branch' => 'Store',
            'discount_name' => 'Discount',
            'product_name' => 'Product Name',
            'department_name' => 'Department Name',
            'transaction_type' => 'Transaction Type',
            'official_receipt' => 'Official Receipt',
            'phone_number' => 'Phone Number',
        ];

        $valueMap = [
            'amount' => 'amount',
            'quantity' => 'quantity',
            'unit_price' => 'unit_price',
            'transaction_number' => 'transaction_number',
        ];

        $valueLabels = [
            'amount' => 'Sales',
            'quantity' => 'Quantity',
            'official_receipt' => 'Official Receipt',
            'phone_number' => 'Phone Number',
            'item_code' => 'Item Code',
            'unit_price' => 'Unit Price',
            'discount_code' => 'Discount Code',
            'department_code' => 'Department Code',
            'type_code' => 'Type Code',
            'vat_amount' => 'VAT Amount',
            'transaction_number' => 'Transaction Number',
        ];

        $reportRows = [];
        $previewRows = [];
        $noData = false;

        if (!empty($_GET)) {
            if ($showAllColumnsMode) {
                // Show all columns mode - display raw transaction data
                $allColumns = [
                    'date' => 'Date',
                    'branch' => 'Store',
                    'payment_name' => 'Payment Mode',
                    'discount_name' => 'Discount',
                    'product_name' => 'Product Name',
                    'department_name' => 'Department Name',
                    'transaction_type' => 'Transaction Type',
                    'official_receipt' => 'Official Receipt',
                    'phone_number' => 'Phone Number',
                    'quantity' => 'Quantity',
                    'amount' => 'Sales',
                    'unit_price' => 'Unit Price',
                    'transaction_number' => 'Transaction Number',
                ];

                $sqlBase = "
                    SELECT 
                        date,
                        TRIM(BOTH '\"' FROM branch) AS branch,
                        TRIM(BOTH '\"' FROM payment_name) AS payment_name,
                        TRIM(BOTH '\"' FROM discount_name) AS discount_name,
                        TRIM(BOTH '\"' FROM product_name) AS product_name,
                        TRIM(BOTH '\"' FROM department_name) AS department_name,
                        TRIM(BOTH '\"' FROM transaction_type) AS transaction_type,
                        official_receipt,
                        phone_number,
                        quantity,
                        amount,
                        unit_price,
                        transaction_number
                    FROM biggs_loyalty.master_data
                    WHERE 1 = 1
                ";

                $params = [];

                if (!empty($startDate)) {
                    $sqlBase .= " AND date >= :start_date";
                    $params[':start_date'] = $startDate;
                }

                if (!empty($endDate)) {
                    $sqlBase .= " AND date <= :end_date";
                    $params[':end_date'] = $endDate;
                }

                if (!empty($paymentModesFilter)) {
                    $placeholders = [];
                    foreach ($paymentModesFilter as $idx => $value) {
                        $param = ':payment_mode_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND TRIM(BOTH '\"' FROM payment_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($storesFilter)) {
                    $placeholders = [];
                    foreach ($storesFilter as $idx => $value) {
                        $param = ':store_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND branch IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($discountsFilter)) {
                    $placeholders = [];
                    foreach ($discountsFilter as $idx => $value) {
                        $param = ':discount_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND TRIM(BOTH '\"' FROM discount_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($productNamesFilter)) {
                    $placeholders = [];
                    foreach ($productNamesFilter as $idx => $value) {
                        $param = ':product_name_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND TRIM(BOTH '\"' FROM product_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($departmentsFilter)) {
                    $placeholders = [];
                    foreach ($departmentsFilter as $idx => $value) {
                        $param = ':department_name_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND TRIM(BOTH '\"' FROM department_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($transactionTypesFilter)) {
                    $placeholders = [];
                    foreach ($transactionTypesFilter as $idx => $value) {
                        $param = ':transaction_type_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sqlBase .= " AND TRIM(BOTH '\"' FROM transaction_type) IN (" . implode(',', $placeholders) . ")";
                }

                $sqlBase .= " ORDER BY date DESC";
                
                // Query for preview (limited to 100 rows to prevent memory exhaustion)
                $sql = $sqlBase . " LIMIT 100";

                $reportRows = $this->query($sql, $params);
                $previewRows = array_slice($reportRows, 0, 30);
                $noData = empty($reportRows);

                if ($action === 'export') {
                    header('Content-Type: text/csv');
                    $startDateDisplay = !empty($startDate) ? $startDate : date('Y-m-d');
                    $endDateDisplay = !empty($endDate) ? $endDate : date('Y-m-d');
                    $dateRange = $startDateDisplay . '_to_' . $endDateDisplay;
                    header('Content-Disposition: attachment; filename="POS_sales_report(' . $dateRange . ').csv"');

                    $output = fopen('php://output', 'w');
                    fputcsv($output, array_values($allColumns));

                    // Stream export without LIMIT to get all data efficiently
                    try {
                        $stmt = $this->pdo->prepare($sqlBase);
                        
                        foreach ($params as $key => $value) {
                            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                            if (is_int($key)) {
                                $stmt->bindValue($key + 1, $value, $paramType);
                            } else {
                                $stmt->bindValue($key, $value, $paramType);
                            }
                        }
                        
                        $stmt->execute();
                        
                        // Stream rows to CSV to avoid memory exhaustion
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $rowValues = [];
                            foreach (array_keys($allColumns) as $col) {
                                $rowValues[] = $row[$col] ?? '';
                            }
                            fputcsv($output, $rowValues);
                        }
                    } catch (PDOException $e) {
                        fputcsv($output, ['Error: ' . $e->getMessage()]);
                    }

                    fclose($output);
                    exit;
                }
            } else {
                // Aggregated report mode
                $selectedIndexFields = [];
                foreach ($indexFields as $field) {
                    if (isset($dimensionMap[$field]) && !in_array($field, $selectedIndexFields, true)) {
                        $selectedIndexFields[] = $field;
                    }
                }
                if (empty($selectedIndexFields)) {
                    $selectedIndexFields = ['branch'];
                }

                $selectedColumnFields = [];
                foreach ($columnFields as $field) {
                    if (isset($dimensionMap[$field]) && !in_array($field, $selectedColumnFields, true)) {
                        $selectedColumnFields[] = $field;
                    }
                }
                if (empty($selectedColumnFields)) {
                    $selectedColumnFields = ['product_name'];
                }

                $valueKey = isset($valueMap[$valueField]) ? $valueField : 'amount';

                $selectParts = [];
                $groupByParts = [];

                foreach ($selectedIndexFields as $field) {
                    $alias = 'index_' . $field;
                    $selectParts[] = $dimensionMap[$field] . " AS " . $alias;
                    $groupByParts[] = $dimensionMap[$field];
                }

                foreach ($selectedColumnFields as $field) {
                    $alias = 'column_' . $field;
                    $selectParts[] = $dimensionMap[$field] . " AS " . $alias;
                    $groupByParts[] = $dimensionMap[$field];
                }

                $countDistinctFields = [
                    'official_receipt',
                    'phone_number',
                    'item_code',
                    'discount_code',
                    'department_code',
                    'type_code',
                    'transaction_number',
                ];

                if (in_array($valueKey, $countDistinctFields, true)) {
                    $metricExpr = "COUNT(DISTINCT " . $valueMap[$valueKey] . ") AS metric_value";
                } else {
                    $metricExpr = "SUM(" . $valueMap[$valueKey] . ") AS metric_value";
                }

                $selectParts[] = $metricExpr;

                $indexLabels = [];
                foreach ($selectedIndexFields as $field) {
                    $indexLabels[] = $dimensionLabels[$field] ?? $field;
                }

                $columnLabels = [];
                foreach ($selectedColumnFields as $field) {
                    $columnLabels[] = $dimensionLabels[$field] ?? $field;
                }

                $valueLabel = $valueLabels[$valueKey];

                $sql = "
                    SELECT
                        " . implode(", ", $selectParts) . "
                    FROM biggs_loyalty.master_data
                    WHERE 1 = 1
                ";

                $params = [];

                if (!empty($startDate)) {
                    $sql .= " AND date >= :start_date";
                    $params[':start_date'] = $startDate;
                }

                if (!empty($endDate)) {
                    $sql .= " AND date <= :end_date";
                    $params[':end_date'] = $endDate;
                }

                if (!empty($paymentModesFilter)) {
                    $placeholders = [];
                    foreach ($paymentModesFilter as $idx => $value) {
                        $param = ':payment_mode_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND TRIM(BOTH '\"' FROM payment_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($storesFilter)) {
                    $placeholders = [];
                    foreach ($storesFilter as $idx => $value) {
                        $param = ':store_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND branch IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($discountsFilter)) {
                    $placeholders = [];
                    foreach ($discountsFilter as $idx => $value) {
                        $param = ':discount_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND TRIM(BOTH '\"' FROM discount_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($productNamesFilter)) {
                    $placeholders = [];
                    foreach ($productNamesFilter as $idx => $value) {
                        $param = ':product_name_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND TRIM(BOTH '\"' FROM product_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($departmentsFilter)) {
                    $placeholders = [];
                    foreach ($departmentsFilter as $idx => $value) {
                        $param = ':department_name_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND TRIM(BOTH '\"' FROM department_name) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($transactionTypesFilter)) {
                    $placeholders = [];
                    foreach ($transactionTypesFilter as $idx => $value) {
                        $param = ':transaction_type_' . $idx;
                        $placeholders[] = $param;
                        $params[$param] = $value;
                    }
                    $sql .= " AND TRIM(BOTH '\"' FROM transaction_type) IN (" . implode(',', $placeholders) . ")";
                }

                if (!empty($groupByParts)) {
                    $sql .= "
                    GROUP BY
                        " . implode(", ", $groupByParts) . "
                    ";
                    $sql .= " ORDER BY " . implode(", ", $groupByParts);
                }

                // For preview - limit to 100 rows to prevent memory issues
                $sqlPreview = $sql . " LIMIT 100";
                $reportRows = $this->query($sqlPreview, $params);
                
                $previewRows = array_slice($reportRows, 0, 30);
                $noData = empty($reportRows);

                if ($action === 'export') {
                    header('Content-Type: text/csv');
                    $startDateDisplay = !empty($startDate) ? $startDate : date('Y-m-d');
                    $endDateDisplay = !empty($endDate) ? $endDate : date('Y-m-d');
                    $dateRange = $startDateDisplay . '_to_' . $endDateDisplay;
                    header('Content-Disposition: attachment; filename="POS_sales_report_(' . $dateRange . ').csv"');

                    $output = fopen('php://output', 'w');

                    $headerRow = array_merge($indexLabels, $columnLabels, [$valueLabel]);
                    fputcsv($output, $headerRow);

                    $decimalFields = ['amount', 'unit_price', 'vat_amount'];

                    // Use unlimited query with streaming to export ALL data without memory exhaustion
                    try {
                        $stmt = $this->pdo->prepare($sql);
                        
                        foreach ($params as $key => $value) {
                            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                            if (is_int($key)) {
                                $stmt->bindValue($key + 1, $value, $paramType);
                            } else {
                                $stmt->bindValue($key, $value, $paramType);
                            }
                        }
                        
                        $stmt->execute();
                        
                        // Stream rows to CSV
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $rowValues = [];

                            foreach ($selectedIndexFields as $field) {
                                $key = 'index_' . $field;
                                $rowValues[] = $row[$key] ?? '';
                            }

                            foreach ($selectedColumnFields as $field) {
                                $key = 'column_' . $field;
                                $rowValues[] = $row[$key] ?? '';
                            }

                            $rawMetric = $row['metric_value'] ?? 0;

                            if (in_array($valueKey, $decimalFields, true)) {
                                $metricValue = number_format((float)$rawMetric, 2, '.', '');
                            } else {
                                $metricValue = (string)(int)$rawMetric;
                            }

                            $rowValues[] = $metricValue;

                            fputcsv($output, $rowValues);
                        }
                    } catch (PDOException $e) {
                        fputcsv($output, ['Error: ' . $e->getMessage()]);
                    }

                    fclose($output);
                    exit;
                }
            }
        }

        require __DIR__ . "/../../public/views/pos/pos.php";
    }
}
