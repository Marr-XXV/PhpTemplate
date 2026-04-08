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
    <?php if (!empty($filterLoadError)): ?>
      <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <strong>Database error:</strong> <?= htmlspecialchars($filterLoadError) ?> — filter options could not be loaded. Please try again or contact support.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <?php if (!empty($queryError)): ?>
      <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <strong>Report error:</strong> <?= htmlspecialchars($queryError) ?> — please adjust your filters and try again.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <?php if (!empty($aggregatedValidationError)): ?>
      <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        <strong>Validation:</strong> <?= htmlspecialchars($aggregatedValidationError) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <?php if (!empty($filterInputWarning)): ?>
      <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
        <strong>Invalid filter value:</strong> <?= htmlspecialchars($filterInputWarning) ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-12">
        <div class="card pos-container-css">
          <div class="card-body">
            <div class="col-12 text-center">
              <h3 class="mb-0">Point-of-Sale (POS) Sales Reports</h3>
            </div>
            <form method="get">
              <div id="filter-ui-section" class="mt-4 p-3 pos-container-css">
                <h5 class="mb-3"><image src="public/assets/images/filter_img.png" width="22" height="22"> Filter</h5>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date</label>
                    <div class="input-group date-input-group">
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
                      <button
                        type="button"
                        class="date-error-trigger"
                        id="start_date_error_trigger"
                        aria-label="Show Start Date validation message"
                        aria-describedby="start_date_error_tooltip"
                        aria-expanded="false"
                        hidden>!</button>
                      <div class="date-error-tooltip" id="start_date_error_tooltip" role="tooltip" aria-hidden="true"></div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="start_date_icon">
                          <image src="public/assets/images/calendar.png" width="24" height="24">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">End Date</label>
                    <div class="input-group date-input-group">
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
                      <button
                        type="button"
                        class="date-error-trigger"
                        id="end_date_error_trigger"
                        aria-label="Show End Date validation message"
                        aria-describedby="end_date_error_tooltip"
                        aria-expanded="false"
                        hidden>!</button>
                      <div class="date-error-tooltip" id="end_date_error_tooltip" role="tooltip" aria-hidden="true"></div>
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
                <div class="d-flex justify-content-start align-items-center flex-wrap mt-3" style="gap: 8px;">
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
                  <button
                    type="button"
                    id="reset_filters_btn"
                    class="btn btn-secondary btn-report-submit btn-report-reset">
                    <image src="public/assets/images/reset_img.png" alt="RESET" width="16.3" height="16.3"> Reset
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
                        $persistedIndex = isset($_GET['index_field']) ? (array)$_GET['index_field'] : [];
                        foreach ($reportFields as $key => $label):
                        ?>
                          <option value="<?= $key ?>" <?= in_array($key, $persistedIndex, true) ? 'selected' : '' ?>>
                            <?= $label ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="invalid-feedback" id="report_index_feedback" style="display:none;font-size:12px;color:#dc3545;margin-top:4px;">Index is required</div>
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
                        $persistedColumn = isset($_GET['column_field']) ? (array)$_GET['column_field'] : [];
                        foreach ($reportFields as $key => $label):
                        ?>
                          <option value="<?= $key ?>" <?= in_array($key, $persistedColumn, true) ? 'selected' : '' ?>>
                            <?= $label ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="invalid-feedback" id="report_column_feedback" style="display:none;font-size:12px;color:#dc3545;margin-top:4px;">Column is required</div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Value</label>
                    <select class="form-control" name="value_field">
                      <option value="" <?= !isset($_GET['value_field']) || $_GET['value_field'] === '' ? 'selected' : '' ?>>Select Value</option>
                      <?php
                      $valueFields = [
                        'amount' => 'Sales',
                        'quantity' => 'Quantity',
                        'unit_price' => 'Unit Price',
                        'transaction_number' => 'Transaction Number',
                      ];
                      $persistedValue = isset($_GET['value_field']) ? $_GET['value_field'] : null;
                      foreach ($valueFields as $key => $label):
                      ?>
                        <option value="<?= $key ?>" <?= $persistedValue === $key ? 'selected' : '' ?>>
                          <?= $label ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback" id="report_value_feedback" style="display:none;font-size:12px;color:#dc3545;margin-top:4px;">Value is required</div>
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
        <div id="report-generated-section" class="card rg-container-css">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Report Generated</h3>
            <?php
            $canExport = !empty($reportRows) && empty($queryError) && empty($aggregatedValidationError);
            ?>
            <button
              type="submit"
              form="pos-export-form"
              class="btn btn-success btn-sm btn-report-export js-report-action-btn<?= $canExport ? '' : ' disabled' ?>"
              <?= $canExport ? '' : 'disabled aria-disabled="true" title="Generate a report with results before exporting."' ?>
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
          <div class="card-body report-generated-body">
            <div class="report-preview-loading" aria-hidden="true">
              <span class="report-preview-loading-spinner"></span>
              <span class="report-preview-loading-text">Loading...</span>
            </div>
            <?php if (!empty($previewRows)): ?>
              <p class="text-muted mb-2">
                Showing a preview of the first 20 rows. Export to view the full report.
              </p>
            <?php endif; ?>
            <?php if (!empty($_GET['store'])): ?>
              <p class="text-muted mb-2">
                The selected Store filters from the Filter section are applied to this report.
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
                          $selectedIndexFields = isset($_GET['index_field']) ? (array)$_GET['index_field'] : [];
                      }
                      if (!isset($selectedColumnFields)) {
                          $selectedColumnFields = isset($_GET['column_field']) ? (array)$_GET['column_field'] : [];
                      }
                      
                      $currentValueField = $_GET['value_field'] ?? 'amount';

                      $validIndexFields = [];
                      foreach ($selectedIndexFields as $field) {
                        if (isset($reportFields[$field]) && !in_array($field, $validIndexFields, true)) {
                          $validIndexFields[] = $field;
                        }
                      }

                      $validColumnFields = [];
                      foreach ($selectedColumnFields as $field) {
                        if (isset($reportFields[$field]) && !in_array($field, $validColumnFields, true)) {
                          $validColumnFields[] = $field;
                        }
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
                    $reportRequested = isset($action) && in_array($action, ['filter_generate', 'filter', 'export'], true);

                    if ($isAllColumnsMode && isset($allColumns)):
                      $totalColumns = count($allColumns);
                    else:
                      $totalColumns = count($validIndexFields ?? []) + count($validColumnFields ?? []) + 1;
                    endif;

                    if (!empty($queryError) || !empty($filterLoadError)) {
                      $rowEmptyMessage = 'Report unavailable. Please try again.';
                    } elseif (!empty($aggregatedValidationError) || !empty($filterInputWarning)) {
                      $rowEmptyMessage = 'Check your selected values and submit again.';
                    } elseif (!empty($reportEmptyStateMessage) || $reportRequested) {
                      $rowEmptyMessage = 'No matching data found.';
                    } else {
                      $rowEmptyMessage = 'Generate a report to view results.';
                    }
                    ?>
                    <tr>
                      <td colspan="<?= (int)$totalColumns ?>" class="text-center">
                        <?= htmlspecialchars($rowEmptyMessage) ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <?php
            // Validate export filter values against known allowed options before
            // echoing them into the hidden form, so tampered URLs cannot inject
            // unexpected values into the export request.
            $allowedPaymentModes   = array_column($paymentModes   ?? [], 'payment_name');
            $allowedStores         = array_column($stores         ?? [], 'branch');
            $allowedDiscounts      = array_column($discounts      ?? [], 'discount_name');
            $allowedProducts       = array_column($productNames   ?? [], 'product_name');
            $allowedDepartments    = array_column($departments    ?? [], 'department_name');
            $allowedTransactions   = array_column($transactionTypes ?? [], 'transaction_type');

            $exportPaymentModes      = array_values(array_intersect((array)($_GET['payment_mode']    ?? []), $allowedPaymentModes));
            $exportStores            = array_values(array_intersect((array)($_GET['store']           ?? []), $allowedStores));
            $exportDiscounts         = array_values(array_intersect((array)($_GET['discount']        ?? []), $allowedDiscounts));
            $exportProducts          = array_values(array_intersect((array)($_GET['product_name']    ?? []), $allowedProducts));
            $exportDepartments       = array_values(array_intersect((array)($_GET['department_name'] ?? []), $allowedDepartments));
            $exportTransactionTypes  = array_values(array_intersect((array)($_GET['transaction_type']?? []), $allowedTransactions));
            
            // Use the same intelligently computed fields from the controller
            $finalIndexFields = isset($selectedIndexFields) ? $selectedIndexFields : [];
            $finalColumnFields = isset($selectedColumnFields) ? $selectedColumnFields : [];
            
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
$reportNoticeTitle = 'Report Notice';
$reportNoticeMessage = '';
$reportNoticeAutoOpen = false;

if (!empty($filterLoadError)) {
  $reportNoticeTitle = 'Database error';
  $reportNoticeMessage = $filterLoadError . ' Filter options could not be loaded.';
} elseif (!empty($queryError)) {
  $reportNoticeTitle = 'Report error';
  $reportNoticeMessage = $queryError . ' Please adjust your filters and try again.';
} elseif (!empty($aggregatedValidationError)) {
  $reportNoticeTitle = 'Validation warning';
  $reportNoticeMessage = $aggregatedValidationError;
} elseif (!empty($filterInputWarning)) {
  $reportNoticeTitle = 'Invalid filter value';
  $reportNoticeMessage = $filterInputWarning;
} elseif (!empty($reportEmptyStateMessage)) {
  $reportNoticeTitle = 'No matching data';
  $reportNoticeMessage = $reportEmptyStateMessage;
}
$reportNoticeAutoOpen = $reportNoticeMessage !== '';
?>

  <div id="report-notice-modal" class="report-notice-modal" role="dialog" aria-modal="true" aria-labelledby="report-notice-title" aria-hidden="true" data-auto-open="<?= $reportNoticeAutoOpen ? 'true' : 'false' ?>">
    <div class="report-notice-modal__backdrop" data-report-notice-close></div>
    <div class="report-notice-modal__panel" role="document">
      <div class="report-notice-modal__header">
        <h4 id="report-notice-title" class="mb-0 d-flex align-items-center" style="gap: 10px;">
          <img src="public/assets/images/Warning_Icon.png" alt="Warning" width="24" height="24">
          <span id="report-notice-title-text"><?= htmlspecialchars($reportNoticeTitle) ?></span>
        </h4>
        <button type="button" class="report-notice-modal__close" data-report-notice-close aria-label="Close">&times;</button>
      </div>
      <div class="report-notice-modal__body">
        <p id="report-notice-message-text" class="mb-0"><?= htmlspecialchars($reportNoticeMessage) ?></p>
      </div>
      <div class="report-notice-modal__footer">
        <button type="button" class="btn btn-primary" data-report-notice-close>OK</button>
      </div>
    </div>
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

  #reset_filters_btn,
  #reset_filters_btn:hover,
  #reset_filters_btn:focus,
  #reset_filters_btn:active {
    background-color: #b1b1b1 !important;
    border-color: #b1b1b1 !important;
    color: #242424 !important;
    font-family: inherit;
    font-size: 12px;
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

  .report-notice-modal {
    position: fixed;
    inset: 0;
    z-index: 3000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
  }

  .report-notice-modal.is-open {
    display: flex;
  }

  .report-notice-modal__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
  }

  .report-notice-modal__panel {
    position: relative;
    z-index: 1;
    width: min(100%, 520px);
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
    overflow: hidden;
  }

  .report-notice-modal__header,
  .report-notice-modal__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 20px;
  }

  .report-notice-modal__header {
    border-bottom: 1px solid #e9ecef;
  }

  .report-notice-modal__body {
    padding: 20px;
    color: #495057;
    line-height: 1.6;
  }

  .report-notice-modal__footer {
    border-top: 1px solid #e9ecef;
    justify-content: flex-end;
  }

  .report-notice-modal__close {
    appearance: none;
    border: 0;
    background: transparent;
    font-size: 28px;
    line-height: 1;
    color: #6c757d;
    cursor: pointer;
    padding: 0;
  }

  .report-notice-modal__close:hover {
    color: #212529;
  }

  .pos-container-css {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    border-radius: 30px;
  }

  .rg-container-css {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
  }

  .report-generated-body {
    position: relative;
  }

  .report-preview-loading {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.85);
    display: none;
    align-items: center;
    justify-content: center;
    gap: 8px;
    z-index: 5;
    font-weight: 600;
    color: #0b5ed7;
  }

  .report-generated-body.is-loading .report-preview-loading {
    display: flex;
  }

  .report-preview-loading-spinner {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(11, 94, 215, 0.25);
    border-top-color: #0b5ed7;
    border-radius: 50%;
    animation: report-btn-spin 0.8s linear infinite;
  }

  .multi-select-wrapper {
    position: relative;
  }

  .multi-select-wrapper.is-invalid .multi-select-control {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
  }

  .form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
  }

  .date-input-group {
    position: relative;
  }

  .date-input-group .form-control.is-invalid {
    background-image: none;
    padding-right: 0.75rem;
  }

  .date-error-trigger {
    appearance: none;
    -webkit-appearance: none;
    position: absolute;
    top: 50%;
    right: 52px;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    min-width: 18px;
    min-height: 18px;
    border: 1px solid #dc3545;
    border-radius: 9999px !important;
    background: #fff3cd;
    color: #8a4200;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    overflow: hidden;
    z-index: 4;
  }

  .date-error-trigger.is-visible {
    display: inline-flex;
  }

  .date-error-trigger:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.2);
  }

  .date-error-tooltip {
    position: absolute;
    top: calc(100% + 6px);
    right: 52px;
    max-width: 280px;
    background: #1f2937;
    color: #ffffff;
    font-size: 12px;
    line-height: 1.35;
    padding: 8px 10px;
    border-radius: 6px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 1000;
  }

  .date-error-tooltip::before {
    content: "";
    position: absolute;
    top: -5px;
    right: 10px;
    width: 10px;
    height: 10px;
    background: #1f2937;
    transform: rotate(45deg);
  }

  .date-error-tooltip.is-visible {
    display: block;
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
    var reportGeneratedSection = document.getElementById("report-generated-section");
    var reportGeneratedBody = document.querySelector(".report-generated-body");
    var reportNoticeModal = document.getElementById("report-notice-modal");
    var reportNoticeModalTitle = document.getElementById("report-notice-title-text");
    var reportNoticeModalMessage = document.getElementById("report-notice-message-text");
    var reportNoticeShouldAutoOpen = reportNoticeModal && reportNoticeModal.getAttribute("data-auto-open") === "true";
    var multiSelectFieldLabels = {
      payment_mode: "Payment Mode",
      store: "Store",
      discount: "Discount",
      product_name: "Product Name",
      department_name: "Department Name",
      transaction_type: "Transaction Type",
      index: "Index",
      column: "Column"
    };

    function openReportNoticeModal() {
      if (!reportNoticeModal) {
        return;
      }

      reportNoticeModal.classList.add("is-open");
      reportNoticeModal.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    }

    function closeReportNoticeModal() {
      if (!reportNoticeModal) {
        return;
      }

      reportNoticeModal.classList.remove("is-open");
      reportNoticeModal.setAttribute("aria-hidden", "true");
      document.body.style.overflow = "";
    }

    function showReportNotice(title, message) {
      if (reportNoticeModalTitle) {
        reportNoticeModalTitle.textContent = title;
      }

      if (reportNoticeModalMessage) {
        reportNoticeModalMessage.textContent = message;
      }

      openReportNoticeModal();
    }

    function getSelectedLabelList(labels) {
      if (labels.length === 0) {
        return "";
      }

      if (labels.length === 1) {
        return labels[0];
      }

      if (labels.length === 2) {
        return labels[0] + " and " + labels[1];
      }

      return labels.slice(0, -1).join(", ") + ", and " + labels[labels.length - 1];
    }

    function validateTypedMultiSelectInputs() {
      var invalidFields = [];

      document.querySelectorAll(".multi-select-wrapper").forEach(function(wrapper) {
        var input = wrapper.querySelector(".multi-select-input-text");
        var select = wrapper.querySelector("select.multi-select-hidden");

        if (!input || !select) {
          return;
        }

        if (input.value.trim() === "") {
          return;
        }

        var fieldType = wrapper.getAttribute("data-field-type");
        invalidFields.push({
          fieldLabel: multiSelectFieldLabels[fieldType] || "one of the filters",
          typedValue: input.value.trim()
        });
      });

      return invalidFields;
    }

    function validateReportSubmitConfiguration(form) {
      if (!form) {
        return {
          isValid: true,
          missingFields: [],
          hasIndex: true,
          hasColumn: true,
          hasValue: true
        };
      }

      var indexSelect = form.querySelector('select[name="index_field[]"]');
      var columnSelect = form.querySelector('select[name="column_field[]"]');
      var valueSelect = form.querySelector('select[name="value_field"]');
      var missingFields = [];

      var hasIndex = indexSelect && indexSelect.querySelectorAll("option:checked").length > 0;
      var hasColumn = columnSelect && columnSelect.querySelectorAll("option:checked").length > 0;
      var hasValue = valueSelect && valueSelect.value && valueSelect.value.trim() !== "";

      if (!hasIndex) {
        missingFields.push("Index");
      }

      return {
        isValid: hasIndex,
        missingFields: missingFields,
        hasIndex: hasIndex,
        hasColumn: hasColumn,
        hasValue: hasValue
      };
    }

    function clearReportSubmitConfigurationState(form) {
      if (!form) {
        return;
      }

      var indexWrapper = form.querySelector('.multi-select-wrapper[data-field-type="index"]');
      var columnWrapper = form.querySelector('.multi-select-wrapper[data-field-type="column"]');
      var valueSelect = form.querySelector('select[name="value_field"]');
      var indexFeedback = document.getElementById("report_index_feedback");
      var columnFeedback = document.getElementById("report_column_feedback");
      var valueFeedback = document.getElementById("report_value_feedback");

      if (indexWrapper) {
        indexWrapper.classList.remove("is-invalid");
      }

      if (columnWrapper) {
        columnWrapper.classList.remove("is-invalid");
      }

      if (valueSelect) {
        valueSelect.classList.remove("is-invalid");
      }

      if (indexFeedback) {
        indexFeedback.style.display = "none";
      }

      if (columnFeedback) {
        columnFeedback.style.display = "none";
      }

      if (valueFeedback) {
        valueFeedback.style.display = "none";
      }
    }

    function showReportSubmitConfigurationState(form, validationResult) {
      if (!form || !validationResult || validationResult.isValid) {
        clearReportSubmitConfigurationState(form);
        return;
      }

      var indexWrapper = form.querySelector('.multi-select-wrapper[data-field-type="index"]');
      var columnWrapper = form.querySelector('.multi-select-wrapper[data-field-type="column"]');
      var valueSelect = form.querySelector('select[name="value_field"]');
      var indexFeedback = document.getElementById("report_index_feedback");
      var columnFeedback = document.getElementById("report_column_feedback");
      var valueFeedback = document.getElementById("report_value_feedback");

      if (indexWrapper) {
        indexWrapper.classList.toggle("is-invalid", !validationResult.hasIndex);
      }

      if (columnWrapper) {
        columnWrapper.classList.remove("is-invalid");
      }

      if (valueSelect) {
        valueSelect.classList.remove("is-invalid");
      }

      if (indexFeedback) {
        indexFeedback.style.display = !validationResult.hasIndex ? "block" : "none";
      }

      if (columnFeedback) {
        columnFeedback.style.display = "none";
      }

      if (valueFeedback) {
        valueFeedback.style.display = "none";
      }
    }

    if (reportNoticeModal) {
      reportNoticeModal.querySelectorAll("[data-report-notice-close]").forEach(function(trigger) {
        trigger.addEventListener("click", closeReportNoticeModal);
      });

      document.addEventListener("keydown", function(event) {
        if (event.key === "Escape") {
          closeReportNoticeModal();
        }
      });

      if (reportNoticeShouldAutoOpen) {
        window.setTimeout(openReportNoticeModal, 50);
      }
    }

    function shouldAutoScrollToReport() {
      var urlParams = new URLSearchParams(window.location.search);
      var action = urlParams.get("action");
      var fromSubmit = sessionStorage.getItem("pos-scroll-to-report") === "1";
      var fromAction = action === "filter_generate" || action === "filter";
      return fromSubmit || fromAction;
    }

    function scrollToReportSection() {
      if (!reportGeneratedSection || !shouldAutoScrollToReport()) {
        return;
      }
      sessionStorage.removeItem("pos-scroll-to-report");
      window.setTimeout(function() {
        reportGeneratedSection.scrollIntoView({ behavior: "smooth", block: "start" });
      }, 150);
    }

    function triggerImmediateReportScroll() {
      if (!reportGeneratedSection) {
        return;
      }
      reportGeneratedSection.scrollIntoView({ behavior: "smooth", block: "start" });
    }

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
        var submitActionValue = submitter && submitter.name === "action" ? submitter.value : "";
        var isPreviewGenerationAction = submitActionValue === "filter_generate" || submitActionValue === "filter";
        var invalidTypedFields = validateTypedMultiSelectInputs();
        clearReportSubmitConfigurationState(form);

        if (submitActionValue === "filter") {
          var reportConfigValidation = validateReportSubmitConfiguration(form);

          if (!reportConfigValidation.isValid) {
            event.preventDefault();
            event.stopPropagation();
            if (typeof event.stopImmediatePropagation === "function") {
              event.stopImmediatePropagation();
            }

            showReportSubmitConfigurationState(form, reportConfigValidation);

            resetAllReportActionButtons();
            return;
          }
        }

        if (invalidTypedFields.length > 0) {
          event.preventDefault();
          event.stopPropagation();
          if (typeof event.stopImmediatePropagation === "function") {
            event.stopImmediatePropagation();
          }

          var invalidDescriptions = invalidTypedFields.map(function(item) {
            return '"' + item.typedValue + '" in ' + item.fieldLabel;
          });

          showReportNotice(
            "Invalid input",
            "The value " + getSelectedLabelList(invalidDescriptions) + " was not recognized. Please select a valid option from the dropdown before submitting the report."
          );

          resetAllReportActionButtons();
          return;
        }

        reportActionButtons.forEach(function(button) {
          button.disabled = true;
        });

        if (submitter && submitter.classList.contains("js-report-action-btn")) {
          setButtonLoadingState(submitter);
        }

        if (isPreviewGenerationAction) {
          sessionStorage.setItem("pos-scroll-to-report", "1");
          triggerImmediateReportScroll();
          if (reportGeneratedBody) {
            reportGeneratedBody.classList.add("is-loading");
          }
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

      scrollToReportSection();
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
      var optionMeta = Array.prototype.map.call(options, function(option, index) {
        return {
          option: option,
          index: index,
          text: option.textContent.trim(),
          lowerText: option.textContent.toLowerCase().trim()
        };
      });

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

      wrapper.addEventListener("multi-select-reset", function() {
        select.querySelectorAll("option").forEach(function(opt) {
          opt.selected = false;
        });

        dropdown.querySelectorAll(".multi-select-option").forEach(function(opt) {
          opt.classList.remove("selected");
          opt.style.display = "";
        });

        dropdown.classList.remove("open");
        input.value = "";
        updateBadge();
        filter();
      });

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
        select.dispatchEvent(new Event("change", { bubbles: true }));
      }

      function getMatchRank(optionLowerText, term) {
        if (!term) {
          return 0;
        }

        if (optionLowerText.indexOf(term) === 0) {
          return 0;
        }

        if (
          optionLowerText.indexOf(" " + term) !== -1 ||
          optionLowerText.indexOf("-" + term) !== -1 ||
          optionLowerText.indexOf("_" + term) !== -1 ||
          optionLowerText.indexOf("/" + term) !== -1
        ) {
          return 1;
        }

        if (optionLowerText.indexOf(term) !== -1) {
          return 2;
        }

        return -1;
      }

      function filter() {
        var term = input.value.toLowerCase().trim();
        var matchedUnselectedOptions = [];

        optionMeta.forEach(function(meta) {
          var option = meta.option;
          var isSelected = option.classList.contains("selected");
          var rank = getMatchRank(meta.lowerText, term);

          if (isSelected) {
            option.style.display = term ? "none" : "";
            return;
          }

          if (rank === -1) {
            option.style.display = "none";
            return;
          }

          option.style.display = "";
          matchedUnselectedOptions.push({
            meta: meta,
            rank: rank
          });
        });

        matchedUnselectedOptions
          .sort(function(a, b) {
            if (a.rank !== b.rank) {
              return a.rank - b.rank;
            }

            var labelComparison = a.meta.text.localeCompare(b.meta.text, undefined, {
              sensitivity: "base"
            });

            if (labelComparison !== 0) {
              return labelComparison;
            }

            return a.meta.index - b.meta.index;
          })
          .forEach(function(item) {
            dropdown.appendChild(item.meta.option);
          });

        optionMeta.forEach(function(meta) {
          if (meta.option.classList.contains("selected")) {
            dropdown.appendChild(meta.option);
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
    var startDateErrorTrigger = document.getElementById("start_date_error_trigger");
    var endDateErrorTrigger = document.getElementById("end_date_error_trigger");
    var startDateErrorTooltip = document.getElementById("start_date_error_tooltip");
    var endDateErrorTooltip = document.getElementById("end_date_error_tooltip");

    function showDateTooltip(trigger, tooltip) {
      if (!trigger || !tooltip || !trigger.classList.contains("is-visible")) {
        return;
      }

      tooltip.classList.add("is-visible");
      tooltip.setAttribute("aria-hidden", "false");
      trigger.setAttribute("aria-expanded", "true");
    }

    function hideDateTooltip(trigger, tooltip) {
      if (!trigger || !tooltip) {
        return;
      }

      tooltip.classList.remove("is-visible");
      tooltip.setAttribute("aria-hidden", "true");
      trigger.setAttribute("aria-expanded", "false");
    }

    function setDateInputErrorState(input, trigger, tooltip, message) {
      if (input) {
        input.classList.add("is-invalid");
        input.setAttribute("aria-invalid", "true");
        if (tooltip && tooltip.id) {
          input.setAttribute("aria-describedby", tooltip.id);
        }
      }

      if (trigger) {
        trigger.hidden = false;
        trigger.classList.add("is-visible");
      }

      if (tooltip) {
        tooltip.textContent = message;
      }
    }

    function clearDateInputErrorState(input, trigger, tooltip) {
      if (input) {
        input.classList.remove("is-invalid");
        input.removeAttribute("aria-invalid");
        input.removeAttribute("aria-describedby");
      }

      if (trigger) {
        trigger.classList.remove("is-visible");
        trigger.hidden = true;
      }

      if (tooltip) {
        tooltip.textContent = "";
      }

      hideDateTooltip(trigger, tooltip);
    }

    function bindDateErrorTrigger(trigger, tooltip) {
      if (!trigger || !tooltip) {
        return;
      }

      trigger.addEventListener("mouseenter", function() {
        showDateTooltip(trigger, tooltip);
      });

      trigger.addEventListener("mouseleave", function() {
        hideDateTooltip(trigger, tooltip);
      });

      trigger.addEventListener("focus", function() {
        showDateTooltip(trigger, tooltip);
      });

      trigger.addEventListener("blur", function() {
        hideDateTooltip(trigger, tooltip);
      });

      trigger.addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (tooltip.classList.contains("is-visible")) {
          hideDateTooltip(trigger, tooltip);
        } else {
          showDateTooltip(trigger, tooltip);
        }
      });

      trigger.addEventListener("keydown", function(event) {
        if (event.key === "Escape") {
          hideDateTooltip(trigger, tooltip);
        }
      });
    }

    bindDateErrorTrigger(startDateErrorTrigger, startDateErrorTooltip);
    bindDateErrorTrigger(endDateErrorTrigger, endDateErrorTooltip);

    document.addEventListener("click", function(event) {
      if (
        startDateErrorTrigger &&
        startDateErrorTooltip &&
        !startDateErrorTrigger.contains(event.target) &&
        !startDateErrorTooltip.contains(event.target)
      ) {
        hideDateTooltip(startDateErrorTrigger, startDateErrorTooltip);
      }

      if (
        endDateErrorTrigger &&
        endDateErrorTooltip &&
        !endDateErrorTrigger.contains(event.target) &&
        !endDateErrorTooltip.contains(event.target)
      ) {
        hideDateTooltip(endDateErrorTrigger, endDateErrorTooltip);
      }
    });

    function parseStrictIsoDate(value) {
      if (!value) {
        return null;
      }

      var trimmed = value.trim();
      if (!/^\d{4}-\d{2}-\d{2}$/.test(trimmed)) {
        return false;
      }

      var parts = trimmed.split("-");
      var year = Number(parts[0]);
      var month = Number(parts[1]);
      var day = Number(parts[2]);
      var parsed = new Date(Date.UTC(year, month - 1, day));

      if (
        parsed.getUTCFullYear() !== year ||
        parsed.getUTCMonth() !== month - 1 ||
        parsed.getUTCDate() !== day
      ) {
        return false;
      }

      return parsed;
    }

    function showDateValidation(message) {
      setDateInputErrorState(startDateInput, startDateErrorTrigger, startDateErrorTooltip, message);
      setDateInputErrorState(endDateInput, endDateErrorTrigger, endDateErrorTooltip, message);
    }

    function clearDateValidation() {
      clearDateInputErrorState(startDateInput, startDateErrorTrigger, startDateErrorTooltip);
      clearDateInputErrorState(endDateInput, endDateErrorTrigger, endDateErrorTooltip);
    }

    function validateDateRangeInputs() {
      if (!startDateInput || !endDateInput) {
        return true;
      }

      var startRaw = startDateInput.value.trim();
      var endRaw = endDateInput.value.trim();

      if (!startRaw || !endRaw) {
        clearDateValidation();
        return true;
      }

      var startParsed = parseStrictIsoDate(startRaw);
      var endParsed = parseStrictIsoDate(endRaw);

      if (startParsed === false || endParsed === false) {
        showDateValidation("Invalid date format. Please use YYYY-MM-DD.");
        return false;
      }

      if (startParsed.getTime() > endParsed.getTime()) {
        showDateValidation("Invalid date range: Start Date cannot be later than End Date.");
        return false;
      }

      clearDateValidation();
      return true;
    }

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
      validateDateRangeInputs();
    }

    datePresetButtons.forEach(function(button) {
      button.addEventListener("click", function(e) {
        e.preventDefault();
        var preset = button.getAttribute("data-preset");
        applyPreset(preset);
      });
    });

    var resetFiltersBtn = document.getElementById("reset_filters_btn");
    var filterUiSection = document.getElementById("filter-ui-section");

    function resetFilterUiFields() {
      if (startPicker) {
        startPicker.clear();
      }
      if (endPicker) {
        endPicker.clear();
      }

      if (startDateInput) {
        startDateInput.value = "";
      }
      if (endDateInput) {
        endDateInput.value = "";
      }

      datePresetButtons.forEach(function(btn) {
        btn.classList.remove("active");
      });

      clearDateValidation();

      if (!filterUiSection) {
        return;
      }

      filterUiSection.querySelectorAll(".multi-select-wrapper").forEach(function(wrapper) {
        wrapper.dispatchEvent(new Event("multi-select-reset"));
      });
    }

    if (resetFiltersBtn) {
      resetFiltersBtn.addEventListener("click", function(event) {
        event.preventDefault();
        resetFilterUiFields();
      });
    }

    if (startDateInput) {
      startDateInput.addEventListener("change", validateDateRangeInputs);
      startDateInput.addEventListener("blur", validateDateRangeInputs);
    }
    if (endDateInput) {
      endDateInput.addEventListener("change", validateDateRangeInputs);
      endDateInput.addEventListener("blur", validateDateRangeInputs);
    }

    var posForm = document.querySelector(".pos-container-css form");
    if (posForm) {
      var reportIndexSelect = posForm.querySelector('select[name="index_field[]"]');
      var reportColumnSelect = posForm.querySelector('select[name="column_field[]"]');
      var reportValueSelect = posForm.querySelector('select[name="value_field"]');

      if (reportIndexSelect) {
        reportIndexSelect.addEventListener("change", function() {
          clearReportSubmitConfigurationState(posForm);
        });
      }

      if (reportColumnSelect) {
        reportColumnSelect.addEventListener("change", function() {
          clearReportSubmitConfigurationState(posForm);
        });
      }

      if (reportValueSelect) {
        reportValueSelect.addEventListener("change", function() {
          clearReportSubmitConfigurationState(posForm);
        });
      }

      posForm.addEventListener("submit", function(event) {
        if (!validateDateRangeInputs()) {
          event.preventDefault();
          event.stopPropagation();
          if (typeof event.stopImmediatePropagation === "function") {
            event.stopImmediatePropagation();
          }
          resetAllReportActionButtons();
        }
      }, true);
    }
  });
</script>