<?php
/**
 * User: cristiancartes
 * Date: 13-11-19
 * Time: 16:44
 */

define('DOING_AJAX', true);

if (!isset($_POST['action'])) die('-1');

$action = esc_attr(trim($_POST['action']));

ini_set('html_errors', 0);

define('SHORTINIT', true);
require_once('../../../wp-load.php');

header('Content-Type: text/html');
send_nosniff_header();

header('Cache-Control: no-cache');
header('Pragma: no-cache');

require( ABSPATH . WPINC . '/formatting.php' );
require( ABSPATH . WPINC . '/meta.php' );
require( ABSPATH . WPINC . '/post.php' );

if (is_user_logged_in()) {
    do_action("wp_ajax_{$action}");
} else {
    do_action("wp_ajax_nopriv_{$action}");

}

wp_die('0');