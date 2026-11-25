<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Inventory details</div><h1><?= $mode === 'edit' ? 'Edit product' : 'Add product' ?></h1><p class="subtext">Product photos must be JPG, PNG, or WebP and no larger than 2 MB.</p></div><a class="btn secondary" href="<?= site_url('products') ?>">Back to products</a></div>
<form class="panel" method="post" enctype="multipart/form-data" action="<?= $mode === 'edit' ? site_url('products/'.$product['id']) : site_url('products') ?>"><?= csrf_field() ?>
<div class="form-grid">
    <div class="field full"><label for="name">Product name</label><input id="name" name="name" maxlength="100" value="<?= esc(old('name',$product['name'] ?? '')) ?>" required></div>
    <div class="field"><label for="price">Price (₱)</label><input id="price" type="number" step="0.01" min="0.01" name="price" value="<?= esc(old('price',$product['price'] ?? '')) ?>" required></div>
    <div class="field"><label for="stock_quantity">Stock quantity</label><input id="stock_quantity" type="number" min="0" name="stock_quantity" value="<?= esc(old('stock_quantity',$product['stock_quantity'] ?? '0')) ?>" required></div>
    <div class="field full"><label for="image">Product image</label><input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp"><div class="hint">Optional. JPG, PNG or WebP; maximum 2 MB.</div></div>
    <?php if (!empty($product['image'])): ?><div class="field full"><img class="product-image" style="width:100px;height:100px" src="<?= site_url('media/products/'.rawurlencode($product['image'])) ?>" alt="Current product image"></div><?php endif ?>
</div>
<div class="form-actions"><button class="btn" type="submit"><?= $mode === 'edit' ? 'Save changes' : 'Create product' ?></button><a class="btn secondary" href="<?= site_url('products') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
