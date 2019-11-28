<?php
get_header();

if (!tokopress_get_mod('tokopress_page_title_disable')) {
    get_template_part('block-page-title');
}
?>

<div id="main-content" class="container-fluid">
    <div class="container-fluid pt-5 pb-4">
        <?php get_template_part("./assets/partials/stalab_searchBar", "part") ?>
        <?php
        if (have_posts()) {
            echo "<div class='container container-archive'>";
            echo "<div class='row'>";
            while (have_posts()) {
                the_post();
                $src = get_the_post_thumbnail_url($post->ID, 'medium');
                $link = get_permalink($post->ID);
                echo "<div class='px-2 col-md-3'>";
                echo "<div class='img-box'>";
                echo "<a class='previewBtn' href='{$link}'>";
                echo "<img src='{$src}' />";
                echo "</a>";
                echo "</div>";
                echo "<h4 class='title'><a href='{$link}'>{$post->post_title}</a></h4>";
                echo "<a href='" . home_url('/cotizaciones/') . "?prod=$post->ID' class='btn btn-cotizar'>Cotizar</a>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='container container-archive'>";
            echo "<div class='row'>";
            echo "<h2 class='col-12'>No se ha encontrado productos en esta categoría</h2>";
            echo "</div>";
            echo "</div>";
        }

        ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="mx-auto my-4">
                <?php get_pager(); ?>
            </div>
            <h4 class='col-12'><a href='javascript:history.back()'>&laquo; Volver</a></h4>
        </div>
    </div>
</div>

<?php get_footer() ?>