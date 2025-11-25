<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>

    <h1>User list</h1>

    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= $user['id'] ?> — <?= $user['name'] ?></li>
        <?php endforeach; ?>
    </ul>

</body>

</html>