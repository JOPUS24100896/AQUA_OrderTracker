<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue fixed-top" style="background: linear-gradient(to right, #2b607b, #204c55);">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="#">Aqua Del Sol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('orders') ?>">Home</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <section id="login" class="container my-5 py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <h2 class="fw-bold text-center mb-4">Log In</h2>
                        <form method="post" action="<?= base_url('orders/logInUser') ?>">
                            <div class="mb-3">
                                <label for="email_or_phone" class="form-label">Email or Username</label>
                                <input id="email_or_phone" name="login_key" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_input" class="form-label">Password</label>
                                <input id="password_input" name="password" type="password" class="form-control" required>
                            </div>
                            <div class="d-grid mb-3">
                                <input type="submit" value="Log In" class="btn btn-primary">
                            </div>
                            <div class="text-center">
                                <a href="<?= base_url('orders/signup') ?>" class="btn btn-outline-secondary">Sign Up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?= $this->include("orders/footer") ?>

</body>

</html>