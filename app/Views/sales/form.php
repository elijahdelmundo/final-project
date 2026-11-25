<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Checkout</div><h1>Record a sale</h1><p class="subtext">Select an item, quantity, and optional customer. Stock is deducted only when the sale is saved.</p></div><a class="btn secondary" href="<?= site_url('sales') ?>">Sales history</a></div>
<form class="panel" method="post" action="<?= site_url('sales') ?>"><?= csrf_field() ?>
<div class="form-grid">
    <div class="field full"><label for="product_id">Product</label><select id="product_id" name="product_id" required><option value="">Choose an in-stock product</option><?php foreach($products as $product): ?><option value="<?= esc($product['id']) ?>" <?= old('product_id') == $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?> · ₱<?= esc(number_format((float)$product['price'],2)) ?> · <?= esc($product['stock_quantity']) ?> in stock</option><?php endforeach ?></select></div>
    <div class="field"><label for="quantity">Quantity</label><input id="quantity" type="number" name="quantity" min="1" step="1" value="<?= esc(old('quantity','1')) ?>" required></div>
    <div class="field"><label for="customer_id">Customer (optional)</label><select id="customer_id" name="customer_id"><option value="">Walk-in customer</option><?php foreach($customers as $customer): ?><option value="<?= esc($customer['id']) ?>" <?= old('customer_id') == $customer['id'] ? 'selected' : '' ?>><?= esc($customer['full_name']) ?> — <?= esc($customer['email']) ?></option><?php endforeach ?></select></div>
</div>
<div class="form-actions"><button class="btn" type="submit">Complete sale</button><a class="btn secondary" href="<?= site_url('/') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
