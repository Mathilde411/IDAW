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

if (isset($_GET["css"]) and array_key_exists($_GET["css"], $styles)) {
    setcookie("style", $_GET["css"]);
    $style = $_GET["css"];
}
?>
<html lang="fr">
<head>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="<?php echo $style?>.css"/>
    <title>Titre</title>
</head>
<body>
<?php require_once("displayConnection.php")?>
<form id="style_form" action="index.php" method="GET">
    <select name="css">
        <?php
        foreach ($styles as $id => $value) {
            ?>
            <option value="<?php echo $id?>" <?php if($id == $style) { echo 'selected';} ?>>
                <?php echo $value?>
            </option>
            <?php
        }
        ?>
    </select>
    <input type="submit" value="Appliquer"/>
</form>
<a href="login.php">Connexion</a>
</body>
</html>