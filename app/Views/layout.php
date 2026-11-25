<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Point of Sale') ?> · Xander/Elijah | Delmundo POS</title>
    <style>
        :root{--navy:#14213d;--blue:#2563eb;--blue-light:#e9efff;--light:#f5f7fb;--muted:#667085;--line:#e6eaf0;--white:#fff;--green:#15803d;--red:#b42318}
        *{box-sizing:border-box}body{margin:0;background:var(--light);color:#182230;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}a{color:var(--blue)}.topbar{background:var(--navy);color:#fff}.topbar-inner{max-width:1280px;min-height:74px;margin:auto;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;gap:22px}.brand{color:#fff;text-decoration:none;font-size:21px;font-weight:850;letter-spacing:-.03em}.brand span{color:#60a5fa}.top-actions{display:flex;align-items:center;gap:15px;color:#d7e2f6;font-size:13px}.top-actions form{margin:0}.top-actions button{border:1px solid #53627d;border-radius:8px;padding:8px 12px;color:#fff;background:transparent;font-weight:700;cursor:pointer}
        .shell{max-width:1280px;margin:auto;padding:28px 24px 70px;display:grid;grid-template-columns:220px minmax(0,1fr);gap:26px}.sidebar{align-self:start;padding:13px;border:1px solid var(--line);border-radius:14px;background:#fff}.side-title{padding:9px 10px 12px;color:#98a2b3;font-size:11px;font-weight:800;letter-spacing:.11em;text-transform:uppercase}.side-link{display:block;margin:3px 0;padding:11px 12px;border-radius:9px;color:#475467;text-decoration:none;font-size:14px;font-weight:650}.side-link:hover,.side-link.active{color:#1d4ed8;background:var(--blue-light)}.main{min-width:0}.heading{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:22px}.eyebrow{color:var(--blue);font-size:11px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}.heading h1{margin:7px 0 4px;color:var(--navy);font-size:clamp(28px,4vw,38px);letter-spacing:-.045em}.subtext{margin:5px 0 0;color:var(--muted);font-size:14px;line-height:1.55}.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 16px;border:0;border-radius:9px;color:#fff;background:var(--blue);text-decoration:none;font-size:13px;font-weight:750;cursor:pointer}.btn:hover{background:#1d4ed8}.btn.secondary{color:#344054;background:#fff;border:1px solid var(--line)}.btn.danger{background:#b42318}.btn.small{padding:7px 10px;font-size:12px}.panel{padding:22px;border:1px solid var(--line);border-radius:14px;background:#fff;box-shadow:0 6px 18px rgba(20,33,61,.035)}.flash{margin-bottom:16px;padding:13px 15px;border:1px solid #b7dfc2;border-radius:10px;color:#166534;background:#f0fdf4;font-size:14px}.flash.error{border-color:#f1b5b1;color:#9f1d17;background:#fff5f4}.flash ul{margin:5px 0 0;padding-left:20px}
        .stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:20px}.stat{padding:19px;border:1px solid var(--line);border-radius:13px;background:#fff}.stat-label{color:var(--muted);font-size:12px;font-weight:700}.stat-value{margin-top:7px;color:var(--navy);font-size:29px;font-weight:850;letter-spacing:-.04em}.table-wrap{overflow:auto;border:1px solid var(--line);border-radius:12px;background:#fff}table{width:100%;border-collapse:collapse;min-width:650px}th,td{padding:14px 16px;border-bottom:1px solid var(--line);text-align:left;vertical-align:middle}th{color:#667085;background:#fafbfc;font-size:11px;letter-spacing:.08em;text-transform:uppercase}td{font-size:13px}tr:last-child td{border-bottom:0}.product-image,.avatar{width:48px;height:48px;object-fit:cover;border-radius:10px;background:#eef2f6}.avatar{border-radius:50%}.actions{display:flex;align-items:center;gap:8px}.inline-form{display:inline;margin:0}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:17px}.field{margin-bottom:3px}.field.full{grid-column:1/-1}label{display:block;margin-bottom:7px;color:#344054;font-size:13px;font-weight:700}input,select{width:100%;padding:11px 12px;border:1px solid #d0d5dd;border-radius:8px;background:#fff;color:#182230;font:inherit;font-size:14px}input:focus,select:focus{outline:3px solid #dbeafe;border-color:#70a4f8}.hint{margin-top:6px;color:var(--muted);font-size:12px}.form-actions{display:flex;gap:10px;margin-top:8px}.empty{padding:28px;text-align:center;color:var(--muted)}.login-wrap{min-height:100vh;display:grid;place-items:center;padding:20px;background:linear-gradient(145deg,#14213d,#274b87)}.login-card{width:min(440px,100%);padding:32px;border-radius:18px;background:#fff;box-shadow:0 24px 64px rgba(0,0,0,.2)}.login-card .brand{display:inline-block;margin-bottom:24px;color:var(--navy)}.login-card .brand span{color:var(--blue)}.login-card h1{margin:0;color:var(--navy);font-size:28px}.login-card .subtext{margin-bottom:22px}
        @media(max-width:850px){.shell{grid-template-columns:1fr;padding:18px 15px 40px}.sidebar{display:flex;overflow:auto;gap:4px;padding:8px}.side-title{display:none}.side-link{white-space:nowrap;margin:0;padding:10px;font-size:12px}.stats{grid-template-columns:repeat(2,minmax(0,1fr))}.heading{align-items:flex-start;flex-direction:column}.heading .btn{align-self:flex-start}}@media(max-width:520px){.topbar-inner{padding:12px 15px}.top-actions{gap:7px;font-size:11px}.stats{gap:9px}.stat{padding:14px}.stat-value{font-size:24px}.form-grid{grid-template-columns:1fr}.field.full{grid-column:auto}.panel{padding:17px}}
    </style>
</head>
<body>
<header class="topbar"><div class="topbar-inner">
    <a class="brand" href="<?= site_url('/') ?>">XANDER/ELIJAH<span> · DELMUNDO POS</span></a>
    <div class="top-actions"><span><?= esc(session()->get('full_name')) ?></span><form method="post" action="<?= site_url('logout') ?>"><?= csrf_field() ?><button type="submit">Sign out</button></form></div>
</div></header>
<div class="shell">
    <nav class="sidebar" aria-label="Main navigation">
        <div class="side-title">Point of sale</div>
        <a class="side-link <?= uri_string() === '' || uri_string() === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Overview</a>
        <a class="side-link <?= str_starts_with(uri_string(),'products') ? 'active' : '' ?>" href="<?= site_url('products') ?>">Products</a>
        <a class="side-link <?= str_starts_with(uri_string(),'customers') ? 'active' : '' ?>" href="<?= site_url('customers') ?>">Customers</a>
        <a class="side-link <?= str_starts_with(uri_string(),'staff') ? 'active' : '' ?>" href="<?= site_url('staff') ?>">Staff</a>
        <a class="side-link <?= str_starts_with(uri_string(),'sales/new') ? 'active' : '' ?>" href="<?= site_url('sales/new') ?>">Record Sale</a>
        <a class="side-link <?= uri_string() === 'sales' ? 'active' : '' ?>" href="<?= site_url('sales') ?>">Sales History</a>
    </nav>
    <main class="main">
        <?php if ($message = session()->getFlashdata('success')): ?><div class="flash"><?= esc($message) ?></div><?php endif ?>
        <?php if ($message = session()->getFlashdata('error')): ?><div class="flash error"><?= esc($message) ?></div><?php endif ?>
        <?php $errors = session()->getFlashdata('errors') ?? []; if ($errors): ?><div class="flash error"><strong>Please check the form:</strong><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul></div><?php endif ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>
</body>
</html>
