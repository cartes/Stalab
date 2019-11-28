<?php
/**
 * Created by PhpStorm.
 * User: cristiancartes
 * Date: 28-11-19
 * Time: 09:00
 */

class AdvancedSearch
{
    public $search;

    public function __construct($search)
    {
        $this->setSearch($search);
    }

    public function setSearch($s)
    {
        $this->search = $s;
    }

    public function getSearch()
    {
        global $wpdb;

        $searchlike = '%' . $this->search . '%';

        $content = "<div class='col-12'>";
        $content .= "<h2>Resultado de busqueda para: {$this->search}</h2>";
        $content .= "</div>";

        $query = $wpdb->get_results(
            $wpdb->prepare("SELECT DISTINCT ID, post_title, guid FROM $wpdb->posts AS p 
                            INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id) 
                            INNER JOIN $wpdb->term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
                            INNER JOIN $wpdb->terms AS t ON (tt.term_id = t.term_id)
                            INNER JOIN $wpdb->postmeta AS pm ON (p.ID = pm.post_id)
                            WHERE p.post_status = 'publish' 
                            AND p.post_type = 'producto'
                            AND (tt.taxonomy = 'muestra' OR tt.taxonomy = 'campo' OR pm.meta_key = 'aplicacion') 
                            AND (t.name LIKE '%s' OR pm.meta_value LIKE '%s')", $searchlike, $searchlike)
        );

        if (!empty($query)) {
            foreach ($query as $post) {
                $src = get_the_post_thumbnail_url($post->ID, [300, 200]);
                $content .= "<div class='px-2 col-md-3'>";
                $content .= "<div class='img-box'>";
                $content .= "<a class='previewBtn' href='{$post->guid}'>";
                $content .= "<img src='{$src}'/>";
                $content .= "</div>";
                $content .= "<h4 class='title mx-auto aligncenter mt-3 mb-5' data-id='{$post->ID}'><a class='previewBtn' href='{$post->guid}'>{$post->post_title}</a></h4>";
                $content .= "</div>";

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
            $content .= "<h3 class='py-5 px-2'>No hemos encontrado lo que buscas</h3>";
        }

        return $content;
    }
}