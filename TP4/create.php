<?php

$app = require __DIR__.'/bootstrap/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
?>

<html lang="fr">
<head>
    <title>TP4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="create.php" method="POST">
    <table>
        <tr>
            <th>Nom :</th>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <th>Email :</th>
            <td><input type="email" name="email"></td>
        </tr>
        <tr>
            <th>Mot de passe :</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th>Confirmation :</th>
            <td><input type="password" name="confirm"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Créer"/></td>
        </tr>
    </table>
</form>
</body>
</html>