<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_admin_page() {
    ?>
    <div class="wrap" style="display: flex; flex-direction: column; min-height: 95dvh;">
        <div class="content" style="flex: 1;">
            <h1>El Pomar</h1>
            <h2 class="nav-tab-wrapper">
                <a href="#welcome" class="nav-tab nav-tab-active" onclick="openTab(event, 'welcome')">Welcome</a>
                <a href="#settings" class="nav-tab" onclick="openTab(event, 'settings')">Settings</a>
                <a href="#about" class="nav-tab" onclick="openTab(event, 'about')">About</a>
            </h2>
            <div id="welcome" class="tab-content">
                <?php Pomar_core_home_page(); ?>
            </div>
            <div id="settings" class="tab-content" style="display: none;">
                <?php el_pomar_global_settings_page(); ?>
            </div>
            <div id="about" class="tab-content" style="display: none;">
                <?php Pomar_core_about_page(); ?>
            </div>
        </div>
        <div class="footer" style="text-align: center;padding: 20px 0;display: flex;flex-direction: row;align-items: center;align-content: center;flex-wrap: wrap; gap:10px;">
            <hr style="width: 100%;">
            <p>Desarrollado por <a href="https://github.com/kerackdiaz" target="_blank" rel="nofollow"> Kerack Diaz </a> </p>
            <p>&copy; 2024 <a href="http://3mas1r.com/" target="_blank" rel="nofollow">3+1R</a>. Todos los derechos reservados.</p>
        </div>
    </div>
    <script>
        function openTab(evt, tabName) {
            let i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("nav-tab");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" nav-tab-active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " nav-tab-active";
        }
    </script>
    <?php
}