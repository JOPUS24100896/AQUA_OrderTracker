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

    <div class="p-3 text-center justify-content-center container bg-light position-absolute top-50 start-50 translate-middle w-50">
            <form action="/products/deleteProd" method="post">
                <div class="p-3 container text-start w-25">
                    <?php foreach ($products as $p): ?>
                    <label>
                        <input type="checkbox"  name="idDel[]" value="<?= esc($p['id']) ?>"> <?= esc($p['name']) ?>
                    </label><br>
                    <?php endforeach; ?>
                </div>
            <button type="submit">Save</button>
            </form>
    </div>
</body>
</html>