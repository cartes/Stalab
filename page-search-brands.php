<?php
/**
 *
 * Template name: Page Search Brands
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
        $brands = get_terms([
            'post_type' => ['producto'],
            'taxonomy' => 'brands'
        ]);

        $excl = [];

        foreach($brands as $brand) {
            $term = 'term_' . $brand->term_taxonomy_id;
            $select = get_field('logo_exclusiva', $term);

            if ($select) {
                $excl[] = $brand;
            }
        }

        if (!empty($brands)) {
            $txt = "<div class='container'>";
            $txt .= "<div class='row equal'>";
            if ($excl) {

                $titleNameExclusive = get_field('exclusive_brands', 'option');

                $txt .= "<h2 class='col-md-12 px-0 py-3'>$titleNameExclusive</h2>";

                foreach ($excl as $e) {
                    $title = ucfirst($e->name);
                    $term = 'term_' . $e->term_taxonomy_id;
                    $srcimg = get_field('logo-marca', $term);
                    $txt .= "<h4 class='px-0 col-md-4'>";
                    $txt .= "<div class='py-4'>";
                    $txt .= "<a href='" . home_url() . "/marca/{$e->slug}'><img class='brand-logo mb-3' style='width: 50%; height: auto; display: block;' src='{$srcimg}' /></a>";
                    $txt .= "</div>";
                    $txt .= "<a href='" . home_url() . "/marca/{$e->slug}'>{$title}</a>";
                    $txt .= "</h4>";
                }
            }
            $txt .= "<h2 class='col-md-12 px-0 py-3 pt-5 mt-5 marcas-genericas'>Marcas</h2>";
            foreach ($brands as $brand) {
                $title = ucfirst($brand->name);
                $term = 'term_' . $brand->term_taxonomy_id;
                $srcimg = get_field('logo-marca', $term);
                $show = get_field('logo_search', $term);
                if ($show) {
                    $txt .= "<h4 class='px-0 col-md-4'>";
                    $txt .= "<div class='py-4'>";
                    $txt .= "<a href='" . home_url() . "/marca/{$brand->slug}'><img class='brand-logo mb-3' style='width: 50%; height: auto; display: block;' src='{$srcimg}' /></a>";
                    $txt .= "</div>";
                    $txt .= "<a href='" . home_url() . "/marca/{$brand->slug}'>{$title}</a>";
                    $txt .= "</h4>";
                }

            }
            $txt .= "</div>";
            $txt .= "</div>";
        } else {
            $txt = "<h2 class='col-md-12 px-0 py-3'>No hay marcas en esta categoría</h2>";
        }

        echo $txt;
        ?>
    </div>
</div>

<?php
get_footer();
?>
