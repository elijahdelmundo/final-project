<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Store overview</div><h1>Good day, <?= esc(session()->get('full_name')) ?>.</h1><p class="subtext">Here is your store activity at a glance.</p></div><a class="btn" href="<?= site_url('sales/new') ?>">＋ Record a sale</a></div>
<div class="stats">
    <div class="stat"><div class="stat-label">Products</div><div class="stat-value"><?= esc($productCount) ?></div></div>
    <div class="stat"><div class="stat-label">Customers</div><div class="stat-value"><?= esc($customerCount) ?></div></div>
    <div class="stat"><div class="stat-label">Staff accounts</div><div class="stat-value"><?= esc($staffCount) ?></div></div>
    <div class="stat"><div class="stat-label">Recorded sales</div><div class="stat-value"><?= esc($salesCount) ?></div></div>
</div>
<section class="panel"><div class="heading"><div><div class="eyebrow">Latest transactions</div><h2 style="margin:5px 0">Recent sales</h2></div><a href="<?= site_url('sales') ?>">View history →</a></div>
<div class="table-wrap"><table><thead><tr><th>Product</th><th>Customer</th><th>Qty</th><th>Total</th><th>Date</th></tr></thead><tbody>
<?php if (!$recentSales): ?><tr><td class="empty" colspan="5">No sales recorded yet. Start by recording your first sale.</td></tr><?php endif ?>
<?php foreach($recentSales as $sale): ?><tr><td><strong><?= esc($sale['product_name']) ?></strong></td><td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td><td><?= esc($sale['quantity']) ?></td><td>₱<?= esc(number_format((float)$sale['total_price'],2)) ?></td><td><?= esc(date('M j, Y g:i A',strtotime($sale['created_at']))) ?></td></tr><?php endforeach ?>
</tbody></table></div></section>
<?= $this->endSection() ?>
