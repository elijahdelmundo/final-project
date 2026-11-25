<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Catalog and inventory</div><h1>Products</h1><p class="subtext">Manage product details, pricing, images, and current stock.</p></div><a class="btn" href="<?= site_url('products/new') ?>">＋ Add product</a></div>
<div class="table-wrap"><table><thead><tr><th>Item</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead><tbody>
<?php if (!$products): ?><tr><td class="empty" colspan="4">No products yet. Add your first product.</td></tr><?php endif ?>
<?php foreach($products as $product): ?><tr><td><div style="display:flex;align-items:center;gap:12px"><?php if($product['image']): ?><img class="product-image" src="<?= site_url('media/products/'.rawurlencode($product['image'])) ?>" alt="<?= esc($product['name']) ?>"><?php else: ?><div class="product-image"></div><?php endif ?><strong><?= esc($product['name']) ?></strong></div></td><td>₱<?= esc(number_format((float)$product['price'],2)) ?></td><td><?= esc($product['stock_quantity']) ?></td><td><div class="actions"><a class="btn secondary small" href="<?= site_url('products/'.$product['id'].'/edit') ?>">Edit</a><form class="inline-form" method="post" action="<?= site_url('products/'.$product['id'].'/delete') ?>" onsubmit="return confirm('Delete this product?')"><?= csrf_field() ?><button class="btn danger small" type="submit">Delete</button></form></div></td></tr><?php endforeach ?>
</tbody></table></div>
<?= $this->endSection() ?>
