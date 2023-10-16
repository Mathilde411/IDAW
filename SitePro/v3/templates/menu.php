<?php

function renderMenu($currentPage) {
    $myMenu = [
        'accueil' => [
            'fr' => 'Accueil',
            'en' => 'Home'
        ],
        'cv' => [
            'fr' => 'CV',
            'en' => 'CV'
        ],
        'hobbies' => [
            'fr' => 'Activités',
            'en' => 'Hobbies'
        ],
        'infos-techniques' => [
            'fr' => 'Technique',
            'en' => 'Knowledge'
        ]
    ];

    $currentLang = 'fr';
    if (isset($_GET['page']) and in_array(strtolower($_GET['lang']), ['en', 'fr'])) {
        $currentLang = strtolower($_GET['lang']);
    }
    ?>
    <nav class="menu">
        <div class="titre">
            <h3>Menu</h3>
        </div>
        <ul>
            <?php
            foreach($myMenu as $pageId => $pageParameters) {
                ?>
                <li class="<?php  if($pageId == $currentPage) { echo "current"; }?>"><a href="/SitePro/v3?page=<?php echo $pageId; ?>&lang=<?php echo $currentLang; ?>" ><?php echo $pageParameters[$currentLang]; ?></a></li>
                <?php
            }
            ?>
        </ul>
    </nav>
    <?php
}
?>