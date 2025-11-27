<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
</head>

<body>
    <?php include "staffHeader.php" ?>
    <section id="privacy-policy" class="container my-5" style="padding-top: 100px; padding-bottom: 300px;">
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



    <?= $this->include("orders/footer") ?>

    <script src="/js/dropdown.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>