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
    <nav class="navbar navbar-expand-lg navbar-dark bg-blue fixed-top mb-5" style="background: linear-gradient(to right, #2b607b, #204c55);">
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
        <section class="container my-5 py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                    <form method="post" id="signupForm" action="<?= base_url('orders/signUpUser') ?>">
                        <h2 class="text-dark text-center mb-4 fw-bold">Sign Up</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label text-primary-emphasis">Username <span class="text-danger">*</span></label>
                                    <input name="username" id="username" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-primary-emphasis">Password <span class="text-danger">*</span></label>
                                    <input name="password" id="password" type="password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-primary-emphasis">Email <span class="text-danger">*</span></label>
                                    <input name="email" id="email" type="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label text-primary-emphasis">Full Name</label>
                                    <input name="fullname" id="fullname" type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label text-primary-emphasis">Address <span class="text-danger">*</span></label>
                                    <input name="address" id="address" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label text-primary-emphasis">Contact</label>
                                    <input name="contact" id="contact" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary w-50">Sign Up</button>
                            <br><br>
                            <a href="<?= base_url('orders/gotoLogin') ?>" class="btn btn-outline-secondary">Log In</a>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </section>
    </div>

    <span><?php if (isset($message)) echo $message; ?></span>
    <?= $this->include("orders/footer") ?>

</body>

</html>