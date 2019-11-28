<div class="container px-0">
    <div class="col-md-12 px-0 popular">
        <h4 class="row">Lo más buscado</h4>
        <?php
        $most = new WP_Query([
            'post_type' => 'producto',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'meta_key' => '_hiddenSearch',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'tax_query' => [
                [
                    'taxonomy' => 'prod_type',
                    'field' => 'slug',
                    'terms' => 'accesorio',
                    'operator' => 'NOT IN'
                ]
            ]
        ]);
        echo "<div class='row'>";
        if ($most->have_posts()) {
            while ($most->have_posts()) {
                $most->the_post();
                $featured_img_url = get_the_post_thumbnail_url($post->ID, [200, 200]);
                echo "<div class='columna col-sm-3'>";
                echo "<a href='{$post->guid}'><div class='img-box'><img src='{$featured_img_url}' /></div></a>";
                echo "<h5><a href='{$post->guid}'>" . get_the_title() . "</a></h5>";
                echo "</div>";
                $searches = get_field('_hiddenSearch');
            }
        }
        echo "</div>";
        ?>
    </div>
</div>