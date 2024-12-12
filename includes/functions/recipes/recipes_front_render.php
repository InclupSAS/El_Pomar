<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

function el_pomar_recipe_content_shortcode($atts) {
    global $post;

    if (is_singular('recipes')) {
        $difficulty = intval(get_post_meta($post->ID, '_el_pomar_difficulty', true));
        $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
        $post_title = get_the_title($post->ID);
        $formatted_date = date_i18n('F j \d\e Y', strtotime($post->post_date));
        $post_url = get_permalink($post->ID);
        $site_name = get_bloginfo('name');
        $site_url = home_url();
        ob_start();
        ?>
        <div id="recipe-content" class="el-pomar-recipe-content">
            <div class="recipe-thumbnail" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>
            <span class="post-date">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 4.9375V5.875H13V4.9375C13 4.41982 13.4469 4 14 4C14.5531 4 15 4.41982 15 4.9375V5.875H16.5C17.3281 5.875 18 6.50459 18 7.28125V8.6875H4V7.28125C4 6.50459 4.67156 5.875 5.5 5.875H7V4.9375C7 4.41982 7.44688 4 8 4C8.55312 4 9 4.41982 9 4.9375ZM4 9.625H18V17.5938C18 18.3701 17.3281 19 16.5 19H5.5C4.67156 19 4 18.3701 4 17.5938V9.625ZM6 12.9062C6 13.1641 6.22375 13.375 6.5 13.375H7.5C7.775 13.375 8 13.1641 8 12.9062V11.9688C8 11.7109 7.775 11.5 7.5 11.5H6.5C6.22375 11.5 6 11.7109 6 11.9688V12.9062ZM10 12.9062C10 13.1641 10.225 13.375 10.5 13.375H11.5C11.775 13.375 12 13.1641 12 12.9062V11.9688C12 11.7109 11.775 11.5 11.5 11.5H10.5C10.225 11.5 10 11.7109 10 11.9688V12.9062ZM14.5 11.5C14.225 11.5 14 11.7109 14 11.9688V12.9062C14 13.1641 14.225 13.375 14.5 13.375H15.5C15.775 13.375 16 13.1641 16 12.9062V11.9688C16 11.7109 15.775 11.5 15.5 11.5H14.5ZM6 16.6562C6 16.9141 6.22375 17.125 6.5 17.125H7.5C7.775 17.125 8 16.9141 8 16.6562V15.7188C8 15.4609 7.775 15.25 7.5 15.25H6.5C6.22375 15.25 6 15.4609 6 15.7188V16.6562ZM10.5 15.25C10.225 15.25 10 15.4609 10 15.7188V16.6562C10 16.9141 10.225 17.125 10.5 17.125H11.5C11.775 17.125 12 16.9141 12 16.6562V15.7188C12 15.4609 11.775 15.25 11.5 15.25H10.5ZM14 16.6562C14 16.9141 14.225 17.125 14.5 17.125H15.5C15.775 17.125 16 16.9141 16 16.6562V15.7188C16 15.4609 15.775 15.25 15.5 15.25H14.5C14.225 15.25 14 15.4609 14 15.7188V16.6562Z" fill="#D62631" />
                </svg>
                <?php echo esc_html($formatted_date); ?>
            </span>
            <section class="recipe-metabox">
                <h3>Ingredientes</h3>
                <ul class="recipe-ingredients">
                    <?php
                    $ingredients = get_post_meta($post->ID, '_el_pomar_ingredients', true);
                    if (!empty($ingredients)) {
                        foreach ($ingredients as $ingredient) {
                            echo '<li>' . esc_html($ingredient) . '</li>';
                        }
                    }
                    ?>
                </ul>
                <div class="recipe-metadata">
                    <section class="difficulty">
                        <h5>Dificultad:</h5>
                        <span class="icon-difficulty">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <svg width="13" height="30" viewBox="0 0 13 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.0946 10.508C10.2108 7.87563 9.76017 5.11901 9.76018 2.34424H7.88477C7.88396 5.06902 8.32646 7.77604 9.19516 10.3607C10.1914 13.3252 10.6989 16.4299 10.6979 19.555V27.0151C10.6969 27.3777 10.6102 27.7351 10.4449 28.0585C10.2795 28.3819 10.04 28.6622 9.74569 28.877H10.6979C11.1953 28.877 11.6723 28.6809 12.024 28.3317C12.3757 27.9825 12.5733 27.5089 12.5733 27.0151V19.555C12.5733 16.48 12.074 13.4252 11.0946 10.508Z" fill="#F1F1F1" />
                                    <path d="M9.73176 0.426147H7.88477C8.12969 0.426147 8.36459 0.527186 8.53778 0.707037C8.71097 0.886887 8.80826 1.13082 8.80826 1.38516C8.80826 1.63951 8.71097 1.88344 8.53778 2.06329C8.36459 2.24314 8.12969 2.34418 7.88477 2.34418H9.73176C9.97669 2.34418 10.2116 2.24314 10.3848 2.06329C10.558 1.88344 10.6553 1.63951 10.6553 1.38516C10.6553 1.13082 10.558 0.886887 10.3848 0.707037C10.2116 0.527186 9.97669 0.426147 9.73176 0.426147Z" fill="#F1F1F1" />
                                    <path d="M11.1677 10.6325C10.7142 9.2858 10.3715 7.90361 10.1433 6.5C9.65311 6.89732 9.04644 7.11961 8.41797 7.1322C8.6249 8.21613 8.90163 9.28529 9.24637 10.3329C10.2275 13.3018 10.7272 16.4112 10.7263 19.541V27.0123C10.7253 27.3755 10.6399 27.7334 10.4771 28.0573C10.3142 28.3811 10.0784 28.6619 9.78854 28.877H10.7263C11.2161 28.877 11.6859 28.6806 12.0323 28.3309C12.3786 27.9812 12.5732 27.5069 12.5732 27.0123V19.541C12.5911 16.5138 12.1163 13.5042 11.1677 10.6325Z" fill="#F1F1F1" />
                                    <path d="M10.2218 2.70274C10.5302 2.59208 10.7897 2.37582 10.9544 2.09214C11.1191 1.80845 11.1785 1.47559 11.1221 1.15231C11.0656 0.829035 10.897 0.536123 10.646 0.325285C10.3949 0.114447 10.0776 -0.00075915 9.75 3.76491e-06H3.25C2.92241 -0.00075915 2.60509 0.114447 2.35404 0.325285C2.10299 0.536123 1.93437 0.829035 1.87794 1.15231C1.8215 1.47559 1.88089 1.80845 2.04561 2.09214C2.21033 2.37582 2.46979 2.59208 2.77819 2.70274C2.74198 5.29844 2.30684 7.87306 1.48808 10.336C0.501536 13.2982 -0.000961976 16.4005 1.38254e-06 19.5232V26.9776C0.000726341 27.5942 0.245537 28.1853 0.680733 28.6213C1.11593 29.0573 1.70597 29.3026 2.32143 29.3033H10.6786C11.294 29.3026 11.8841 29.0573 12.3193 28.6213C12.7545 28.1853 12.9993 27.5942 13 26.9776V19.5232C13.001 16.4005 12.4985 13.2982 11.5119 10.336C10.6932 7.87306 10.258 5.29844 10.2218 2.70274ZM3.25 0.930266H9.75C9.87314 0.930266 9.99123 0.979271 10.0783 1.0665C10.1654 1.15373 10.2143 1.27204 10.2143 1.3954C10.2143 1.51876 10.1654 1.63707 10.0783 1.7243C9.99123 1.81152 9.87314 1.86053 9.75 1.86053H3.25C3.12686 1.86053 3.00877 1.81152 2.9217 1.7243C2.83463 1.63707 2.78572 1.51876 2.78572 1.3954C2.78572 1.27204 2.83463 1.15373 2.9217 1.0665C3.00877 0.979271 3.12686 0.930266 3.25 0.930266ZM9.58968 6.29211C9.17878 6.55768 8.69662 6.69097 8.20792 6.6741C7.71923 6.65723 7.24737 6.49101 6.85569 6.19774L6.70155 6.08169C6.24925 5.74244 5.71811 5.52427 5.15828 5.44777C4.59845 5.37127 4.02839 5.43896 3.50192 5.64447C3.62135 4.69765 3.68914 3.74501 3.705 2.79079H9.295C9.315 3.96319 9.41345 5.13292 9.58968 6.29211ZM12.0714 26.9776C12.071 27.3476 11.9241 27.7023 11.663 27.9639C11.4019 28.2255 11.0479 28.3726 10.6786 28.373H2.32143C1.95215 28.3726 1.5981 28.2255 1.33698 27.9639C1.07586 27.7023 0.928978 27.3476 0.928573 26.9776V19.5232C0.927707 16.5006 1.41412 13.4976 2.36902 10.6303C2.78561 9.37488 3.10688 8.08965 3.33009 6.78567C3.74347 6.49417 4.23826 6.34109 4.74372 6.34833C5.24918 6.35556 5.73942 6.52274 6.14431 6.82595L6.29845 6.942C6.7879 7.31288 7.37108 7.53933 7.98217 7.59581C8.59326 7.65229 9.20795 7.53655 9.75687 7.26163C9.97359 8.40266 10.2656 9.52804 10.631 10.6303C11.5859 13.4976 12.0723 16.5006 12.0714 19.5232V26.9776Z" fill="<?php echo $i <= $difficulty ? '#D62631' : '#BFC0BF'; ?>" />
                                </svg>
                                <?php endfor; ?>
                        </span>
                    </section>
                    <section class="Portions">
                        <h5>Porciones:</h5>
                        <p><?php echo esc_html(get_post_meta($post->ID, '_el_pomar_servings', true)); ?></p>
                    </section>
                    <section class="time">
                        <h5>
                            <span class="icon-clock">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 4.75468C9.58141 4.75468 10.0526 5.22714 10.0526 5.81008V9C10.0526 9.31147 9.9153 9.60706 9.67743 9.80784L7.99095 11.23C7.79359 11.3963 7.55304 11.4775 7.31394 11.4775C7.01398 11.4775 6.71608 11.3497 6.50781 11.1015C6.13364 10.6553 6.191 9.98965 6.6359 9.61448L7.94737 8.50858V5.81008C7.94737 5.22714 8.41859 4.75468 9 4.75468ZM16.9474 0.585832C16.366 0.585832 15.8947 1.05829 15.8947 1.64124V3.26516C14.2076 1.21866 11.6848 0 8.97636 0C4.02673 0 0 4.03733 0 9C0 13.9627 4.03742 18 9 18C10.3561 18 11.6965 17.6937 12.9104 17.1105C12.9309 17.1013 12.9515 17.0922 12.9716 17.0819C12.9772 17.0788 12.9827 17.0749 12.9883 17.0718C13.1299 17.0019 13.2706 16.9293 13.4085 16.8518C13.9159 16.5674 14.0972 15.9242 13.8133 15.4155C13.5296 14.9068 12.8884 14.7249 12.381 15.0094C11.3544 15.5849 10.1854 15.8892 9 15.8892C5.19819 15.8892 2.10526 12.7986 2.10526 9C2.10526 5.20137 5.1875 2.11081 8.97636 2.11081C11.1351 2.11081 13.1398 3.12231 14.4289 4.80745H12.7895C12.2081 4.80745 11.7368 5.27991 11.7368 5.86285C11.7368 6.4458 12.2081 6.91826 12.7895 6.91826H14.8421C16.5835 6.91826 18 5.498 18 3.75204V1.64124C18 1.05829 17.5288 0.585832 16.9474 0.585832ZM16.1953 12.5605C15.7136 12.2342 15.0594 12.3614 14.7342 12.8448C14.4089 13.3282 14.5362 13.9841 15.0179 14.3102C15.1984 14.4322 15.4032 14.4908 15.6059 14.4908C15.9443 14.4908 16.2757 14.3277 16.4794 14.0253C16.8041 13.5426 16.6774 12.8866 16.1953 12.5605ZM17.9636 9.29766C17.9568 9.26385 17.9484 9.23066 17.9385 9.19748C17.9285 9.1647 17.9169 9.13193 17.9038 9.10039C17.8906 9.06864 17.8758 9.0369 17.8596 9.0068C17.8431 8.97629 17.8259 8.94682 17.8069 8.91817C17.788 8.88931 17.7669 8.86127 17.7453 8.83489C17.7237 8.80788 17.7 8.78212 17.6758 8.75779C17.6517 8.73347 17.6258 8.70976 17.5991 8.68812C17.5728 8.66606 17.5442 8.64545 17.5158 8.62649C17.4875 8.60752 17.4574 8.58959 17.4274 8.57372C17.3968 8.55723 17.3657 8.54259 17.3343 8.5294C17.3026 8.5162 17.2699 8.50445 17.2375 8.49456C17.2042 8.48446 17.1704 8.47601 17.1373 8.46921C17.1036 8.4624 17.0689 8.45704 17.0347 8.45395C16.9663 8.44694 16.8968 8.44694 16.8279 8.45395C16.7938 8.45704 16.7595 8.4624 16.7257 8.46921C16.692 8.47601 16.6585 8.48446 16.6258 8.49456C16.5931 8.50445 16.5606 8.5162 16.529 8.5294C16.4973 8.54259 16.4659 8.55723 16.4359 8.57372C16.4052 8.58959 16.3758 8.60752 16.3475 8.62649C16.3185 8.64545 16.2905 8.66606 16.2642 8.68812C16.2375 8.70976 16.2116 8.73347 16.1873 8.75779C16.1626 8.78212 16.1394 8.80788 16.1174 8.83489C16.0958 8.86127 16.0752 8.88931 16.0563 8.91817C16.0374 8.94682 16.0195 8.97629 16.0037 9.0068C15.9875 9.0369 15.9727 9.06864 15.9595 9.10039C15.9463 9.13193 15.9348 9.1647 15.9248 9.19748C15.9149 9.23066 15.9062 9.26385 15.8995 9.29766C15.8927 9.33146 15.8873 9.3663 15.8843 9.40011C15.8806 9.43494 15.8789 9.46978 15.8789 9.504C15.8789 9.53821 15.8806 9.57305 15.8843 9.60789C15.8873 9.64169 15.8927 9.67653 15.8995 9.71034C15.9065 9.74352 15.9149 9.77733 15.9248 9.81052C15.9348 9.84329 15.9463 9.87607 15.9595 9.90761C15.9727 9.93935 15.9875 9.9711 16.0037 10.0012C16.0195 10.0311 16.0374 10.0612 16.0563 10.0898C16.0752 10.1187 16.0958 10.1467 16.1174 10.1731C16.1394 10.2001 16.1626 10.2259 16.1873 10.2502C16.2116 10.2745 16.2375 10.2982 16.2642 10.3199C16.2905 10.3415 16.3185 10.3625 16.3475 10.3815C16.3758 10.4005 16.4052 10.4184 16.4359 10.4343C16.4659 10.4508 16.4973 10.4654 16.529 10.4786C16.5606 10.4918 16.5931 10.5035 16.6258 10.5134C16.6585 10.5235 16.6922 10.532 16.7257 10.5388C16.7595 10.5456 16.7938 10.5509 16.8279 10.554C16.862 10.5578 16.8974 10.5594 16.9315 10.5594C16.9659 10.5594 17.0006 10.5578 17.0347 10.554C17.0689 10.5509 17.1038 10.5456 17.1373 10.5388C17.1706 10.532 17.2044 10.5235 17.2375 10.5134C17.2699 10.5035 17.3026 10.4918 17.3343 10.4786C17.3657 10.4654 17.3968 10.4508 17.4274 10.4343C17.4574 10.4184 17.4875 10.4005 17.5158 10.3815C17.5442 10.3625 17.5728 10.3415 17.5991 10.3199C17.6258 10.2982 17.6517 10.2745 17.6758 10.2502C17.7 10.2259 17.7237 10.2001 17.7453 10.1731C17.7669 10.1467 17.788 10.1187 17.8069 10.0898C17.8259 10.0612 17.8431 10.0311 17.8596 10.0012C17.8758 9.9711 17.8906 9.93935 17.9038 9.90761C17.9169 9.87607 17.9285 9.84329 17.9385 9.81052C17.9484 9.77733 17.9568 9.74352 17.9636 9.71034C17.9706 9.67653 17.9757 9.64169 17.979 9.60789C17.9827 9.57305 17.9842 9.53821 17.9842 9.504C17.9842 9.46978 17.9827 9.43494 17.979 9.40011C17.9757 9.3663 17.9704 9.33146 17.9636 9.29766Z" fill="#D62631" />
                            </svg>
                            </span>
                            Tiempo de Preparación:
                        </h5>
                        <p><?php echo esc_html(get_post_meta($post->ID, '_el_pomar_prep_time', true)); ?></p>
                    </section>
                </div>
            </section>
            <div class="recipe-data">
                <h3>Preparación</h3>
                <?php echo wp_kses_post(apply_filters('the_content', $post->post_content)); ?>
                <p class="quote">Puedes comprar tus productos Pomar preferidos en nuestra tienda virtual y preparar tus <br><b>#RecetasPomarEnCasa</b></p>
            </div>
        </div>
        <div class="recipe-actions">
            <button class="download-recipe">Descargar Receta
                <span>
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5 12.5C19.6046 12.5 20.5 13.3954 20.5 14.5V16.5C20.5 17.6046 19.6046 18.5 18.5 18.5H6.5C5.39543 18.5 4.5 17.6046 4.5 16.5V14.5C4.5 13.3954 5.39543 12.5 6.5 12.5M12.5 5.5L12.5001 13.5M12.5001 13.5L9.5 10.6364M12.5001 13.5L15.5 10.6364M18.5 15.5C18.5 15.7761 18.2761 16 18 16C17.7239 16 17.5 15.7761 17.5 15.5C17.5 15.2239 17.7239 15 18 15C18.2761 15 18.5 15.2239 18.5 15.5Z" stroke="white" stroke-width="1.25" stroke-linecap="round" />
                    </svg>
                    </span>
            </button>
            <?php if ($shop_link = get_post_meta($post->ID, '_el_pomar_shop_link', true)) : ?>
                <button class="buy-product" href="<?php echo esc_url($shop_link); ?>" target="_blank">¡Compra Aquí!
                    <span>
                        <svg width="20" height="27" viewBox="0 0 20 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.3467 5.049H14.9867C14.9867 4.131 14.7644 3.285 14.32 2.511C13.8756 1.737 13.2711 1.125 12.5067 0.674999C11.7422 0.224998 10.9067 0 10 0C9.09333 0 8.25778 0.224998 7.49333 0.674999C6.72889 1.125 6.12444 1.737 5.68 2.511C5.23556 3.285 5.01333 4.131 5.01333 5.049H1.68C1.21778 5.049 0.822222 5.2155 0.493333 5.5485C0.164444 5.8815 0 6.282 0 6.75V25.326C0 25.794 0.164444 26.19 0.493333 26.514C0.822222 26.838 1.21778 27 1.68 27H18.3467C18.8089 27 19.2 26.838 19.52 26.514C19.84 26.19 20 25.794 20 25.326V6.75C20 6.282 19.84 5.8815 19.52 5.5485C19.2 5.2155 18.8089 5.049 18.3467 5.049ZM10 1.674C10.6044 1.674 11.16 1.827 11.6667 2.133C12.1733 2.439 12.5778 2.8485 12.88 3.3615C13.1822 3.8745 13.3333 4.437 13.3333 5.049H6.69333C6.69333 4.437 6.84444 3.8745 7.14667 3.3615C7.44889 2.8485 7.84889 2.4435 8.34667 2.1465C8.84444 1.8495 9.39556 1.692 10 1.674ZM18.3467 25.326H1.68V6.75H18.3467V25.326ZM7.49333 10.125H12.5067C12.7378 10.125 12.9378 10.044 13.1067 9.882C13.2756 9.72 13.36 9.5175 13.36 9.2745C13.36 9.0315 13.2756 8.829 13.1067 8.667C12.9378 8.505 12.7378 8.424 12.5067 8.424H7.49333C7.26222 8.424 7.06222 8.505 6.89333 8.667C6.72444 8.829 6.64 9.0315 6.64 9.2745C6.64 9.5175 6.72444 9.72 6.89333 9.882C7.06222 10.044 7.26222 10.125 7.49333 10.125Z" fill="white" />
                        </svg>
                    </span>
                </button>
            <?php endif; ?>
        </div>

        <div id="popup-form" class="popup-form" style="display: none;">
            <div class="popup-content">
                <div class="close_form">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                    </svg>
                    </div>
                <h2 class="popup-title">Complete el formulario para descargar la receta</h2>
                <form id="download-form" class="download-form">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <input type="hidden" id="recipe_id" name="recipe_id" value="<?php echo esc_attr($post->ID); ?>">
                    <div class="form-group col-100 terms-container">
                        <label for="terms">
                            <input type="checkbox" id="terms" name="terms" class="form-check" required>
                            Acepto los <a href="<?php echo esc_url(get_option('el_pomar_terms_link')); ?>" target="_blank">Términos y Condiciones</a> y 
                            <a href="<?php echo esc_url(get_option('el_pomar_privacy_link')); ?>" target="_blank">Tratamiento de datos personales</a>
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-button">Enviar 
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 7.5L13 7.5M13 7.5L7 13.5M13 7.5L7 1.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            </button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <script>
            document.querySelector('.download-recipe').addEventListener('click', function() {
                document.getElementById('popup-form').style.display = 'flex';
            });

            document.getElementById('popup-form').addEventListener('click', function(event) {
                if (event.target.id === 'popup-form') {
                    this.style.display = 'none';
                }
            });

            document.querySelector('.close_form').addEventListener('click', function() {
                document.getElementById('popup-form').style.display = 'none';
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    document.getElementById('popup-form').style.display = 'none';
                }
            });

            document.getElementById('download-form').addEventListener('submit', function(event) {
                event.preventDefault();
                document.getElementById('popup-form').style.display = 'none';

                const formData = new FormData(event.target);
                formData.append('action', 'el_pomar_handle_form_submission');

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const element = document.getElementById('recipe-content');
                        const postTitle = "<?php echo esc_js($post_title); ?>";
                        const postUrl = "<?php echo esc_url($post_url); ?>";
                        const siteName = "<?php echo esc_js($site_name); ?>";
                        const siteUrl = "<?php echo esc_url($site_url); ?>";
                        const opt = {
                            margin:       [40, 20, 20, 20], 
                            filename:     postTitle + '.pdf',
                            image:        { type: 'jpeg', quality: 1 },
                            html2canvas:  { scale: 2 },
                            jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait' },
                            pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
                        };
                        html2pdf().set(opt).from(element).toPdf().get('pdf').then(function (pdf) {
                            const totalPages = pdf.internal.getNumberOfPages();
                            for (let i = 1; i <= totalPages; i++) {
                                pdf.setPage(i);
                                pdf.setFontSize(25);
                                pdf.setTextColor('#214475');
                                pdf.textWithLink(postTitle, pdf.internal.pageSize.getWidth() -570, 25, { align: 'center', url: postUrl });
                                pdf.setFontSize(16);
                                pdf.setTextColor('#214475');
                                pdf.textWithLink(siteName, pdf.internal.pageSize.getWidth() - 150, pdf.internal.pageSize.getHeight() - 10, { align: 'right', url: siteUrl });
                            }
                        }).save();
                    } else {
                        alert('Error al enviar el formulario: ' + data.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al enviar el formulario: ' + error.message);
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }

    return '';
}
add_shortcode('recipe_pomar', 'el_pomar_recipe_content_shortcode');

function enqueue_html2pdf_script() {
    wp_enqueue_script('html2pdf', 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_html2pdf_script');