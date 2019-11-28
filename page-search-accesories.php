<?php
/**
 *
 * Template name: Page Search Accesories
 *
 */

$accesories = new WP_Query([
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'asc',
    'tax_query' => array(
        array(
            'taxonomy' => 'prod_type',
            'field' => 'slug',
            'terms' => 'accesorio'
        )
    )
]);

get_header();

if (!tokopress_get_mod('tokopress_page_title_disable')) {
    get_template_part('block-page-title');
}
?>

<div id="main-content" class="container-fluid">
    <div class="container-fluid pt-5 pb-4">
        <?php get_template_part("./assets/partials/stalab_searchBar", "part") ?>

        <?php
        if (!empty($accesories->posts)) {
            $response = "<div class='container'>";
            $response .= "<div class='row'>";
            $response .= "<h2 class='col-md-12 px-0 py-3'>Accesorios</h2>";
            $response .= "</div>";
            $response .= "</div>";
            $response .= "<div class='container'>";
            $response .= "<div class='row equal'>";
            foreach ($accesories->posts as $accesory) {
                $title = ucfirst($accesory->post_title);
                $response .= "<h4 class='px-0 pr-5 mb-3 col-md-4' data-id='{$accesory->ID}'><a class='previewBtn' href='" . get_permalink($accesory->ID) . "'>{$title}</a></h4>";
            }
            $response .= "</div>";
            $response .= "</div>";
        }

        echo $response;
        ?>
    </div>

    <div class="row">
        <?php get_template_part("./assets/partials/stalab_mostSearch", "part") ?>
    </div>

</div>

<?php get_footer() ?>
