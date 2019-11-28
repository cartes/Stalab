<?php
/**
 * Eventica Child Theme functions and definitions.
 */

require "assets/classes/AdvancedSearch.php";

if (function_exists("acf_add_options_page")) {
    acf_add_options_page([
        'page_title' => 'Ajustes Generales del sitio',
        'menu_title' => 'Ajustes del sitio',
    ]);
}

if (!defined('ABSPATH')) exit; // Exit if accessed directly

add_action('after_setup_theme', 'tokopress_load_childtheme_languages', 5);
function tokopress_load_childtheme_languages()
{
    /* this theme supports localization */
    load_child_theme_textdomain('tokopress', get_stylesheet_directory() . '/languages');

}

/* Please add your custom functions code below this line. */

function cptui_register_my_cpts()
{

    /**
     * Post Type: Productos.
     */

    $labels = array(
        "name" => __("Productos", "tokopress;"),
        "singular_name" => __("Producto", "tokopress;"),
        "menu_name" => __("Fichas de productos", "tokopress;"),
        "all_items" => __("Todos los productos", "tokopress;"),
        "add_new" => __("Agregar nuevo", "tokopress;"),
        "add_new_item" => __("Agregar nuevo producto", "tokopress;"),
        "edit_item" => __("Editar producto", "tokopress;"),
        "new_item" => __("Nuevo producto", "tokopress;"),
    );

    $args = array(
        "label" => __("Productos", "tokopress;"),
        "labels" => $labels,
        "description" => "Este es el post type que llevará las fichas de productos",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array("slug" => "producto", "with_front" => true),
        "query_var" => true,
        "menu_position" => 10,
        "supports" => array("title", "editor", "thumbnail", "excerpt", "custom-fields"),
        "taxonomies" => array("muestra", "campo", "prod_type", "brands"),
    );

    register_post_type("producto", $args);

    /**
     * Post Type: Palabras de busqueda.
     */

    $labels = array(
        "name" => __("Palabras de busqueda", "tokopress;"),
        "singular_name" => __("Palabra de busqueda", "tokopress;"),
    );

    $args = array(
        "label" => __("Palabras de busqueda", "tokopress;"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array("slug" => "product_word", "with_front" => true),
        "query_var" => true,
        "supports" => array("title", "thumbnail"),
    );

    register_post_type("product_word", $args);
}

add_action('init', 'cptui_register_my_cpts');

function cptui_register_my_taxes()
{

    /**
     * Taxonomy: Tipo de muestras.
     */

    $labels = array(
        "name" => __("Tipo de muestras", "tokopress;"),
        "singular_name" => __("Tipo de muestra", "tokopress;"),
        "menu_name" => __("Tipos de muestras", "tokopress;"),
        "separate_items_with_commas" => __("Separar con comas los tipos de muestra", "tokopress;"),
        "choose_from_most_used" => __("Elija un de las más usados tipos de muestra", "tokopress;"),
    );

    $args = array(
        "label" => __("Tipo de muestras", "tokopress;"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array('slug' => 'muestra', 'with_front' => true,),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "muestra",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    );
    register_taxonomy("muestra", array("producto"), $args);

    /**
     * Taxonomy: Campos de aplicación.
     */

    $labels = array(
        "name" => __("Campos de aplicación", "tokopress;"),
        "singular_name" => __("Campo de apicación", "tokopress;"),
        "menu_name" => __("Campos de aplicación", "tokopress;"),
        "separate_items_with_commas" => __("Separe con comas los campos de aplicación", "tokopress;"),
        "choose_from_most_used" => __("Elija de los campos de aplicación mas usados", "tokopress;"),
    );

    $args = array(
        "label" => __("Campos de aplicación", "tokopress;"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array('slug' => 'campo', 'with_front' => true,),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "campo",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    );
    register_taxonomy("campo", array("producto"), $args);

    /**
     * Taxonomy: Tipos de producto.
     */

    $labels = array(
        "name" => __("Tipos de producto", "tokopress;"),
        "singular_name" => __("Tipo de producto", "tokopress;"),
        "add_new_item" => __("Agregar nuevo tipo", "tokopress;"),
    );

    $args = array(
        "label" => __("Tipos de producto", "tokopress;"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array('slug' => 'tipo-producto', 'with_front' => true,),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "prod_type",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    );
    register_taxonomy("prod_type", array("producto"), $args);

    /**
     * Taxonomy: Marcas.
     */

    $labels = array(
        "name" => __("Marcas", "tokopress;"),
        "singular_name" => __("Marca", "tokopress;"),
        "menu_name" => __("Marcas", "tokopress;"),
        "all_items" => __("Todas las marcas", "tokopress;"),
        "edit_item" => __("Editar marca", "tokopress;"),
        "view_item" => __("Ver marca", "tokopress;"),
        "update_item" => __("Actualizar marca", "tokopress;"),
        "add_new_item" => __("Agregar nueva marca", "tokopress;"),
        "new_item_name" => __("Nueva marca", "tokopress;"),
    );

    $args = array(
        "label" => __("Marcas", "tokopress;"),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array('slug' => 'marca', 'with_front' => false, 'hierarchical' => true,),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "brands",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => true,
    );
    register_taxonomy("brands", array("producto"), $args);
}

add_action('init', 'cptui_register_my_taxes');


function product_terms($term)
{
    global $post;
    $aplicaciones = get_the_terms($post->ID, $term);
    $last = end($aplicaciones);

    $tax = get_taxonomy($term);

    if (!empty($aplicaciones)) {
        $termsString = "<tr>";
        $termsString .= "<td class='py-2 row subtitle'>";
        $termsString .= "<h5 class='h5 col-12' style='width: 100%;'>{$tax->label}</h5>";
        $termsString .= "</td>";
        $termsString .= "</tr>";
        $termsString .= "<tr>";
        $termsString .= "<td class='py-1'>";
        foreach ($aplicaciones as $aplicacion) {
            if ($aplicacion == $last) {
                $dot = ".";
            } else {
                $dot = ",&nbsp;";
            }
            $title = ucfirst($aplicacion->name);
            $termsString .= "<a href='" . home_url('?' . $term . '=' . $aplicacion->slug) . "' style='color: #6a7a7c'>{$title}</a>{$dot}";
        }
        $termsString .= "</td>";
        $termsString .= "</tr>";
    }

    echo $termsString;
}

add_action('wp_enqueue_scripts', 'scripts_stalab');

function scripts_stalab()
{
    wp_register_script('stalab_jspdf', get_stylesheet_directory_uri() . '/assets/js/jspdf.debug.js');
    wp_register_script('stalab_jspdf_autotable', get_stylesheet_directory_uri() . '/assets/js/jspdf.plugin.autotable.js');
    wp_register_script('stalab_lib_png', get_stylesheet_directory_uri() . '/assets/js/libs/png_support/png.js');
    wp_register_script('stalab_lib_zlib', get_stylesheet_directory_uri() . '/assets/js/libs/png_support/zlib.js');
    wp_register_script('stalab_plugin_addimage', get_stylesheet_directory_uri() . '/assets/js/plugins/addimage.js');
    wp_register_script('stalab_plugin_pngSupport', get_stylesheet_directory_uri() . '/assets/js/plugins/png_support.js');
    wp_register_script('stalab_mod_html', get_stylesheet_directory_uri() . '/assets/js/libs/html2pdf.js');
    wp_register_script('stalab_mod_html', get_stylesheet_directory_uri() . '/assets/js/html2canvas/dist/html2canvas.js');
    wp_register_script('stalab_script', get_stylesheet_directory_uri() . '/assets/js/main.js');
    wp_enqueue_script('stalab_jspdf');
    wp_enqueue_script('stalab_jspdf_autotable');
    wp_enqueue_script('stalab_script');
    wp_enqueue_script('stalab_html2canvas');
    wp_localize_script('stalab_script', 'stalab_var', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'customurl' => get_stylesheet_directory_uri() . '/custom-ajax.php',
        'rest_api_url' => rest_url('stalab-products/v1/product?s=')
    ]);

}


function stalab_alphabetic()
{
    $query = new WP_Query([
        'post_type' => ['product_word'],
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    $response = '';

    if (!empty($query->posts)) {
        $curr_letter = '';
        $prev_letter = '';
        foreach ($query->posts as $post) {
            $curr_letter = strtoupper(substr($post->post_title, 0, 1));
            if ($curr_letter != $prev_letter) {
                $response .= "<h3 class='px-0 col-12 clearfix'>{$curr_letter}</h3>";
                $prev_letter = $curr_letter;
            }

            $response .= "<h4 class='px-0 col-md-4'><a href='#' class='searchWordAlpha' data-value='{$post->post_title}'>{$post->post_title}</a></h4>";
        }
    }

    echo $response;
    die();
}

add_action('wp_ajax_nopriv_stalabAlpha', 'stalab_alphabetic');
add_action('wp_ajax_stalabAlpha', 'stalab_alphabetic');

function stalab_brands()
{
    $terms = get_terms('brands', [
        'hide_empty' => false,
        'orderby' => 'name',
    ]);
    $response = "<h2 class='col-md-12 px-0 py-3'>Marcas</h2>";
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $title = ucfirst($term->name);
            $response .= "<h4 class='px-0 col-md-4'><a href='#' class='searchWordBrand' data-value='{$term->name}'>{$title}</a></h4>";
        }
    }

    echo $response;

    die();
}

add_action('wp_ajax_nopriv_stalabBrand', 'stalab_brands');
add_action('wp_ajax_stalabBrand', 'stalab_brands');

function stalab_accesories()
{
    $query = new WP_Query([
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'prod_type',
                'fields' => 'slug',
                'terms' => 'accesorio'
            )
        )
    ]);
    $response = "<h2 class='col-md-12 px-0 py-3'>Accesorios</h2>";
    if (!empty($query->posts)) {
        foreach ($query->posts as $q) {
            $title = ucfirst($q->post_title);
            $response .= "<h4 class='px-0 col-md-4' data-id='{$q->ID}'><a class='previewBtn' href='{$q->guid}'>{$title}</a></h4>";
        }
    }

    echo $response;
    die();
}

add_action('wp_ajax_nopriv_stalabAccesories', 'stalab_accesories');
add_action('wp_ajax_stalabAccesories', 'stalab_accesories');

function stalab_app()
{
    $terms = get_terms('aplicacion', [
        'hide_empty' => false
    ]);
    $response = "<h2 class='col-md-12 px-0 py-3'>Aplicación</h2>";
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $title = ucfirst($term->name);
            $response .= "<h4 class='px-0 col-md-4'><a href='#' class='searchWordApp' data-value='{$term->slug}'>{$title}</a></h4>";
        }
    }

    echo $response;

    die();

}

add_action('wp_ajax_nopriv_stalabApp', 'stalab_app');
add_action('wp_ajax_stalabApp', 'stalab_app');

function stalab_muestra()
{
    $terms = get_terms('muestra', [
        'hide_empty' => false
    ]);
    $response = '';
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $title = ucfirst($term->name);
            $response .= "<h4 class='px-0 col-md-6'><a href='#' class='searchWordMuestra' data-value='{$term->name}'>{$title}</a></h4>";
        }
    }

    echo $response;

    die();

}

add_action('wp_ajax_nopriv_stalabMuestra', 'stalab_muestra');
add_action('wp_ajax_stalabMuestra', 'stalab_muestra');

function stalab_campo_app()
{
    $terms = get_terms('campo', [
        'hide_empty' => false
    ]);
    $response = '';
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $title = ucfirst($term->name);
            $response .= "<h4 class='px-0 col-md-4'><a href='#' class='searchWordCampo' data-value='{$term->name}'>{$title}</a></h4>";
        }
    }

    echo $response;

    die();

}

add_action('wp_ajax_nopriv_stalabCampoApp', 'stalab_campo_app');
add_action('wp_ajax_stalabCampoApp', 'stalab_campo_app');

function ajax_query()
{
    $tax = $_POST['tax'];
    $field = $_POST['field'];
    $search = $_POST['search'];

    $args = array(
        'post_type' => 'producto',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => $tax,
                'field' => $field,
                'terms' => (array)$search
            )
        )
    );

    $query = new WP_Query($args);

    $response = '';

    if (!empty($query->posts)) {
        foreach ($query->posts as $post) {
            $src = get_the_post_thumbnail_url($post->ID, 'full');
            $response .= "<div class='px-2 col-md-3'>";
            $response .= "<div class='img-box'>";
            $response .= "<a class='previewBtn' href='{$post->guid}'>";
            $response .= "<img src='{$src}' />";
            $response .= "</a>";
            $response .= "</div>";
            $response .= "<h4 class='title' data-id='{$post->ID}'><a class='previewBtn' href='{$post->guid}'>{$post->post_title}</a></h4>";
            $response .= "</div>";
        }
    }

    echo $response;

    die();
}

add_action('wp_ajax_nopriv_ajax_query', 'ajax_query');
add_action('wp_ajax_ajax_query', 'ajax_query');

function show_preview_thumb()
{
    $id = $_POST['id'];
    $url = get_the_post_thumbnail_url($id, [250, 300]);

    echo "<img src='{$url}' />";
    die();
}

add_action('wp_ajax_nopriv_show_preview', 'show_preview_thumb');
add_action('wp_ajax_show_preview', 'show_preview_thumb');

function get_pager()
{
    global $wp_query;

    $query = $wp_query;
    $big = 999999999;

    if ($query->max_num_pages > 1) {
        echo "<div class='wp-pagenavi'>";
        echo paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        ]);
        echo "</div>";
    }
}

function stalab_rest_search($data)
{
    global $wpdb;

    $search = $data->get_param('s');
    $searchlike = $search . '%';

    /**
     * SELECT t.term_id, name FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id WHERE t.name LIKE 'liquid%' ORDER BY t.name ASC
     */

    $query = $wpdb->get_results(
        $wpdb->prepare("SELECT t.term_id, name FROM wp_terms AS t
          INNER JOIN wp_term_taxonomy AS tt ON tt.term_id = t.term_id
          WHERE t.name LIKE '%s' ORDER BY t.name ASC", $searchlike, $searchlike)
    );


    /**$query = $wpdb->get_results(
     * $wpdb->prepare( "SELECT DISTINCT ID, post_title, guid FROM $wpdb->posts AS p
     * INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id)
     * INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
     * INNER JOIN $wpdb->terms AS t ON (tt.term_id = t.term_id)
     * INNER JOIN $wpdb->postmeta AS pm ON (p.ID = pm.post_id)
     * WHERE p.post_status = 'publish'
     * AND p.post_type = 'producto'
     * AND (tt.taxonomy = 'muestra' OR tt.taxonomy = 'campo' OR pm.meta_key = 'aplicacion')
     * AND (t.name LIKE '%s' OR pm.meta_value LIKE '%s')", $searchlike, $searchlike )
     * );*/

    return $query;
}

add_action('rest_api_init', function () {
    register_rest_route('stalab-products/v1', '/product', [
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'stalab_rest_search',
        'args' => namespace_get_search_args()
    ]);
});

function namespace_get_search_args()
{
    $args = [];
    $args['s'] = [
        'description' => 'Busqueda de productos',
        'type' => 'string'
    ];

    return $args;
}

add_action('init', 'rewrite_rule_alphabetic');

function rewrite_rule_alphabetic()
{
    global $wp, $wp_rewrite;

    $wp->add_query_var('view');
    $wp_rewrite->add_rule('alfa/([^/]+)/all', 'index.php?view=all&page_id=1467&name=$matches[1]', 'top');

    $wp_rewrite->flush_rules['view'];
}

add_action('phpmailer_init', 'mailer_config', 10, 1);

/**
 * @param PHPMailer $mailer | función para controlar el usuario SMTP con el que se enviará el correo de contacto
 */
function mailer_config(PHPMailer $mailer)
{
    $mailer->isSMTP();
    $mailer->Host = "smtp.gmail.com";           // Host del mail
    $mailer->Port = 587;                         // Número de puerto
    $mailer->Username = "cristiancartesa@gmail.com";    // Usuario o mail a usar
    $mailer->Password = "BroadwaY_1973";            // Clave del mail
    $mailer->SMTPDebug = 0;                     // Depuración de errores
    $mailer->CharSet = "UTF-8";                 // Codificación del texto del mail
    $mailer->isHTML(true);               // Formato del mail
    $mailer->SMTPAutoTLS = true;               // Auto TLS o SSL
    $mailer->SMTPSecure = 'tls';                // Seguridad
    $mailer->SMTPAuth = true;                  // Autentificación
}

