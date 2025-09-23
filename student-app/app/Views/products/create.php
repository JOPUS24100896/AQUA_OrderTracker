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
        <?php if (isset($message)) : ?>
            <span class="alert" style="color:red;">
                <?= esc($message) ?>
            </span>
        <?php endif; ?>

        <form action="/products/store" method="post">
            <label>Product Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Price:</label><br>
            <input type="number" step="0.01" name="price" required><br><br>

            <button type="submit">Save</button>
        </form>
    </div>

</body>
</html>