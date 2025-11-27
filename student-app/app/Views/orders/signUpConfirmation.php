<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <div class="hero">
    <section class="d-flex align-items-center justify-content-center">
    <div class="card text-center p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h2 class="card-title text-success mb-3">Sign Up Successful!</h2>
            <p class="card-text mb-4">Your account has been created successfully. Please log in to continue.</p>
            <a href="<?= base_url('orders/gotoLogin') ?>" class="btn btn-primary w-100">Log In</a>
        </div>
    </div>
</section>
    </div>
    <?= $this->include("orders/footer") ?>
</body>
</html>