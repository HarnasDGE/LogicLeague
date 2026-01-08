<?php
/**
 * Debug Styles Helper
 *
 * Add ?debug_styles=1 to any page URL to see which CSS files are being loaded
 *
 * @package LogicLeague
 */

if ( isset($_GET['debug_styles']) && $_GET['debug_styles'] == '1' ) {
    add_action('wp_footer', function() {
        global $wp_styles;

        echo '<div style="position: fixed; bottom: 0; left: 0; right: 0; background: black; color: lime; padding: 20px; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto; z-index: 99999; border-top: 3px solid lime;">';
        echo '<strong>🔍 DEBUG: Loaded Stylesheets</strong><br>';
        echo '<hr style="border-color: lime;">';

        echo '<strong>Page Info:</strong><br>';
        echo 'Template: ' . get_page_template_slug() . '<br>';
        echo 'Page Slug: ' . get_post_field('post_name', get_post()) . '<br>';
        echo 'Page Title: ' . get_the_title() . '<br>';
        echo 'URL: ' . $_SERVER['REQUEST_URI'] . '<br>';
        echo 'is_page_template(page-about.php): ' . (is_page_template('page-about.php') ? 'YES' : 'NO') . '<br>';
        echo 'is_page(about): ' . (is_page('about') ? 'YES' : 'NO') . '<br>';
        echo '<hr style="border-color: lime;">';

        echo '<strong>Enqueued Styles:</strong><br>';
        if (!empty($wp_styles->queue)) {
            foreach($wp_styles->queue as $handle) {
                if (isset($wp_styles->registered[$handle])) {
                    $style = $wp_styles->registered[$handle];
                    echo "✓ {$handle}: {$style->src}<br>";
                }
            }
        } else {
            echo 'No styles queued<br>';
        }

        echo '<hr style="border-color: lime;">';
        echo '<strong>About CSS Checks:</strong><br>';
        echo '1. is_page_template: ' . (is_page_template('page-about.php') ? '✓ TRUE' : '✗ FALSE') . '<br>';
        echo '2. is_page: ' . (is_page(array('about', 'about-us', 'o-nas')) ? '✓ TRUE' : '✗ FALSE') . '<br>';
        echo '3. URL match: ' . (preg_match('/\/(about|o-nas|about-us)/i', $_SERVER['REQUEST_URI']) ? '✓ TRUE' : '✗ FALSE') . '<br>';
        echo '4. Title match: ' . ((stripos(get_the_title(), 'about') !== false || stripos(get_the_title(), 'o nas') !== false) ? '✓ TRUE' : '✗ FALSE') . '<br>';

        echo '<hr style="border-color: lime;">';
        echo '<strong>Expected Handle:</strong> logicleague-about-page<br>';
        echo '<strong>Is Loaded:</strong> ';
        if (in_array('logicleague-about-page', $wp_styles->queue)) {
            echo '<span style="color: lime; font-weight: bold;">✓ YES!</span><br>';
        } else {
            echo '<span style="color: red; font-weight: bold;">✗ NO!</span><br>';
        }

        echo '</div>';
    }, 999);
}
