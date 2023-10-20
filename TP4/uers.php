<?php

use App\Model\User;

$app = require __DIR__.'/bootstrap/app.php';

$users = User::all();

?>

<html lang="fr">
<head>
    <title>TP4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user) {?>
        <tr>
            <td><?php echo $user->id ?></td>
            <td><?php echo $user->name ?></td>
            <td><?php echo $user->email ?></td>
        </tr>
    <?php }?>
    </tbody>
</table>
<div class="liens">
    <a href="create.php">Création</a>
</div>
</body>
</html>
