<?php
get_header();
global $wp_query;
$tax = $wp_query->get_queried_object();

?>

<div class="container">

    <div class="col-12">
        <div class="row mb-4">
            <div class="col-12">
                <?php
                $term = get_taxonomy(get_query_var('taxonomy'));
                ?>
                <h6><?php echo $term->label ?></h6>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <h2>
                    <?php
                    $title = ucfirst($tax->name);
                    echo $title;
                    ?>
                </h2>
            </div>
        </div>

        <div class="row">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $response = '';
                    $title = get_the_title();
                    $link = get_permalink();
                    $src = get_the_post_thumbnail_url($post->ID, 'full');

                    $response .= "<div class='blog-list col-sm-6 col-md-4'>";
                    if (has_post_thumbnail()) :
                        $response .= '<div class="post-thumbnail">';
                        $response .= get_the_post_thumbnail($post->ID, [400, 200]);
                        $response .= '</div>';
                    endif;
                    $response .= "<div class='post-inner'>";
                    $response .= "<a class='post-title entry-title' href='{$link}'><h2>{$title}</h2></a>";
                    $response .= "</div>";
                    $response .= "</div>";

                    echo $response;
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>
