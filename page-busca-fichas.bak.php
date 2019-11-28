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
                        $searchlike = '%' . $search . '%';

                        echo "<div class='col-12'>";
                        echo "<h2>Resultado de busqueda para: {$search}</h2>";
                        echo "</div>";

                        /** @var $query
                         * Busqueda en las taxonomias "Muestra" o en la taxonomia "Campo" o en l campo de busqueda "Aplicacion"
                         */

                        $query = $wpdb->get_results(
                            $wpdb->prepare( "SELECT DISTINCT ID, post_title, guid FROM $wpdb->posts AS p 
                                INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id) 
                                INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
                                INNER JOIN $wpdb->terms AS t ON (tt.term_id = t.term_id)
                                INNER JOIN $wpdb->postmeta AS pm ON (p.ID = pm.post_id)
                                WHERE p.post_status = 'publish' 
                                AND p.post_type = 'producto'
                                AND (tt.taxonomy = 'muestra' OR tt.taxonomy = 'campo' OR pm.meta_key = 'aplicacion') 
                                AND (t.name LIKE '%s' OR pm.meta_value LIKE '%s')", $searchlike, $searchlike )
                        );


                        /** @var $query Original va a ser reemplazado por un nuevo query */
                        /**
                         *
                         **/


                        if (!empty($query)) {
                            foreach ($query as $post) {
                                $src = get_the_post_thumbnail_url($post->ID, [300, 200]);
                                echo "<div class='px-2 col-md-3'>";
                                echo "<div class='img-box'>";
                                echo "<a class='previewBtn' href='{$post->guid}'>";
                                echo "<img src='{$src}'/>";
                                echo "</div>";
                                echo "<h4 class='title mx-auto aligncenter mt-3 mb-5' data-id='{$post->ID}'><a class='previewBtn' href='{$post->guid}'>{$post->post_title}</a></h4>";
                                echo "</div>";

                                $searches = get_field('_hiddenSearch', $post->ID);
                                if ($searches) {
                                    $searches = (int)$searches;
                                    $searches += 1;
                                    update_field('_hiddenSearch', $searches, $post->ID);
                                } else {
                                    update_field('_hiddenSearch', 1, $post->ID);
                                }
                            }
                        } else {
                            echo "<h3 class='py-5 px-2'>No hemos encontrado lo que buscas</h3>";
                        }
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