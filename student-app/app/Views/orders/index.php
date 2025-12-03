<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Del Sol</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(to right, #2b607b, #204c55);">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="#">Aqua Del Sol</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('orders/gotoLogin') ?>">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- about us -->
    <section class="hero" id="home">
        <h1>About Us</h1>
        <p>
            Aqua del Sol is a water refilling station based in Yati, Liloan.
            We specialize in the filtration and distribution of clean, drinkable water for our valued customers.
        </p>
        <a href="#products" class="btn btn-light btn-lg rounded-pill mt-3">
            Discover
        </a>
    </section>

    <!-- products -->
    <section id="products" class="container my-5 py-5 text-center">
        <h2 class="fw-bold mb-4 mt-5">Our Products</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="ratio ratio-1x1">
                            <img src="<?= base_url('uploads/bottle_water.png') ?>" alt="Water" class="img-fluid rounded shadow object-fit-cover w-100 h-100">
                        </div>
                        <h5 class="card-title mt-3 text-center fw-bold">Water Bottle</h5>
                        <p class="text-center text-muted fst-italic lh-base mt-2 fs-6">Our bottled water is clean, safe, and ready to drink. Perfect for staying hydrated anytime, whether at home, at work, or on the go.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="ratio ratio-1x1">
                            <img src="<?= base_url('uploads/water_gallon.png') ?>" alt="Water_Gallon" class="img-fluid rounded shadow object-fit-cover w-100 h-100">
                        </div>
                        <h5 class="card-title mt-3 text-center fw-bold">Water Gallon</h5>
                        <p class="text-center text-muted fst-italic lh-base mt-2 fs-6">Our water gallons provide pure and fresh water for your home or office. Ideal for families or workplaces that need a reliable source of drinking water.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="ratio ratio-1x1">
                            <img src="<?= base_url('uploads/wat_gall_faucet.png') ?>" alt="Water_Gallon_Faucet" class="img-fluid rounded shadow">
                        </div>
                        <h5 class="card-title mt-3 text-center fw-bold">Water Gallon with Faucet</h5>
                        <p class="text-center text-muted fst-italic lh-base mt-2 fs-6">Our water gallons with faucet make it easy to get fresh water whenever you need it. Convenient, safe, and perfect for daily use.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- privacy policy -->
    <section id="privacy-policy" class="container my-5 py-5">
        <h2 class="fw-bold text-center mb-4">Privacy Policy</h2>
        <div class="card shadow-sm p-4 text-center fs-5">
            <p>
                At Aqua del Sol, your privacy is important to us. When you use our Order Tracking System,
                we collect essential information such as your name, contact details, delivery address, order
                history, and preferences to ensure timely and accurate order processing and delivery.
                We use this data solely to manage your orders, improve our services, and provide delivery updates.
                We do not sell or rent your information to third parties.
            </p>
            <p>
                Your data may be shared only with
                authorized
                personnel or service providers who help operate the system and are bound by confidentiality.
                We take reasonable security measures to protect your data, but we cannot guarantee absolute
                security.
                Your information is retained only as long as necessary to fulfill its intended purpose or comply
                with legal obligations.
            </p>
            <p>
                You have the right to access, correct, or request the deletion of your data at any time by
                contacting us. By using the Order Tracking System, you agree to the collection and use of
                your information as outlined in this policy.
            </p>
            <!-- <p>
                For questions, please contact Aqua del Sol at 09123432981.
            </p> -->
        </div>
    </section>


    <footer class="text-light py-5">
        <div class="container">
            <h2 class="fw-bold mb-4 text-center">Contact Us</h2>

            <div class="row justify-content-center text-center text-md-start">
                <div class="col-md-6 mb-4">
                    <h4 class="fw-semibold">Location</h4>
                    <p>9XGP+JQV, Simborio, Bag-ong Daan Rd, Liloan, Cebu</p>

                    <h4 class="fw-semibold mt-3">Socials</h4>
                    <p>Aqua Del Sol</p>
                    <p class="small">Facebook Page</p>
                </div>

                <div class="col-md-6 mb-4">
                    <h4 class="fw-semibold">Email</h4>
                    <p>AquaDelSol@gmail.com</p>
                    <h4 class="fw-semibold mt-3">Phone</h4>
                    <p>09123432981</p>
                </div>
            </div>

            <hr class="border-light">

            <div class="text-center mt-3">
                <p class="mb-0">© 2025 Aqua Del Sol. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>