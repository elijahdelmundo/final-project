<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Customer details</div><h1><?= $mode === 'edit' ? 'Edit customer' : 'Add customer' ?></h1><p class="subtext">Name and a valid email address are required.</p></div><a class="btn secondary" href="<?= site_url('customers') ?>">Back to customers</a></div>
<form class="panel" method="post" action="<?= $mode === 'edit' ? site_url('customers/'.$customer['id']) : site_url('customers') ?>"><?= csrf_field() ?>
<div class="form-grid">
    <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" maxlength="100" value="<?= esc(old('full_name',$customer['full_name'] ?? '')) ?>" required></div>
    <div class="field"><label for="email">Email</label><input id="email" type="email" name="email" maxlength="100" value="<?= esc(old('email',$customer['email'] ?? '')) ?>" required></div>
    <div class="field"><label for="phone">Phone</label><input id="phone" name="phone" maxlength="20" value="<?= esc(old('phone',$customer['phone'] ?? '')) ?>"></div>
</div>
<div class="form-actions"><button class="btn" type="submit"><?= $mode === 'edit' ? 'Save changes' : 'Create customer' ?></button><a class="btn secondary" href="<?= site_url('customers') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
