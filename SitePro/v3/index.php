<?php
require_once("templates/header.php");
require_once("templates/menu.php");

$currentPageId = 'accueil';
if (isset($_GET['page'])) {
    $currentPageId = $_GET['page'];
}

$currentLang = 'fr';
if (isset($_GET['page']) and in_array(strtolower($_GET['lang']), ['en', 'fr'])) {
    $currentLang = strtolower($_GET['lang']);
}

?>
    <div class="page-body">
        <?php renderMenu($currentPageId); ?>
        <div class="content">
            <?php
            $pageToInclude = "pages/" . $currentLang . "/" . $currentPageId . ".php";
            if(is_readable($pageToInclude))
                require_once($pageToInclude);
            else
                require_once("pages/" . $currentLang . "/error.php");
            ?>
        </div>
    </div>

<?php
require_once("templates/footer.php");
