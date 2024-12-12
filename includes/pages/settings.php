<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_settings_page() {
    ?>
    <div class="wrap" style="display: flex; flex-direction: column; min-height: 95dvh;">
        <div class="content" style="flex: 1;">
            <h1>Configuraciones</h1>
            <h2 class="settings-nav-tab-wrapper">
                <a href="#portfolio" class="settings-nav-tab settings-nav-tab-active" onclick="openSettingsTab(event, 'portfolio')">Portafolio</a>
                <a href="#job_offers" class="settings-nav-tab" onclick="openSettingsTab(event, 'job_offers')">Ofertas Laborales</a>
                <a href="#general" class="settings-nav-tab" onclick="openSettingsTab(event, 'general')">General</a>
            </h2>
            <div id="portfolio" class="settings-tab-content">
                <?php Pomar_core_catalog_settings_page(); ?>
            </div>
            <div id="job_offers" class="settings-tab-content" style="display: none;">
                <?php el_pomar_jobs_settings_page(); ?>
            </div>
            <div id="general" class="settings-tab-content" style="display: none;">
                <h3>Configuraciones Generales</h3>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('el_pomar_settings_group');
                    do_settings_sections('el_pomar_settings');
                    submit_button();
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openSettingsTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("settings-tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("settings-nav-tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" settings-nav-tab-active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " settings-nav-tab-active";
        }

        document.addEventListener('DOMContentLoaded', function() {
            var hash = window.location.hash.substring(1);
            if (hash) {
                var tab = document.querySelector('a[href="#' + hash + '"]');
                if (tab) {
                    tab.click();
                }
            }
        });
    </script>
    <?php
}
?>