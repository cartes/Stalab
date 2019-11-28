<?php
/**
 * Template name: Plantilla Busqueda Fichas
 *
 */

get_header();
?>

<?php if (!tokopress_get_mod('tokopress_page_title_disable')) : ?>
    <?php get_template_part('block-page-title'); ?>
<?php endif; ?>

    <div id="main-content" class="container-fluid">
        <div class="container pt-5 pb-4">

            <?php get_template_part("./assets/partials/stalab_searchBar", "part") ?>

            <div id="results-container" class="container position-relative">
                <div class="results row pt-5 mt-4 mb-4">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $search = $_POST['search'];
                        $advance = new AdvancedSearch($search);

                        echo $advance->getSearch();
                    }
                    ?>
                </div>
                <div class="preview d-none"></div>
            </div>

            <div class="row">
                <?php get_template_part("./assets/partials/stalab_mostSearch", "part") ?>
            </div>

        </div>
    </div>

<?php
get_footer();
?>