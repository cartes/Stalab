<?php
/**
 *
 * Template name: Page Search Alphabetic
 *
 */

global $wp, $wpdb;

$letter = strtoupper($wp->query_vars['view']);

$ids = $wpdb->get_col(
    $wpdb->prepare("SELECT DISTINCT ID FROM $wpdb->posts WHERE SUBSTR($wpdb->posts.post_title,1,1) = %s",
        $letter)
);
$query_menu = new WP_Query([
    'post_type' => ['product_word'],
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
]);
if ($letter) {
    $query = new WP_Query([
        'post_type' => ['product_word'],
        'post__in' => $ids,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
} else {
    $query = $query_menu;
}
$alfa_menu = "<ul class='alfa-menu'>\r\n";
if ($query_menu->posts) {
    $prev_letter = '';
    foreach ($query_menu->posts as $post) {
        $curr_letter = strtoupper(substr($post->post_title, 0, 1));
        if ($curr_letter != $prev_letter) {
            $class_menu = ($letter == $curr_letter) ? "letter-menu current-letter" : "letter-menu";
            $alfa_menu .= "<li class='$class_menu'><a href='" . home_url('buscador-de-productos/alfabetico/?view=' . $curr_letter) . "'>$curr_letter</a></li>";
            $prev_letter = $curr_letter;
        }
    }
    $alfa_menu .= "</ul>";
}

get_header();


if (!tokopress_get_mod('tokopress_page_title_disable')) {
    get_template_part('block-page-title');
}
?>

<div id="main-content" class="container-fluid">
    <div class="container-fluid pt-5 pb-4">
        <?php get_template_part("./assets/partials/stalab_searchBar", "part") ?>

        <?php
        if (!empty($query->posts)) {
            $response = "<div class='container'>";
            $response .= "<div class='row equal'>";
            $response .= $alfa_menu;
            if (!$letter) {
                $response .= "<h2 class='col-md-12 px-0 py-3'>De la A a la Z</h2>";
            }
            $curr_letter = '';
            $prev_letter = '';

            foreach ($query->posts as $post) {
                $curr_letter = strtoupper(substr($post->post_title, 0, 1));
                if ($curr_letter != $prev_letter) {
                    $response .= "<h3 class='col-12 px-0'>{$curr_letter}</h3>";
                    $prev_letter = $curr_letter;
                }
                $response .= "<div class='item px-3 col-md-3'>";
                $response .= "<div class='mx-auto thumb-item-container'>";
                if (has_post_thumbnail($post->ID)) {
                    $response .= "<a href='" . home_url() . "/tipo-producto/{$post->post_name}'>";
                    $response .= get_the_post_thumbnail($post->ID, [210, 210], ['class' => 'thumb-item mx-auto']);
                    $response .= "</a>";
                } else {
                    $response .= "<a href='" . home_url() . "/tipo-producto/{$post->post_name}'>";
                    $response .= "<img class='mx-auto thumb-item' src='" . get_stylesheet_directory_uri() . "/img/stalab_thumb-100.jpg' />";
                    $response .= "</a>";
                }
                $response .= "</div>";
                $response .= "<h4 class='item-title aligncenter pt-3 mb-5'><a href='" . home_url() . "/tipo-producto/{$post->post_name}'>{$post->post_title}</a></h4>";
                $response .= "</div>";
            }

            $response .= "</div>";
            $response .= "</div>";
        }
        echo $response;
        ?>
    </div>
</div>

<?php get_footer() ?>
