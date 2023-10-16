<?php
$styles = [
    'red' => 'Rouge',
    'green' => 'Green',
    'blue' => 'Blue'
];
$defaultStyle = 'red';

if (!isset($_COOKIE["style"]) || !array_key_exists($_COOKIE["style"], $styles)) {
    setcookie("style", $defaultStyle);
}

$style = $_COOKIE["style"];

?>

<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="<?php echo $style?>.css"/>
    <title>Login</title>
</head>
<body>
<?php require_once("displayConnection.php")?>
<form id="login_form" action="connected.php" method="POST">
    <table>
        <tr>
            <th>Login :</th>
            <td><input type="text" name="login"></td>
        </tr>
        <tr>
            <th>Mot de passe :</th>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Se connecter..."/></td>
        </tr>
    </table>
</form>
<a href="index.php">Index</a>
</body>
</html>