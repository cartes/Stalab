<?php
/**
 *
 * Template name: Page Search Fields
 *
 */

get_header();

if (!tokopress_get_mod('tokopress_page_title_disable')) {
    get_template_part('block-page-title');
}
?>

<div id="main-content" class="container-fluid">
    <div class="container-fluid pt-5 pb-4">
        <?php get_template_part("./assets/partials/stalab_searchBar", "part") ?>

        <?php
        $fields = get_terms([
            'post_type' => ['producto'],
            'taxonomy' => 'campo'
        ]);

        if (!empty($fields)) {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<h2 class='col-md-12 py-3 px-0'>Campos de Aplicación</h2>";
            echo "</div>";
            echo "<div class='row equal'>";
            foreach ($fields as $field) {
                $title = ucfirst($field->name);
                echo "<h4 class='px-0 pr-5 mb-3 col-md-6'><a href='" . home_url() . "/campo/{$field->slug}'>{$title}</a></h4>";

            }
            echo "</div>";
            echo "</div>";
        }

        ?>
    </div>
</div>