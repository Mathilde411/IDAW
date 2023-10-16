<?php

function renderMenu($currentPage) {
    $myMenu = [
        'index' => ['Accueil'],
        'cv' => ['CV'],
        'hobbies' => ['Hobbies'],
        'infos-techniques' => ['Technique']
    ];
    ?>
    <nav class="menu">
        <div class="titre">
            <h3>Menu</h3>
        </div>
        <ul>
            <?php
            foreach($myMenu as $pageId => $pageParameters) {
                ?>
                <li class="<?php  if($pageId == $currentPage) { echo "current"; }?>"><a href="<?php echo $pageId; ?>.php" ><?php echo $pageParameters[0]; ?></a></li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <?php
}
?>