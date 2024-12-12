<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_jobs_shortcode(){
    ob_start();
    ?>
    <div class="EP-Content">
        <div class="EP-offert-content">
            <h2>COMPLETA EL FORMULARIO</h2>
            <h3>¡El primer paso para trabajar con nosotros!</h3>
            <div id="dynamic-content">
                <p>Para postularte, primero revisa la categoría de la oferta que te interesa, luego dale click a la vacante a la que quieres postularte y si la vacante es de tu interés llena el formulario que aparecerá al darle click al botón de 'Postularme'.</p>
            </div>
        </div>
        <div class="EP-offert-list">
            <?php el_pomar_jobs_offerts_render('jobs', 'job_category'); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('jobs_pomar', 'el_pomar_jobs_shortcode');

function el_pomar_jobs_offert_content_render($post_id = null){
    if ($post_id) {
        $post = get_post($post_id);
        if ($post) {
            echo '<h4>' . esc_html($post->post_title) . '</h4>';
            echo '<div>' . apply_filters('the_content', $post->post_content) . '</div>';
            echo '<button id="apply-button" data-post-id="' . esc_attr($post_id) . '">Postularme</button>';
        }
    }
}

function el_pomar_jobs_offerts_render($post_type, $taxonomy){
    $categories = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'meta_key' => 'EP-cat-order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ));

    if (!empty($categories)){
        echo '<div class="EP-accordion">';
        foreach ($categories as $index => $category){
            $EP_category_icon = get_term_meta($category->term_id, 'EP-cat-icon', true);
            $posts = get_posts(array(
                'post_type' => $post_type,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $category->term_id,
                    ),
                ),
            ));
            echo '<div class="EP-accordion-item">';
            echo '<div class="EP-accordion-header">';
            if ($EP_category_icon){
                echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/jobs/categories/' . esc_attr($EP_category_icon) . '" alt="' . esc_attr($category->name) . '" class="EP-category-icon">';
            }
            echo '<div class="EP-category-details">';
            echo '<span class="EP-category-name">' . esc_html($category->name) . '</span>';
            echo '</div>';
            echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/icons/' . ($index === 0 ? 'minus' : 'plus') . '.svg' . '" alt="Toggle Icon" class="toggle-icon">';
            echo '</div>';
            echo '<div class="EP-accordion-content" style="display: ' . ($index === 0 ? 'block' : 'none') . ';">';
            if (!empty($posts)){
                echo '<ul>';
                foreach ($posts as $post_index => $post){
                    echo '<li><a href="#" class="EP-offert-link ' . ($index === 0 && $post_index === 0 ? 'active' : '') . '" data-post-id="' . esc_attr($post->ID) . '">';
                    echo '<img src="' . plugin_dir_url(__FILE__) . '../../../assets/img/icons/right-arrow.svg' . '" alt="Right Arrow" class="product-icon">';
                    echo esc_html($post->post_title) . '</a></li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No hay vacantes disponibles.</p>';
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
}

function el_pomar_render_application_form() {
    ?>
    <div id="application-form-popup" style="display:none;">
        <form id="application-form" enctype="multipart/form-data">
            <div class="close_form">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
            </svg>
            </div>
            <div class="col-50">
                <label for="first_name">Nombres:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="col-50">
                <label for="last_name">Apellidos:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="col-15">
                <label for="document_type">Tipo de Documento:</label>
                <select id="document_type" name="document_type" required>
                    <option value="CC">Cédula de Ciudadanía</option>
                    <option value="TI">Tarjeta de Identidad</option>
                    <option value="CE">Cédula de Extranjería</option>
                </select>
            </div>
            <div class="col-35">
                <label for="document_number">No. Documento:</label>
                <input type="text" id="document_number" name="document_number" required>
            </div>
            <div class="col-50">
                <label for="phone">Celular:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="col-50">
                <label for="city">Ciudad:</label>
                <select id="city" name="city" required>
                    <option value="">Seleccione una ciudad</option>
                    <option value="Bogotá">Bogotá</option>
                    <option value="Medellín">Medellín</option>
                    <option value="Cali">Cali</option>
                    <option value="Barranquilla">Barranquilla</option>
                    <option value="Cartagena">Cartagena</option>
                    <option value="Cúcuta">Cúcuta</option>
                    <option value="Bucaramanga">Bucaramanga</option>
                    <option value="Pereira">Pereira</option>
                    <option value="Santa Marta">Santa Marta</option>
                    <option value="Ibagué">Ibagué</option>
                    <option value="Manizales">Manizales</option>
                    <option value="Villavicencio">Villavicencio</option>
                    <option value="Pasto">Pasto</option>
                    <option value="Montería">Montería</option>
                    <option value="Neiva">Neiva</option>
                    <option value="Armenia">Armenia</option>
                    <option value="Popayán">Popayán</option>
                    <option value="Sincelejo">Sincelejo</option>
                    <option value="Valledupar">Valledupar</option>
                    <option value="Tunja">Tunja</option>
                    <option value="Florencia">Florencia</option>
                    <option value="Riohacha">Riohacha</option>
                    <option value="Quibdó">Quibdó</option>
                    <option value="Mocoa">Mocoa</option>
                    <option value="San Andrés">San Andrés</option>
                    <option value="Leticia">Leticia</option>
                </select>
            </div>
            <div class="col-50">
                <label for="neighborhood">Barrio:</label>
                <input type="text" id="neighborhood" name="neighborhood" required>
            </div>
            <div class="col-50">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="col-50">
                <label for="desired_position">Cargo que aspiras:</label>
                <input type="text" id="desired_position" name="desired_position" readonly>
            </div>
            <div class="col-100">
                <label for="salary_expectation">Aspiración salarial:</label>
                <input type="text" id="salary_expectation" name="salary_expectation" required>
            </div>
            <div class="col-100">
                <label for="why_join">¿Porqué te gustaría ser parte de nuestro equipo?</label>
                <textarea id="why_join" name="why_join" required></textarea>
            </div>

            <div class="col-100 custom-file-input">
                <label for="cv" class="file-label">
                    <img src="<?php echo EP_PLUGIN_URL; ?>assets/img/icons/upload-icon.svg" alt="Upload Icon" class="upload-icon">
                    <span class="file-text">Adjuntar CV</span>
                    <input type="file" id="cv" name="cv" required>
                </label>
            </div>
            <div class="col-100 terms-container">
                <label for="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    Acepto los <a href="<?php echo esc_url(get_option('el_pomar_terms_link')); ?>" target="_blank">Términos y Condiciones</a> y 
                    <a href="<?php echo esc_url(get_option('el_pomar_privacy_link')); ?>" target="_blank">Tratamiento de datos personales</a>
                </label>
            </div>
            <button type="submit">Enviar 
            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 7.5L13 7.5M13 7.5L7 13.5M13 7.5L7 1.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            </button>
        </form>
    </div>
    <?php
}

add_action('wp_footer', 'el_pomar_render_application_form');