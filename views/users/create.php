<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?= route('users.store') ?>" method="post">
    <label for="">name</label>
    <input type="text" name="name">
    <label for="">age</label>
    <input type="number" name="age">
    <input type="submit">
</form>
</body>
<script src="<?= assets('assets/scripts/main.js')?>"></script>
</html>
