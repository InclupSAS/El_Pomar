<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function Pomar_core_about_page() {
    ?>
    <div class="wrap workshophub-about">
        <h2>Este plugin es desarrollo esclusivo de Inclup S.A.S para Lacteos El Pomar.</h2>
        
        <h2>Características Principales</h2>
        <ul>
            <li>Creación, gestión y clasificación de productos para el catalogo que ofrece Lacteos El Pomar.</li>
            <li>Creación y clasificación de ofertas labolares, tambien permite la descarga de la información suministrada por los postulantes.</li>
            <li>Creación y gestion de recetas, tambien permite la descarga de información suministrada por los interesados en los pdfs de las recetas.</li>
            <li>Creación y gestion de articulos publicados por medios externos.</li>
            <li>Posibilidad de configurar algunas funciones como imagenes destacadas en los menus, carga de iconos relacionados con categorias, numeros de contacto entre otras funcionalidades.</li>
        </ul>
        
        <h2>Autor</h2>
        <p>El Pomar fue desarrollado por <a href="https://github.com/kerackdiaz" target="_blank" rel="nofollow">Kerack Diaz</a>, un desarrollador apasionado por crear soluciones eficientes y efectivas para la comunidad de WordPress.</p>
        
        <h2>Somos Inclup</h2>
        <p>Este plugin es una creación de <a href="https://inclup.com/" target="_blank" rel="nofollow">Inclup S.A.S</a>, una empresa dedicada a ofrecer soluciones tecnológicas innovadoras y de alta calidad.</p>
        
        <h2>Contacto</h2>
        <p>Si tienes alguna pregunta o necesitas soporte, no dudes en contactarnos a través de nuestro sitio web <a href="https://inclup.com/" target="_blank" rel="nofollow">Inclup S.A.S</a>.</p>
        <p>O si prefieres, puedes escribirnos directamente a <a href="mailto:soporte@inclup.com" target="_blank" rel="nofollow"> soporte@inclup.com </a>.</p>
    </div>
    <?php
}