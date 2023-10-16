<div class="login-info">
    <?php
    session_start();
    if(!isset($_SESSION["username"])) {
        echo "Vous n'êtes pas connecté";
    } else {
        echo "Connecté en tant que: " . $_SESSION["username"];
        ?>
            <a href="deconnexion.php">Déconnexion</a>
        <?php
    }
    ?>
</div>