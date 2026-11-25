<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="heading"><div><div class="eyebrow">Staff access</div><h1><?= $mode === 'edit' ? 'Edit staff member' : 'Add staff member' ?></h1><p class="subtext">Passwords are stored as secure hashes. Avatar uploads must be images up to 2 MB.</p></div><a class="btn secondary" href="<?= site_url('staff') ?>">Back to staff</a></div>
<form class="panel" method="post" enctype="multipart/form-data" action="<?= $mode === 'edit' ? site_url('staff/'.$staffMember['id']) : site_url('staff') ?>"><?= csrf_field() ?>
<div class="form-grid">
    <div class="field"><label for="username">Username</label><input id="username" name="username" maxlength="50" value="<?= esc(old('username',$staffMember['username'] ?? '')) ?>" required></div>
    <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" maxlength="100" value="<?= esc(old('full_name',$staffMember['full_name'] ?? '')) ?>" required></div>
    <div class="field"><label for="password"><?= $mode === 'edit' ? 'New password (optional)' : 'Password' ?></label><input id="password" type="password" name="password" autocomplete="new-password" <?= $mode === 'create' ? 'required' : '' ?>><div class="hint"><?= $mode === 'edit' ? 'Leave blank to keep the current password.' : 'At least 8 characters.' ?></div></div>
    <div class="field"><label for="avatar">Avatar</label><input id="avatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp"><div class="hint">JPG, PNG, or WebP; maximum 2 MB.</div></div>
    <?php if (!empty($staffMember['avatar'])): ?><div class="field full"><img class="avatar" style="width:76px;height:76px" src="<?= site_url('media/avatars/'.rawurlencode($staffMember['avatar'])) ?>" alt="Current avatar"></div><?php endif ?>
</div>
<div class="form-actions"><button class="btn" type="submit"><?= $mode === 'edit' ? 'Save changes' : 'Create staff account' ?></button><a class="btn secondary" href="<?= site_url('staff') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
