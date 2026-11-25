<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Login · Xander/Elijah POS</title>
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:18px;background:linear-gradient(145deg,#14213d,#274b87);font-family:Inter,ui-sans-serif,system-ui,sans-serif;color:#182230}.card{width:min(440px,100%);padding:34px;border-radius:18px;background:#fff;box-shadow:0 24px 64px rgba(0,0,0,.2)}.brand{display:inline-block;margin-bottom:25px;color:#14213d;text-decoration:none;font-size:21px;font-weight:850}.brand span{color:#2563eb}h1{margin:0;color:#14213d;font-size:29px}.muted{margin:8px 0 22px;color:#667085;font-size:14px;line-height:1.5}.flash{margin-bottom:15px;padding:12px;border-radius:8px;background:#fff5f4;color:#9f1d17;font-size:13px}label{display:block;margin-bottom:7px;font-size:13px;font-weight:700}input{width:100%;margin-bottom:17px;padding:12px;border:1px solid #d0d5dd;border-radius:8px;font:inherit}.btn{width:100%;padding:13px;border:0;border-radius:8px;color:#fff;background:#2563eb;font-weight:750;cursor:pointer}
    </style>
</head>
<body><main class="card">
    <a class="brand" href="<?= site_url('/') ?>">XANDER/ELIJAH<span> POS</span></a>
    <h1>Staff sign in</h1><p class="muted">Sign in to manage your store and record sales.</p>
    <?php if ($message = session()->getFlashdata('error')): ?><div class="flash"><?= esc($message) ?></div><?php endif ?>
    <?php $errors=session()->getFlashdata('errors') ?? []; if ($errors): ?><div class="flash"><?php foreach($errors as $error): ?><?= esc($error) ?><br><?php endforeach ?></div><?php endif ?>
    <form method="post" action="<?= site_url('login') ?>"><?= csrf_field() ?>
        <label for="username">Username</label><input id="username" name="username" value="<?= esc(old('username')) ?>" autocomplete="username" required>
        <label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required>
        <button class="btn" type="submit">Sign in</button>
    </form>
</main></body></html>
