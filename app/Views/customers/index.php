<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Customer directory</div><h1>Customers</h1><p class="subtext">Keep customer contact details available for sales.</p></div><a class="btn" href="<?= site_url('customers/new') ?>">＋ Add customer</a></div>
<div class="table-wrap"><table><thead><tr><th>Full name</th><th>Email</th><th>Phone</th><th>Created</th><th>Actions</th></tr></thead><tbody>
<?php if (!$customers): ?><tr><td class="empty" colspan="5">No customers have been added.</td></tr><?php endif ?>
<?php foreach($customers as $customer): ?><tr><td><strong><?= esc($customer['full_name']) ?></strong></td><td><?= esc($customer['email']) ?></td><td><?= esc($customer['phone'] ?: '—') ?></td><td><?= esc(date('M j, Y',strtotime($customer['created_at']))) ?></td><td><div class="actions"><a class="btn secondary small" href="<?= site_url('customers/'.$customer['id'].'/edit') ?>">Edit</a><form class="inline-form" method="post" action="<?= site_url('customers/'.$customer['id'].'/delete') ?>" onsubmit="return confirm('Delete this customer? Sales will remain and become walk-in sales.')"><?= csrf_field() ?><button class="btn danger small" type="submit">Delete</button></form></div></td></tr><?php endforeach ?>
</tbody></table></div>
<?= $this->endSection() ?>
