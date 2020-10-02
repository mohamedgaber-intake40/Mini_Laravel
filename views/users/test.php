<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Test1</h1>

<ul>
    <?php foreach ($data as $key => $item): ?>
    <li><?= $key .' = '. $item ?></li>
    <?php endforeach; ?>
</ul>
<a href="<?= route('avatar') ?>">avatar</a>
</body>
<script src="<?= assets('assets/scripts/main.js')?>"></script>
</html>
