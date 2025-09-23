<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="background-color: #a3ded4;">
    <?php include 'navbar.php'; ?>
    

    <div class="p-5 text-center justify-content-center container bg-light position-absolute top-50 start-50 translate-middle w-50">
        <?php if (session()->getFlashdata('message')): ?>
        <p style="color:green"><?= session()->getFlashdata('message') ?></p>
        <?php endif; ?>

        
        <ul style="list-style-type:none;">
            <?php foreach ($products as $p): ?>
            <li><?= esc($p['name']) ?> - ₱<?= esc($p['price']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>