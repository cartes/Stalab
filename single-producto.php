<?php
get_header();

if (!tokopress_get_mod('tokopress_page_title_disable')) :
    get_template_part('block-page-title');
endif;

the_post();
?>

<div id="main-content">
    <div id="editor"></div>
    <div id="contentPDF" style="background-color: white;" class="position-relative container pt-5 pb-3">
        <div id="firstPDF">
            <table id="descripcion-table" class="table table-borderless">
                <tr>
                    <td>
                        <h2 id="prod-ficha"><?php the_title() ?></h2>
                    </td>
                    <td class="logoMarca">
                        <?php
                        $image = get_field('logo_image');
                        if ($image) {
                            echo "<div class='row p-0 my-3'>";
                            echo "<div class='mx-auto'>";
                            echo wp_get_attachment_image($image['ID'], 'full');
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="descripcion text-justify" style="width: 626px;">
                        <?php the_content(); ?>
                    </td>
                    <td id="img-table" style="width: 460px;">
                        <?php
                        echo "<div class='featured-img'>";
                        the_post_thumbnail('medium');
                        echo "</div>";
                        $images = get_field('galeria_de_imagenes');
                        if ($images) {
                            echo "<div class='gallery gallery-item'>";
                            foreach ($images as $img_id) {
                                $url = wp_get_attachment_image_url($img_id, 'full');
                                echo "<a href='$url' data-lightbox='product'>";
                                echo wp_get_attachment_image($img_id, [150, 150], [
                                    'class' => 'gallery'
                                ]);
                                echo "</a>";
                            }
                            echo "</div>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <table id="table-campos" class="table table-borderless" style="width: 626px;">
                <?php
                $app = get_field('aplicacion');
                if ($app) {
                    ?>
                    <tr>
                        <td class="subtitle">
                            <?php
                            echo "<h5 class='h5 col-12 p-0'>Aplicaciones</h5>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo apply_filters('the_content', $app); ?>
                        </td>
                    </tr>
                <?php } ?>

                <?php
                product_terms('muestra');
                ?>

                <?php
                product_terms('campo');
                ?>
            </table>
        </div>
        <div class="row p-0 m-0 mb-3 botonPDF">
            <div class="col-4">
                <button type="button" class="downloadPDF btn btn-primary">
                    Descargar Ficha en PDF <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="col-4">

                <a type="button" href="<?php echo home_url('/cotizaciones/') . "?prod=$post->ID" ?>" class="btn btn-cotizar">
                    Cotizar en línea
                </a>
            </div>
        </div>

        <div id="tablePDF" class="row mb-3">
            <div class="col-12">
                <table id="caracteristicas" class="table table-hover">
                    <?php
                    if (have_rows('feature_repeater')) {
                        echo "<thead>";
                        echo "<tr><th>Características</th><th></th></tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while (have_rows('feature_repeater')) {
                            the_row();
                            $featName = get_sub_field('feature_name');

                            $rowspan = count(get_sub_field('valores'));
                            $rowspan = ($rowspan > 1) ? "rowspan='{$rowspan}'" : "";

                            if (have_rows('valores')) {
                                $i = 1;
                                echo "<tr>";
                                echo "<td style='min-width: 130px'><strong>{$featName}</strong></td>";
                                while (have_rows('valores')) {
                                    the_row();
                                    $featValue = get_sub_field('feature_value');
                                    if ($i == 1) {
                                        echo "<td>{$featValue}</td>";
                                    } else {
                                        echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>{$featValue}</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                                echo "</tr>";
                            }
                        }
                        echo "</tbody>";
                    }
                    ?>
                </table>
            </div>
        </div>


        <div class="row mb-3">
            <?php
            if (have_rows('relative_repeater')) {
                echo "<h5 class='h5 col-12'>Productos Relacionados</h5>";
                while (have_rows('relative_repeater')) {
                    the_row();
                    $relative = get_sub_field('relative');
                    $img_url = wp_get_attachment_url(get_post_thumbnail_id($relative->ID));
                    $permalink = get_permalink($relative->ID);

                    echo "<div class='card' style='width: 18rem'>";
                    echo "<a href='{$permalink}'>";
                    echo "<img src='{$img_url}' class='card-img-top' />";
                    echo "</a>\n";
                    echo "<div class='card-body'>";
                    echo "<a href='{$permalink}'>";
                    echo "<h5 class='card-title'>{$relative->post_title}</h5>";
                    echo "</a>\n";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
            <input type="hidden" id="tmp"/>
            <input type="hidden" id="feattemp"/>
        </div>
        <div class="row mb-3">
            <?php
            if (have_rows('accesory_repeater')) {
                echo "<h5 class='h5 col-12'>Accesorios</h5>";
                while (have_rows('accesory_repeater')) {
                    the_row();
                    $accesory = get_sub_field('accesory');
                    $img_url = wp_get_attachment_url(get_post_thumbnail_id($accesory->ID));
                    $permalink = get_permalink($accesory->ID);

                    echo "<div class='card' style='width: 18rem'>";
                    echo "<img src='{$img_url}' class='card-img-top' />";
                    echo "<div class='card-body'>";
                    echo "<a href='{$permalink}'>";
                    echo "<h5 class='card-title'>{$accesory->post_title}</h5>";
                    echo "</a>\n";
                    echo "<p class='card-text'>{$accesory->post_content}</p>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
            <input type="hidden" id="tmp"/>
            <input type="hidden" id="feattemp"/>
        </div>

    </div>
</div>


<script src="<?php echo get_stylesheet_directory_uri() . '/assets/lightbox/js/lightbox.js' ?>"></script>

<?php
get_footer();
?>
