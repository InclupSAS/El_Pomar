<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_home_page() {
    ?>
    <div>
        <h2>Bienvenido</h2>
        <p>Descripción general del plugin.</p>
    </div>
    <?php
}