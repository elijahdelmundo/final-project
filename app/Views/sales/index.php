<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Transactions</div><h1>Sales history</h1><p class="subtext">Review recorded purchases, customer details, and staff attribution.</p></div><a class="btn" href="<?= site_url('sales/new') ?>">＋ Record sale</a></div>
<div class="table-wrap"><table><thead><tr><th>Sale #</th><th>Product</th><th>Customer</th><th>Sold by</th><th>Quantity</th><th>Total</th><th>Date</th></tr></thead><tbody>
<?php if (!$sales): ?><tr><td class="empty" colspan="7">No sales recorded yet.</td></tr><?php endif ?>
<?php foreach($sales as $sale): ?><tr><td>#<?= esc($sale['id']) ?></td><td><strong><?= esc($sale['product_name']) ?></strong></td><td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td><td><?= esc($sale['staff_name']) ?></td><td><?= esc($sale['quantity']) ?></td><td>₱<?= esc(number_format((float)$sale['total_price'],2)) ?></td><td><?= esc(date('M j, Y g:i A',strtotime($sale['created_at']))) ?></td></tr><?php endforeach ?>
</tbody></table></div>
<?= $this->endSection() ?>
