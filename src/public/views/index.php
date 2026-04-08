<?php
require __DIR__ . "/template/header.php";
require __DIR__ . "/template/topbar.php";
require __DIR__ . "/template/navbar.php";

$summaryCards = [
  ['label' => 'Total Sales (Today)', 'value' => 'PHP 128,540.25', 'change' => '+8.4% vs yesterday', 'changeClass' => 'success'],
  ['label' => 'Transactions', 'value' => '642', 'change' => '+5.1% vs yesterday', 'changeClass' => 'success'],
  ['label' => 'Average Basket Size', 'value' => 'PHP 200.22', 'change' => '-1.3% vs yesterday', 'changeClass' => 'danger'],
  ['label' => 'Refund Count', 'value' => '7', 'change' => 'No change', 'changeClass' => 'secondary'],
];

$dailySales = [
  ['date' => 'Apr 01', 'sales' => 'PHP 96,250.10', 'transactions' => 511],
  ['date' => 'Apr 02', 'sales' => 'PHP 101,824.35', 'transactions' => 538],
  ['date' => 'Apr 03', 'sales' => 'PHP 98,330.90', 'transactions' => 520],
  ['date' => 'Apr 04', 'sales' => 'PHP 110,245.75', 'transactions' => 579],
  ['date' => 'Apr 05', 'sales' => 'PHP 128,540.25', 'transactions' => 642],
];

$topProducts = [
  ['name' => 'Classic Burger Meal', 'qty' => 182, 'gross' => 'PHP 54,600.00'],
  ['name' => 'Iced Latte (Large)', 'qty' => 156, 'gross' => 'PHP 42,120.00'],
  ['name' => 'Chicken Wrap', 'qty' => 133, 'gross' => 'PHP 39,900.00'],
  ['name' => 'Fries (Regular)', 'qty' => 127, 'gross' => 'PHP 19,050.00'],
];

$recentTransactions = [
  ['or' => 'OR-240405-0912', 'time' => '09:12 AM', 'store' => 'BIGGS Naga Centro', 'payment' => 'GCash', 'amount' => 'PHP 480.00'],
  ['or' => 'OR-240405-0918', 'time' => '09:18 AM', 'store' => 'BIGGS Magsaysay', 'payment' => 'Cash', 'amount' => 'PHP 1,220.00'],
  ['or' => 'OR-240405-0924', 'time' => '09:24 AM', 'store' => 'BIGGS SM Naga', 'payment' => 'Card', 'amount' => 'PHP 865.50'],
  ['or' => 'OR-240405-0931', 'time' => '09:31 AM', 'store' => 'BIGGS Iriga', 'payment' => 'Cash', 'amount' => 'PHP 320.00'],
];
?>
<style>
  .pos-container-css {
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    border-radius: 30px;
    overflow: hidden;
  }

  .pos-container-css .card-header {
    border-top-left-radius: 30px;
    border-top-right-radius: 30px;
  }

  .dashboard-sample-reminder {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #fff4d6 0%, #ffe3a1 100%);
    color: #6b4f00;
    border: 1px solid rgba(240, 173, 78, 0.35);
  }

  .dashboard-sample-reminder__icon {
    flex: 0 0 auto;
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 50%;
    background: #f0ad4e;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    line-height: 1;
  }

  .dashboard-sample-reminder__body {
    flex: 1 1 auto;
    min-width: 0;
  }

  .dashboard-sample-reminder__close {
    flex: 0 0 auto;
    width: 1.5rem;
    height: 1.5rem;
    border: 0;
    border-radius: 50%;
    background: #f0ad4e;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 0.95rem;
    line-height: 1;
  }

  .dashboard-sample-reminder__close:hover {
    background: #ec9a2f;
    color: #fff;
  }
</style>
<!-- Page Sidebar Ends-->
<div class="page-body">
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-sm-6">
          <h3>Dashboard</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">Home</li>
            <!-- <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Sample Page</li> -->
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="alert alert-dismissible fade show mb-4 pos-container-css dashboard-sample-reminder js-dashboard-sample-reminder" role="alert">
      <span class="dashboard-sample-reminder__icon" aria-hidden="true">!</span>
      <div class="dashboard-sample-reminder__body">
        <strong>Sample data only:</strong> The information shown on this dashboard is not legitimate Biggs Diner Inc. data and is provided for display purposes only.
      </div>
      <button type="button" class="dashboard-sample-reminder__close js-dashboard-sample-reminder-close" aria-label="Close reminder">&times;</button>
    </div>

    <div class="row">
      <?php foreach ($summaryCards as $card): ?>
        <div class="col-xl-3 col-sm-6 mb-4">
          <div class="card h-100 pos-container-css">
            <div class="card-body">
              <p class="text-muted mb-2"><?= htmlspecialchars($card['label']) ?></p>
              <h4 class="mb-1"><?= htmlspecialchars($card['value']) ?></h4>
              <small class="text-<?= htmlspecialchars($card['changeClass']) ?>">
                <?= htmlspecialchars($card['change']) ?>
              </small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="row">
      <div class="col-xl-8 mb-4">
        <div class="card h-100 pos-container-css">
          <div class="card-header pb-0">
            <h5 class="mb-0">Sample Daily Sales Snapshot</h5>
            <span class="text-muted">Mock data for dashboard preview</span>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Sales</th>
                    <th>Transactions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($dailySales as $row): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['date']) ?></td>
                      <td><?= htmlspecialchars($row['sales']) ?></td>
                      <td><?= htmlspecialchars((string)$row['transactions']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 mb-4">
        <div class="card h-100 pos-container-css">
          <div class="card-header pb-0">
            <h5 class="mb-0">Top Selling Products</h5>
            <span class="text-muted">Current week (sample)</span>
          </div>
          <div class="card-body">
            <?php foreach ($topProducts as $product): ?>
              <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                  <strong><?= htmlspecialchars($product['name']) ?></strong>
                  <div class="text-muted small">Qty: <?= htmlspecialchars((string)$product['qty']) ?></div>
                </div>
                <span class="badge badge-primary"><?= htmlspecialchars($product['gross']) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mb-4">
        <div class="card pos-container-css">
          <div class="card-header pb-0">
            <h5 class="mb-0">Recent POS Transactions</h5>
            <span class="text-muted">Sample records for display only</span>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Official Receipt</th>
                    <th>Time</th>
                    <th>Store</th>
                    <th>Payment</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($recentTransactions as $transaction): ?>
                    <tr>
                      <td><?= htmlspecialchars($transaction['or']) ?></td>
                      <td><?= htmlspecialchars($transaction['time']) ?></td>
                      <td><?= htmlspecialchars($transaction['store']) ?></td>
                      <td><?= htmlspecialchars($transaction['payment']) ?></td>
                      <td><?= htmlspecialchars($transaction['amount']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var closeButton = document.querySelector('.js-dashboard-sample-reminder-close');
    var reminder = document.querySelector('.js-dashboard-sample-reminder');

    if (closeButton && reminder) {
      closeButton.addEventListener('click', function () {
        reminder.remove();
      });
    }
  });
</script>
<?php
require "template/footer.php"
?>