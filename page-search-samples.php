<?php
/**
 *
 * Template name: Page Search Samples
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
        $samples = get_terms([
            'post_type' => ['producto'],
            'taxonomy' => 'muestra'
        ]);

        if (!empty($samples)) {
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo "<h2 class='col-md-12 py-3 px-0'>Tipo de Muestras</h2>";
            echo "</div>";
            echo "<div class='row equal'>";
            foreach ($samples as $sample) {
                $title = ucfirst($sample->name);
                echo "<h4 class='px-0 pr-5 mb-3 col-md-6'><a href='" . home_url() . "/muestra/{$sample->slug}'>{$title}</a></h4>";
            }
            echo "</div>";
            echo "</div>";
        }

        ?>
    </div>
</div>
