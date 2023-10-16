<footer>
    <div class="contact">
        <span class="mail">Contact: <a href="mailto:contact@example.com">contact@example.com</a></span>
    </div>
    <div class="filler"></div>
    <div class="lang">
        <?php

        $currentPageId = 'accueil';
        if (isset($_GET['page'])) {
            $currentPageId = $_GET['page'];
        }

        $currentLang = 'fr';
        if (isset($_GET['page']) and in_array(strtolower($_GET['lang']), ['en', 'fr'])) {
            $currentLang = strtolower($_GET['lang']);
        }

        if($currentLang == "fr") {
            ?>
            <a href="/SitePro/v3?page=<?php echo $currentPageId; ?>&lang=en"><img src="en.svg" alt="UK flag"/> English</a>
            <?php
        } else {
            ?>
            <a href="/SitePro/v3?page=<?php echo $currentPageId; ?>&lang=fr"><img src="fr.svg" alt="French flag"/> Français</a>
            <?php
        }
        ?>
    </div>
</footer>
</body>
</html>
