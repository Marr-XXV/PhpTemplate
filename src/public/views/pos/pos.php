<?php
require __DIR__ . "/../template/header.php";
require __DIR__ . "/../template/topbar.php";
require __DIR__ . "/../template/navbar.php";

$usePersistedFilters = isset($noData) && $noData;
?>
<!-- Page Sidebar Ends-->
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card pos-container-css">
          <div class="card-body">
            <div class="col-12 text-center">
              <h3 class="mb-0">Point-of-Sale (POS) Sales Reports</h3>
            </div>
            <form method="get">
              <div class="mt-4 p-3 pos-container-css">
                <h5 class="mb-3"><image src="public/assets/images/filter_img.png" width="22" height="22"> Filter</h5>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date</label>
                    <div class="input-group">
                      <input
                        type="text"
                        id="start_date"
                        name="start_date"
                        class="form-control"
                        placeholder="Select date"
                        value="<?=
                                isset($_GET['start_date'])
                                  ? htmlspecialchars($_GET['start_date'])
                                  : (isset($defaultStartDate) ? htmlspecialchars($defaultStartDate) : '')
                                ?>">
                      <div class="input-group-append">
                        <span class="input-group-text" id="start_date_icon">
                          <image src="public/assets/images/calendar.png" width="24" height="24">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">End Date</label>
                    <div class="input-group">
                      <input
                        type="text"
                        id="end_date"
                        name="end_date"
                        class="form-control"
                        placeholder="Select date"
                        value="<?=
                                isset($_GET['end_date'])
                                  ? htmlspecialchars($_GET['end_date'])
                                  : (isset($defaultEndDate) ? htmlspecialchars($defaultEndDate) : '')
                                ?>">
                      <div class="input-group-append">
                        <span class="input-group-text" id="end_date_icon">
                          <image src="public/assets/images/calendar.png" width="24" height="24">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Quick Presets</label>
                    <div class="date-presets-group">
                      <button type="button" class="btn btn-outline-primary btn-sm date-preset" data-preset="today" title="Set to today">Today</button>
                      <button type="button" class="btn btn-outline-primary btn-sm date-preset" data-preset="this-week" title="Set to start of week">This Week</button>
                      <button type="button" class="btn btn-outline-primary btn-sm date-preset" data-preset="this-month" title="Set to start of month">This Month</button>
                      <button type="button" class="btn btn-outline-primary btn-sm date-preset" data-preset="last-month" title="Set to last month">Last Month</button>
                      <button type="button" class="btn btn-outline-primary btn-sm date-preset" data-preset="last-quarter" title="Set to last quarter">Last Quarter</button>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Payment Mode</label>
                    <div class="multi-select-wrapper" data-field-type="payment_mode">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Payment Mode">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($paymentModes)): ?>
                          <?php foreach ($paymentModes as $row): ?>
                            <?php $value = $row['payment_name']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="payment_mode[]" multiple>
                        <?php
                        $persistedPayment = isset($_GET['payment_mode']) ? (array)$_GET['payment_mode'] : [];
                        if (isset($paymentModes)):
                          foreach ($paymentModes as $row):
                            $value = $row['payment_name'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedPayment, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Store</label>
                    <div class="multi-select-wrapper" data-field-type="store">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Store">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($stores)): ?>
                          <?php foreach ($stores as $row): ?>
                            <?php $value = $row['branch']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="store[]" multiple>
                        <?php
                        $persistedStore = isset($_GET['store']) ? (array)$_GET['store'] : [];
                        if (isset($stores)):
                          foreach ($stores as $row):
                            $value = $row['branch'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedStore, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Discount</label>
                    <div class="multi-select-wrapper" data-field-type="discount">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Discount">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($discounts)): ?>
                          <?php foreach ($discounts as $row): ?>
                            <?php $value = $row['discount_name']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="discount[]" multiple>
                        <?php
                        $persistedDiscount = isset($_GET['discount']) ? (array)$_GET['discount'] : [];
                        if (isset($discounts)):
                          foreach ($discounts as $row):
                            $value = $row['discount_name'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedDiscount, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Product Name</label>
                    <div class="multi-select-wrapper" data-field-type="product_name">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Product">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($productNames)): ?>
                          <?php foreach ($productNames as $row): ?>
                            <?php $value = $row['product_name']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="product_name[]" multiple>
                        <?php
                        $persistedProduct = isset($_GET['product_name']) ? (array)$_GET['product_name'] : [];
                        if (isset($productNames)):
                          foreach ($productNames as $row):
                            $value = $row['product_name'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedProduct, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Department Name</label>
                    <div class="multi-select-wrapper" data-field-type="department_name">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Department">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($departments)): ?>
                          <?php foreach ($departments as $row): ?>
                            <?php $value = $row['department_name']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="department_name[]" multiple>
                        <?php
                        $persistedDepartment = isset($_GET['department_name']) ? (array)$_GET['department_name'] : [];
                        if (isset($departments)):
                          foreach ($departments as $row):
                            $value = $row['department_name'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedDepartment, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Transaction Type</label>
                    <div class="multi-select-wrapper" data-field-type="transaction_type">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Transaction Type">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php if (isset($transactionTypes)): ?>
                          <?php foreach ($transactionTypes as $row): ?>
                            <?php $value = $row['transaction_type']; ?>
                            <div class="multi-select-option" data-value="<?= htmlspecialchars($value) ?>">
                              <?= htmlspecialchars($value) ?>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <select class="multi-select-hidden" name="transaction_type[]" multiple>
                        <?php
                        $persistedTransaction = isset($_GET['transaction_type']) ? (array)$_GET['transaction_type'] : [];
                        if (isset($transactionTypes)):
                          foreach ($transactionTypes as $row):
                            $value = $row['transaction_type'];
                        ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= in_array($value, $persistedTransaction, true) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($value) ?>
                            </option>
                        <?php
                          endforeach;
                        endif;
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="text-right mt-3">
                  <button
                    type="submit"
                    name="action"
                    value="filter_generate"
                    class="btn btn-primary btn-report-submit js-report-action-btn"
                    data-loading-text="Generating...">
                    <span class="btn-default-content">
                      <img src="public/assets/images/generate_img.png" alt="icon" width="16.8" height="16.8"> Generate
                    </span>
                    <span class="btn-loading-content" aria-hidden="true">
                      <span class="btn-loading-spinner"></span>
                      <span class="btn-loading-text">Generating...</span>
                    </span>
                  </button>
                </div>
              </div>
              <div class="mt-4 p-3 pos-container-css">
                <h5 class="mb-3"><image src="public/assets/images/report_img.png" width="22" height="22"> Report</h5>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Index</label>
                    <div class="multi-select-wrapper" data-field-type="index">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Index">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php
                        $reportFields = [
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
                        foreach ($reportFields as $key => $label):
                        ?>
                          <div class="multi-select-option" data-value="<?= $key ?>">
                            <?= $label ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                      <select class="multi-select-hidden" name="index_field[]" multiple>
                        <?php
                        $persistedIndex = $usePersistedFilters && isset($_GET['index_field']) ? (array)$_GET['index_field'] : [];
                        foreach ($reportFields as $key => $label):
                        ?>
                          <option value="<?= $key ?>" <?= in_array($key, $persistedIndex, true) ? 'selected' : '' ?>>
                            <?= $label ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Column</label>
                    <div class="multi-select-wrapper" data-field-type="column">
                      <div class="multi-select-control">
                        <div class="multi-select-chips"></div>
                        <input type="text" class="multi-select-input-text" placeholder="Select Column">
                      </div>
                      <div class="multi-select-dropdown">
                        <?php foreach ($reportFields as $key => $label): ?>
                          <div class="multi-select-option" data-value="<?= $key ?>">
                            <?= $label ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                      <select class="multi-select-hidden" name="column_field[]" multiple>
                        <?php
                        $persistedColumn = $usePersistedFilters && isset($_GET['column_field']) ? (array)$_GET['column_field'] : [];
                        foreach ($reportFields as $key => $label):
                        ?>
                          <option value="<?= $key ?>" <?= in_array($key, $persistedColumn, true) ? 'selected' : '' ?>>
                            <?= $label ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Value</label>
                    <select class="form-control" name="value_field">
                      <?php
                      $valueFields = [
                        'amount' => 'Sales',
                        'quantity' => 'Quantity',
                        'unit_price' => 'Unit Price',
                        'transaction_number' => 'Transaction Number',
                      ];
                      $persistedValue = $usePersistedFilters && isset($_GET['value_field']) ? $_GET['value_field'] : null;
                      foreach ($valueFields as $key => $label):
                      ?>
                        <option value="<?= $key ?>" <?= $persistedValue === $key ? 'selected' : '' ?>>
                          <?= $label ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="text-right mt-3">
                  <button
                    type="submit"
                    name="action"
                    value="filter"
                    class="btn btn-primary btn-report-submit js-report-action-btn"
                    data-loading-text="Submitting...">
                    <span class="btn-default-content">
                      <img src="public/assets/images/submit_img.png" alt="icon" width="20" height="20"> Submit
                    </span>
                    <span class="btn-loading-content" aria-hidden="true">
                      <span class="btn-loading-spinner"></span>
                      <span class="btn-loading-text">Submitting...</span>
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card rg-container-css">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Report Generated</h3>
            <button
              type="submit"
              form="pos-export-form"
              class="btn btn-success btn-sm btn-report-export js-report-action-btn"
              data-loading-text="Exporting...">
              <span class="btn-default-content">
                <img src="public/assets/images/export_img1.png" alt="icon" width="20" height="20"> Export
              </span>
              <span class="btn-loading-content" aria-hidden="true">
                <span class="btn-loading-spinner"></span>
                <span class="btn-loading-text">Exporting...</span>
              </span>
            </button>
          </div>
          <div class="card-body">
            <?php if (!empty($previewRows)): ?>
              <p class="text-muted mb-2">
                Showing a preview of the first 30 rows. Export to view the full report.
              </p>
            <?php endif; ?>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <?php
                    // Check if we're in all-columns mode (set by controller)
                    $isAllColumnsMode = isset($showAllColumnsMode) && $showAllColumnsMode;
                    
                    if ($isAllColumnsMode && isset($allColumns)):
                      // All columns mode - show all column headers
                      foreach ($allColumns as $colName => $colLabel):
                    ?>
                        <th><?= htmlspecialchars($colLabel) ?></th>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <!-- Aggregated report mode -->
                      <?php
                      // Use the intelligently computed values from the controller
                      // ($selectedIndexFields and $selectedColumnFields are already set by the controller)
                      // If not set, use defaults
                      if (!isset($selectedIndexFields)) {
                          $selectedIndexFields = isset($_GET['index_field']) ? (array)$_GET['index_field'] : ['branch'];
                      }
                      if (!isset($selectedColumnFields)) {
                          $selectedColumnFields = isset($_GET['column_field']) ? (array)$_GET['column_field'] : ['product_name'];
                      }
                      
                      $currentValueField = $_GET['value_field'] ?? 'amount';

                      $validIndexFields = [];
                      foreach ($selectedIndexFields as $field) {
                        if (isset($reportFields[$field]) && !in_array($field, $validIndexFields, true)) {
                          $validIndexFields[] = $field;
                        }
                      }
                      if (empty($validIndexFields)) {
                        $validIndexFields = ['branch'];
                      }

                      $validColumnFields = [];
                      foreach ($selectedColumnFields as $field) {
                        if (isset($reportFields[$field]) && !in_array($field, $validColumnFields, true)) {
                          $validColumnFields[] = $field;
                        }
                      }
                      if (empty($validColumnFields)) {
                        $validColumnFields = ['product_name'];
                      }

                      $valueFields = [
                        'amount' => 'Sales',
                        'quantity' => 'Quantity',
                        'unit_price' => 'Unit Price',
                        'transaction_number' => 'Transaction Number',
                      ];

                      $hasIndexSelection = isset($_GET['index_field']);
                      $hasColumnSelection = isset($_GET['column_field']);
                      $hasValueSelection = isset($_GET['value_field']);

                      $showGenericHeader =
                        (isset($noData) && $noData) ||
                        (!$hasIndexSelection && !$hasColumnSelection && !$hasValueSelection && empty($reportRows));
                      ?>

                      <?php if ($showGenericHeader): ?>
                        <th>Index</th>
                        <th>Column</th>
                        <th class="text-right">Value</th>
                      <?php else: ?>
                        <?php foreach ($validIndexFields as $field): ?>
                          <th>
                            <?= htmlspecialchars($reportFields[$field] ?? $field) ?>
                          </th>
                        <?php endforeach; ?>

                        <?php foreach ($validColumnFields as $field): ?>
                          <th>
                            <?= htmlspecialchars($reportFields[$field] ?? $field) ?>
                          </th>
                        <?php endforeach; ?>

                        <th class="text-right">
                          <?= htmlspecialchars($valueFields[$currentValueField] ?? 'Value') ?>
                        </th>
                      <?php endif; ?>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($previewRows)): ?>
                    <?php
                    $isAllColumnsMode = isset($showAllColumnsMode) && $showAllColumnsMode;
                    
                    if ($isAllColumnsMode && isset($allColumns)):
                      // All columns mode - display all column values
                      foreach ($previewRows as $row): 
                    ?>
                        <tr>
                          <?php foreach (array_keys($allColumns) as $colName): ?>
                            <td><?= htmlspecialchars($row[$colName] ?? '') ?></td>
                          <?php endforeach; ?>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <!-- Aggregated report mode -->
                      <?php
                      $currentValueField = $_GET['value_field'] ?? 'amount';
                      $decimalFields = ['amount', 'unit_price', 'vat_amount'];
                      ?>
                      <?php foreach ($previewRows as $row): ?>
                        <?php
                        $metricRaw = $row['metric_value'] ?? 0;
                        if (in_array($currentValueField, $decimalFields, true)) {
                          $metricDisplay = number_format((float)$metricRaw, 2);
                        } else {
                          $metricDisplay = (string)(int)$metricRaw;
                        }
                        ?>
                        <tr>
                          <?php foreach ($validIndexFields as $field): ?>
                            <?php $key = 'index_' . $field; ?>
                            <td><?= htmlspecialchars($row[$key] ?? '') ?></td>
                          <?php endforeach; ?>

                          <?php foreach ($validColumnFields as $field): ?>
                            <?php $key = 'column_' . $field; ?>
                            <td><?= htmlspecialchars($row[$key] ?? '') ?></td>
                          <?php endforeach; ?>

                          <td class="text-right">
                            <?= htmlspecialchars($metricDisplay) ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  <?php else: ?>
                    <?php
                    $isAllColumnsMode = isset($showAllColumnsMode) && $showAllColumnsMode;
                    if ($isAllColumnsMode && isset($allColumns)):
                      $totalColumns = count($allColumns);
                    else:
                      $totalColumns = count($validIndexFields ?? []) + count($validColumnFields ?? []) + 1;
                    endif;
                    ?>
                    <tr>
                      <td colspan="<?= (int)$totalColumns ?>" class="text-center">
                        No records found. Please adjust your filters.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <?php
            $exportPaymentModes = isset($_GET['payment_mode']) ? (array)$_GET['payment_mode'] : [];
            $exportStores = isset($_GET['store']) ? (array)$_GET['store'] : [];
            $exportDiscounts = isset($_GET['discount']) ? (array)$_GET['discount'] : [];
            $exportProducts = isset($_GET['product_name']) ? (array)$_GET['product_name'] : [];
            $exportDepartments = isset($_GET['department_name']) ? (array)$_GET['department_name'] : [];
            $exportTransactionTypes = isset($_GET['transaction_type']) ? (array)$_GET['transaction_type'] : [];
            
            // Use the same intelligently computed fields from the controller
            $finalIndexFields = isset($selectedIndexFields) ? $selectedIndexFields : ['branch'];
            $finalColumnFields = isset($selectedColumnFields) ? $selectedColumnFields : ['product_name'];
            
            // Track if we're in all-columns mode for export
            $exportMode = isset($showAllColumnsMode) && $showAllColumnsMode ? 'all_columns' : 'aggregated';
            ?>
            <form id="pos-export-form" method="get" style="display:none;">
              <input type="hidden" name="start_date" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
              <input type="hidden" name="end_date" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
              <?php foreach ($exportPaymentModes as $value): ?>
                <input type="hidden" name="payment_mode[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php foreach ($exportStores as $value): ?>
                <input type="hidden" name="store[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php foreach ($exportDiscounts as $value): ?>
                <input type="hidden" name="discount[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php foreach ($exportProducts as $value): ?>
                <input type="hidden" name="product_name[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php foreach ($exportDepartments as $value): ?>
                <input type="hidden" name="department_name[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php foreach ($exportTransactionTypes as $value): ?>
                <input type="hidden" name="transaction_type[]" value="<?= htmlspecialchars($value) ?>">
              <?php endforeach; ?>
              <?php if ($exportMode === 'aggregated'): ?>
                <?php foreach ($finalIndexFields as $field): ?>
                  <input type="hidden" name="index_field[]" value="<?= htmlspecialchars($field) ?>">
                <?php endforeach; ?>
                <?php foreach ($finalColumnFields as $field): ?>
                  <input type="hidden" name="column_field[]" value="<?= htmlspecialchars($field) ?>">
                <?php endforeach; ?>
                <input type="hidden" name="value_field" value="<?= isset($_GET['value_field']) ? htmlspecialchars($_GET['value_field']) : 'amount' ?>">
              <?php endif; ?>
              <input type="hidden" name="export_mode" value="<?= htmlspecialchars($exportMode) ?>">
              <input type="hidden" name="action" value="export">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
<?php
require __DIR__ . "/../template/footer.php";
?>
<style>
  .btn-report-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 112px;
    padding-left: 7px;
    padding-right: 7px;
    font-size: 12px;
  }

  .btn-default-content,
  .btn-loading-content {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .btn-loading-content {
    display: none;
  }

  .js-report-action-btn.is-loading .btn-default-content {
    display: none;
  }

  .js-report-action-btn.is-loading .btn-loading-content {
    display: inline-flex;
  }

  .js-report-action-btn.is-loading {
    cursor: not-allowed;
    opacity: 0.9;
  }

  .btn-loading-spinner {
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255, 255, 255, 0.45);
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: report-btn-spin 0.8s linear infinite;
  }

  @keyframes report-btn-spin {
    to {
      transform: rotate(360deg);
    }
  }

  .btn-report-submit:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
    transform: translateY(-1px);
    box-shadow: 0 0.35rem 0.5rem rgba(0, 0, 0, .2);
  }

  .btn-report-export {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-width: 92px;
    padding-left: 5px;
    padding-right: 5px;
    font-size: 12px;
  }

  .btn-report-export:hover {
    background-color: #198754;
    border-color: #157347;
    transform: translateY(-1px);
    box-shadow: 0 0.35rem 0.5rem rgba(0, 0, 0, .2);
  }

  .pos-container-css {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    border-radius: 30px;
  }

  .rg-container-css {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  }

  .multi-select-wrapper {
    position: relative;
  }

  .multi-select-control {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 38px;
    padding: 4px 8px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    background-color: #fff;
    cursor: pointer;
  }

  .multi-select-chips {
    display: none;
  }

  .multi-select-input-section {
    display: flex;
    align-items: center;  
    flex: 1;
  }

  .multi-select-input-text {
    flex: 1;
    border: none;
    outline: none;
    padding: 2px 4px;
    font-size: 14px;
    min-width: 80px;
  }

  .multi-select-badge {
    display: inline-block;
    padding: 2px 8px;
    margin-left: 8px;
    background-color: #007bff;
    color: #fff;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
  }

  .multi-select-delete-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: #dc3545;
    padding: 2px 4px;
    line-height: 1;
    margin-left: auto;
    flex-shrink: 0;
  }

  .multi-select-delete-btn:hover {
    color: #c82333;
    font-weight: bold;
  }

  .multi-select-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1000;
    max-height: 220px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    margin-top: 2px;
    display: none;
  }

  .multi-select-dropdown.open {
    display: block;
  }

  .multi-select-option {
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
  }

  .multi-select-option:last-child {
    border-bottom: none;
  }

  .multi-select-option:hover {
    background-color: #f8f9fa;
  }

  .multi-select-option.selected {
    display: none;
  }

  .multi-select-hidden {
    display: none;
  }

  /* Modal Styles */
  .multi-select-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
  }

  .multi-select-modal-overlay.open {
    display: flex;
  }

  .multi-select-modal {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
  }

  .multi-select-modal-header {
    padding: 16px;
    border-bottom: 1px solid #ced4da;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .multi-select-modal-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
  }

  .multi-select-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #6c757d;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .multi-select-modal-close:hover {
    color: #000;
  }

  .multi-select-modal-body {
    padding: 16px;
    overflow-y: auto;
    flex: 1;
  }

  .multi-select-selected-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    margin-bottom: 8px;
    background-color: #f8f9fa;
    border-radius: 4px;
    border: 1px solid #e9ecef;
  }

  .multi-select-item-label {
    flex: 1;
    font-size: 14px;
    word-break: break-word;
  }

  .multi-select-item-remove {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 16px;
    padding: 0 0 0 8px;
    line-height: 1;
  }

  .multi-select-item-remove:hover {
    color: #c82333;
  }

  .multi-select-modal-empty {
    text-align: center;
    color: #6c757d;
    padding: 32px 16px;
    font-size: 14px;
  }

  .multi-select-modal-footer {
    padding: 12px 16px;
    border-top: 1px solid #ced4da;
    display: flex;
    gap: 8px;
    justify-content: flex-start;
  }

  .multi-select-modal-footer button {
    padding: 6px 12px;
    border-radius: 4px;
    border: 1px solid #ced4da;
    background-color: #fff;
    cursor: pointer;
    font-size: 14px;
  }

  .multi-select-modal-footer button:hover {
    background-color: #f8f9fa;
  }

  .multi-select-modal-footer .btn-primary {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
  }

  .multi-select-modal-footer .btn-primary:hover {
    background-color: #0056b3;
  }

  .multi-select-modal-footer .btn-success {
    background-color: #28a745;
    color: #fff;
    border-color: #28a745;
  }

  .multi-select-modal-footer .btn-success:hover {
    background-color: #218838;
  }

  .multi-select-modal-footer .btn-danger {
    background-color: #dc3545;
    color: #fff;
    border-color: #dc3545;
  }

  .multi-select-modal-footer .btn-danger:hover {
    background-color: #c82333;
  }

  /* Date Presets Styling */
  .date-presets-group {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 6px;
  }

  .date-presets-group .btn {
    flex: 1;
    min-width: 70px;
    padding: 5px 8px;
    font-size: 11px;
    white-space: nowrap;
    transition: all 0.3s ease;
  }

  .date-presets-group .btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
  }

  .date-presets-group .btn-outline-primary.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
  }

  @media (max-width: 576px) {
    .date-presets-group {
      gap: 4px;
    }
    
    .date-presets-group .btn {
      min-width: 60px;
      padding: 4px 6px;
      font-size: 10px;
    }
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var reportActionButtons = document.querySelectorAll(".js-report-action-btn");
    var exportResetTimeoutId = null;

    function setButtonLoadingState(button) {
      if (!button) {
        return;
      }
      var loadingText = button.getAttribute("data-loading-text");
      var loadingLabel = button.querySelector(".btn-loading-text");
      if (loadingText && loadingLabel) {
        loadingLabel.textContent = loadingText;
      }
      button.classList.add("is-loading");
      button.setAttribute("aria-busy", "true");
    }

    function resetAllReportActionButtons() {
      if (exportResetTimeoutId !== null) {
        clearTimeout(exportResetTimeoutId);
        exportResetTimeoutId = null;
      }

      reportActionButtons.forEach(function(button) {
        button.disabled = false;
        button.classList.remove("is-loading");
        button.removeAttribute("aria-busy");
      });
    }

    function attachSubmitLock(form) {
      if (!form || form.dataset.reportActionBound === "true") {
        return;
      }

      form.dataset.reportActionBound = "true";
      form.addEventListener("submit", function(event) {
        var submitter = event.submitter || document.activeElement;
        var isExportAction = submitter && submitter.classList.contains("btn-report-export");

        reportActionButtons.forEach(function(button) {
          button.disabled = true;
        });

        if (submitter && submitter.classList.contains("js-report-action-btn")) {
          setButtonLoadingState(submitter);
        }

        if (isExportAction) {
          // Downloads can keep the page active, so restore controls when focus returns.
          exportResetTimeoutId = window.setTimeout(function() {
            resetAllReportActionButtons();
          }, 10000);
        }
      });
    }

    if (reportActionButtons.length > 0) {
      reportActionButtons.forEach(function(button) {
        var formId = button.getAttribute("form");
        var targetForm = formId ? document.getElementById(formId) : button.closest("form");
        attachSubmitLock(targetForm);
      });

      window.addEventListener("focus", function() {
        resetAllReportActionButtons();
      });

      window.addEventListener("pageshow", function() {
        resetAllReportActionButtons();
      });
    }

    var startPicker = flatpickr("#start_date", {
      dateFormat: "Y-m-d"
    });
    var endPicker = flatpickr("#end_date", {
      dateFormat: "Y-m-d"
    });
    var startIcon = document.getElementById("start_date_icon");
    if (startIcon) {
      startIcon.addEventListener("click", function() {
        startPicker.open();
      });
    }
    var endIcon = document.getElementById("end_date_icon");
    if (endIcon) {
      endIcon.addEventListener("click", function() {
        endPicker.open();
      });
    }

    function initMultiSelect(wrapper) {
      var control = wrapper.querySelector(".multi-select-control");
      var inputSection = wrapper.querySelector(".multi-select-input-section") || control;
      var input = wrapper.querySelector(".multi-select-input-text");
      var dropdown = wrapper.querySelector(".multi-select-dropdown");
      var select = wrapper.querySelector("select.multi-select-hidden");
      var options = dropdown.querySelectorAll(".multi-select-option");

      // Create modal overlay and modal
      var modalOverlay = document.createElement("div");
      modalOverlay.className = "multi-select-modal-overlay";

      var modal = document.createElement("div");
      modal.className = "multi-select-modal";

      var modalHeader = document.createElement("div");
      modalHeader.className = "multi-select-modal-header";

      var fieldType = wrapper.getAttribute("data-field-type");
      var modalTitle = document.createElement("h2");
      modalTitle.className = "multi-select-modal-title";
      modalTitle.textContent = "Selected Items";

      var modalClose = document.createElement("button");
      modalClose.className = "multi-select-modal-close";
      modalClose.type = "button";
      modalClose.textContent = "×";
      modalClose.addEventListener("click", function() {
        modalOverlay.classList.remove("open");
      });

      modalHeader.appendChild(modalTitle);
      modalHeader.appendChild(modalClose);

      var modalBody = document.createElement("div");
      modalBody.className = "multi-select-modal-body";

      var modalFooter = document.createElement("div");
      modalFooter.className = "multi-select-modal-footer";

      var clearBtn = document.createElement("button");
      clearBtn.textContent = "Clear All";
      clearBtn.type = "button";
      clearBtn.className = "btn-danger";
      clearBtn.addEventListener("click", function() {
        // Clear all selected items
        select.querySelectorAll("option").forEach(function(opt) {
          opt.selected = false;
        });
        // Remove selected class from dropdown options
        dropdown.querySelectorAll('.multi-select-option').forEach(function(opt) {
          opt.classList.remove("selected");
        });
        updateModal();
        updateBadge();
        filter();
      });

      modalFooter.appendChild(clearBtn);

      modal.appendChild(modalHeader);
      modal.appendChild(modalBody);
      modal.appendChild(modalFooter);

      modalOverlay.appendChild(modal);
      document.body.appendChild(modalOverlay);

      // Update modal content
      function updateModal() {
        var selectedItems = select.querySelectorAll("option:checked");
        modalBody.innerHTML = "";

        if (selectedItems.length === 0) {
          var empty = document.createElement("div");
          empty.className = "multi-select-modal-empty";
          empty.textContent = "No items selected";
          modalBody.appendChild(empty);
        } else {
          selectedItems.forEach(function(opt) {
            var value = opt.value;
            var label = opt.textContent.trim();

            var item = document.createElement("div");
            item.className = "multi-select-selected-item";

            var itemLabel = document.createElement("div");
            itemLabel.className = "multi-select-item-label";
            itemLabel.textContent = label;

            var removeBtn = document.createElement("button");
            removeBtn.className = "multi-select-item-remove";
            removeBtn.type = "button";
            removeBtn.textContent = "×";
            removeBtn.addEventListener("click", function(e) {
              e.preventDefault();
              opt.selected = false;
              var optionInDropdown = dropdown.querySelector('.multi-select-option[data-value="' + value + '"]');
              if (optionInDropdown) {
                optionInDropdown.classList.remove("selected");
              }
              updateModal();
              updateBadge();
              filter();
            });

            item.appendChild(itemLabel);
            item.appendChild(removeBtn);
            modalBody.appendChild(item);
          });
        }
      }

      // Update badge
      function updateBadge() {
        var selectedCount = select.querySelectorAll("option:checked").length;
        var existingBadge = control.querySelector(".multi-select-badge");
        var existingDeleteBtn = control.querySelector(".multi-select-delete-btn");

        if (selectedCount === 1) {
          // Single selection - display in input field with delete button
          var selectedOption = select.querySelector("option:checked");
          var selectedValue = selectedOption ? selectedOption.value : null;
          if (selectedOption) {
            input.placeholder = selectedOption.textContent.trim();
            input.value = "";
          }
          if (existingBadge) {
            existingBadge.remove();
          }
          // Create delete button if it doesn't exist
          if (!existingDeleteBtn) {
            var deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.className = "multi-select-delete-btn";
            deleteBtn.textContent = "×";
            deleteBtn.addEventListener("click", function(e) {
              e.preventDefault();
              e.stopPropagation();
              // Clear the selection
              select.querySelectorAll("option").forEach(function(opt) {
                opt.selected = false;
              });
              // Remove selected class from dropdown options
              dropdown.querySelectorAll('.multi-select-option').forEach(function(opt) {
                opt.classList.remove("selected");
              });
              updateBadge();
              filter();
            });
            control.appendChild(deleteBtn);
          }
        } else if (selectedCount > 1) {
          // Multiple selections - show first item + more indicator
          var selectedOptions = select.querySelectorAll("option:checked");
          var firstItem = selectedOptions[0].textContent.trim();
          var remainingCount = selectedCount - 1;
          input.placeholder = firstItem + ", +" + remainingCount + " more";
          input.value = "";

          // Remove delete button for multi-select (modal will handle removals)
          if (existingDeleteBtn) {
            existingDeleteBtn.remove();
          }

          if (!existingBadge) {
            var badge = document.createElement("span");
            badge.className = "multi-select-badge";
            control.appendChild(badge);
            existingBadge = badge;
          }
          existingBadge.textContent = selectedCount + " selected";
          existingBadge.addEventListener("click", function(e) {
            e.stopPropagation();
            modalOverlay.classList.add("open");
            updateModal();
          });
        } else {
          // No selection
          input.placeholder = "Select items";
          if (existingBadge) {
            existingBadge.remove();
          }
          if (existingDeleteBtn) {
            existingDeleteBtn.remove();
          }
        }
      }

      // Initialize with existing selections
      select.querySelectorAll("option").forEach(function(opt) {
        if (opt.selected) {
          var value = opt.value;
          var optionInDropdown = dropdown.querySelector('.multi-select-option[data-value="' + value + '"]');
          if (optionInDropdown) {
            optionInDropdown.classList.add("selected");
          }
        }
      });
      updateBadge();

      function openDropdown() {
        dropdown.classList.add("open");
      }

      function closeDropdown() {
        dropdown.classList.remove("open");
      }

      function selectValue(value, label) {
        var optionInSelect = select.querySelector('option[value="' + value + '"]');
        if (optionInSelect) {
          if (optionInSelect.selected) {
            return;
          }
          optionInSelect.selected = true;
        }
        var optionInDropdown = dropdown.querySelector('.multi-select-option[data-value="' + value + '"]');
        if (optionInDropdown) {
          optionInDropdown.classList.add("selected");
        }
        input.value = "";
        updateBadge();
        filter();
      }

      function filter() {
        var term = input.value.toLowerCase();
        options.forEach(function(option) {
          var text = option.textContent.toLowerCase();
          if (text.indexOf(term) !== -1 && !option.classList.contains("selected")) {
            option.style.display = "";
          } else if (option.classList.contains("selected")) {
            option.style.display = "";
          } else {
            option.style.display = "none";
          }
        });
      }

      options.forEach(function(option) {
        option.addEventListener("click", function(e) {
          e.stopPropagation();
          var value = option.getAttribute("data-value");
          var label = option.textContent.trim();
          selectValue(value, label);
          openDropdown();
        });
      });

      control.addEventListener("click", function(e) {
        if (e.target.classList.contains("multi-select-badge")) {
          return;
        }
        input.focus();
        openDropdown();
      });

      input.addEventListener("focus", function() {
        openDropdown();
      });

      input.addEventListener("input", function() {
        filter();
      });

      document.addEventListener("click", function(e) {
        if (!wrapper.contains(e.target) && !modalOverlay.contains(e.target)) {
          closeDropdown();
        }
      });

      // Close modal when clicking overlay
      modalOverlay.addEventListener("click", function(e) {
        if (e.target === modalOverlay) {
          modalOverlay.classList.remove("open");
        }
      });
    }

    var multiSelectWrappers = document.querySelectorAll(".multi-select-wrapper");
    multiSelectWrappers.forEach(function(wrapper) {
      initMultiSelect(wrapper);
    });

    // Date Preset Functionality
    var datePresetButtons = document.querySelectorAll(".date-preset");
    var startDateInput = document.getElementById("start_date");
    var endDateInput = document.getElementById("end_date");

    function formatDate(date) {
      var year = date.getFullYear();
      var month = String(date.getMonth() + 1).padStart(2, "0");
      var day = String(date.getDate()).padStart(2, "0");
      return year + "-" + month + "-" + day;
    }

    function getMonday(date) {
      var d = new Date(date);
      var day = d.getDay();
      var diff = d.getDate() - day + (day === 0 ? -6 : 1);
      return new Date(d.setDate(diff));
    }

    function applyPreset(preset) {
      var today = new Date();
      var start, end;

      switch(preset) {
        case "today":
          start = new Date(today);
          end = new Date(today);
          break;
        case "this-week":
          start = getMonday(today);
          end = new Date(today);
          break;
        case "this-month":
          start = new Date(today.getFullYear(), today.getMonth(), 1);
          end = new Date(today);
          break;
        case "last-month":
          start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
          end = new Date(today.getFullYear(), today.getMonth(), 0);
          break;
        case "last-quarter":
          var quarterStart = Math.floor(today.getMonth() / 3) - 1;
          var year = today.getFullYear();
          if (quarterStart < 0) {
            quarterStart = 3;
            year--;
          }
          start = new Date(year, quarterStart * 3, 1);
          end = new Date(year, quarterStart * 3 + 3, 0);
          break;
        default:
          return;
      }

      // Set the date inputs using flatpickr
      if (startPicker && endPicker) {
        startPicker.setDate(start, true);
        endPicker.setDate(end, true);
      } else {
        startDateInput.value = formatDate(start);
        endDateInput.value = formatDate(end);
      }

      // Update button active state
      datePresetButtons.forEach(function(btn) {
        btn.classList.remove("active");
      });
      document.querySelector('[data-preset="' + preset + '"]').classList.add("active");
    }

    datePresetButtons.forEach(function(button) {
      button.addEventListener("click", function(e) {
        e.preventDefault();
        var preset = button.getAttribute("data-preset");
        applyPreset(preset);
      });
    });
  });
</script>