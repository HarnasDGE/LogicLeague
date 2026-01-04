<?php
/**
 * Funkcje motywu LogicLeague
 *
 * @package LogicLeague
 */

// Zabezpieczenie przed bezpośrednim dostępem
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Ładowanie klas Sudoku
 */
require_once get_template_directory() . '/inc/sudoku/class-sudoku-validator.php';
require_once get_template_directory() . '/inc/sudoku/class-sudoku-solver.php';
require_once get_template_directory() . '/inc/sudoku/class-sudoku-generator.php';

/**
 * Konfiguracja motywu
 */
function logicleague_setup() {
    // Dodaj wsparcie dla title tag
    add_theme_support( 'title-tag' );

    // Dodaj wsparcie dla miniaturek
    add_theme_support( 'post-thumbnails' );

    // Dodaj wsparcie dla automatycznych RSS linków
    add_theme_support( 'automatic-feed-links' );

    // Dodaj wsparcie dla HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Rejestracja menu
    register_nav_menus( array(
        'primary' => __( 'Menu główne', 'logicleague' ),
    ) );
}
add_action( 'after_setup_theme', 'logicleague_setup' );

/**
 * Załaduj style i skrypty
 */
function logicleague_enqueue_scripts() {
    // Załaduj główny arkusz stylów z dynamiczną wersją (cache-busting)
    wp_enqueue_style(
        'logicleague-style',
        get_stylesheet_uri(),
        array(),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    // Front Page CSS
    if ( is_front_page() ) {
        wp_enqueue_style(
            'front-page',
            get_template_directory_uri() . '/assets/css/front-page.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/front-page.css' )
        );
    }

    // Blog CSS
    if ( is_singular('post') || is_archive() || is_home() ) {
        wp_enqueue_style(
            'blog',
            get_template_directory_uri() . '/assets/css/blog.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/blog.css' )
        );

        // Blog JS (for ToC generation)
        wp_enqueue_script(
            'blog',
            get_template_directory_uri() . '/assets/js/blog.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/blog.js' ),
            true
        );
    }

    // Sudoku Landing Page CSS
    if ( get_query_var( 'sudoku_landing' ) || is_page( 'sudoku' ) ) {
        wp_enqueue_style(
            'sudoku-landing',
            get_template_directory_uri() . '/assets/css/sudoku-landing.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/sudoku-landing.css' )
        );
    }

    // Sudoku Play CSS & JS
    if ( get_query_var( 'sudoku_play' ) || is_page( 'sudoku-play' ) ) {
        wp_enqueue_style(
            'sudoku-play',
            get_template_directory_uri() . '/assets/css/sudoku-play.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/sudoku-play.css' )
        );

        wp_enqueue_script(
            'sudoku-player',
            get_template_directory_uri() . '/assets/js/sudoku-player.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/sudoku-player.js' ),
            true
        );
    }

    // Quiz CSS & JS
    if ( is_singular('quiz') ) {
        wp_enqueue_style(
            'quiz',
            get_template_directory_uri() . '/assets/css/quiz.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/quiz.css' )
        );

        wp_enqueue_script(
            'quiz-player',
            get_template_directory_uri() . '/assets/js/quiz-player.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/quiz-player.js' ),
            true
        );

        // Pass quiz data to JavaScript
        $questions = get_post_meta(get_the_ID(), 'quiz_questions', true);
        wp_localize_script('quiz-player', 'quizData', array(
            'quizId' => get_the_ID(),
            'quizTitle' => get_the_title(),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'shareUrl' => get_permalink(),
        ));
    }
}
add_action( 'wp_enqueue_scripts', 'logicleague_enqueue_scripts' );

/**
 * Add custom rewrite rules for Sudoku URLs
 */
function logicleague_sudoku_rewrite_rules() {
    // /sudoku/daily/{level} - daily sudoku
    add_rewrite_rule(
        '^sudoku/daily/(easy|medium|hard|expert)/?$',
        'index.php?sudoku_play=1&sudoku_level=$matches[1]&sudoku_type=daily',
        'top'
    );

    // /sudoku/{level} - regular sudoku
    add_rewrite_rule(
        '^sudoku/(easy|medium|hard|expert)/?$',
        'index.php?sudoku_play=1&sudoku_level=$matches[1]&sudoku_type=regular',
        'top'
    );

    // /sudoku - landing page
    add_rewrite_rule(
        '^sudoku/?$',
        'index.php?sudoku_landing=1',
        'top'
    );
}
add_action( 'init', 'logicleague_sudoku_rewrite_rules' );

/**
 * Add custom query vars
 */
function logicleague_sudoku_query_vars( $vars ) {
    $vars[] = 'sudoku_play';
    $vars[] = 'sudoku_landing';
    $vars[] = 'sudoku_level';
    $vars[] = 'sudoku_type';
    return $vars;
}
add_filter( 'query_vars', 'logicleague_sudoku_query_vars' );

/**
 * Auto-assign Sudoku templates
 */
function logicleague_assign_sudoku_template( $template ) {
    // Sudoku Play - /sudoku/{level} or /sudoku/daily/{level}
    if ( get_query_var( 'sudoku_play' ) ) {
        $custom_template = get_template_directory() . '/templates/page-sudoku-play.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }

    // Sudoku Landing - /sudoku
    if ( get_query_var( 'sudoku_landing' ) || is_page( 'sudoku' ) ) {
        $custom_template = get_template_directory() . '/templates/page-sudoku.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }

    // Fallback dla starych URLi
    if ( is_page( 'sudoku-play' ) ) {
        $custom_template = get_template_directory() . '/templates/page-sudoku-play.php';
        if ( file_exists( $custom_template ) ) {
            return $custom_template;
        }
    }

    return $template;
}
add_filter( 'template_include', 'logicleague_assign_sudoku_template' );

/**
 * Rejestracja widget areas
 */
function logicleague_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'logicleague' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Dodaj widgety tutaj.', 'logicleague' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'logicleague_widgets_init' );

/**
 * Register Quiz and Question Custom Post Types
 */
function logicleague_register_quiz_cpts() {
    // Register Quiz CPT
    register_post_type('quiz', array(
        'labels' => array(
            'name' => 'Quizzes',
            'singular_name' => 'Quiz',
            'add_new' => 'Add New Quiz',
            'add_new_item' => 'Add New Quiz',
            'edit_item' => 'Edit Quiz',
            'new_item' => 'New Quiz',
            'view_item' => 'View Quiz',
            'search_items' => 'Search Quizzes',
            'not_found' => 'No quizzes found',
            'not_found_in_trash' => 'No quizzes found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'quiz'),
        'menu_icon' => 'dashicons-forms',
        'taxonomies' => array('quiz_category')
    ));

    // Register Question CPT
    register_post_type('question', array(
        'labels' => array(
            'name' => 'Questions',
            'singular_name' => 'Question',
            'add_new' => 'Add New Question',
            'add_new_item' => 'Add New Question',
            'edit_item' => 'Edit Question',
            'new_item' => 'New Question',
            'view_item' => 'View Question',
            'search_items' => 'Search Questions',
            'not_found' => 'No questions found',
            'not_found_in_trash' => 'No questions found in trash'
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'custom-fields', 'thumbnail'),
        'menu_icon' => 'dashicons-editor-help',
        'show_in_menu' => 'edit.php?post_type=quiz'
    ));

    // Register Quiz Category Taxonomy
    register_taxonomy('quiz_category', 'quiz', array(
        'labels' => array(
            'name' => 'Quiz Categories',
            'singular_name' => 'Quiz Category',
            'search_items' => 'Search Quiz Categories',
            'all_items' => 'All Quiz Categories',
            'parent_item' => 'Parent Quiz Category',
            'parent_item_colon' => 'Parent Quiz Category:',
            'edit_item' => 'Edit Quiz Category',
            'update_item' => 'Update Quiz Category',
            'add_new_item' => 'Add New Quiz Category',
            'new_item_name' => 'New Quiz Category Name',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'quiz-category'),
    ));
}
add_action('init', 'logicleague_register_quiz_cpts');

/**
 * Custom comment callback
 */
function logicleague_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('comment'); ?>>
        <div class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 50); ?>
            </div>

            <div class="comment-content-wrap">
                <div class="comment-meta">
                    <span class="comment-author-name">
                        <?php echo get_comment_author_link(); ?>
                    </span>
                    <span class="comment-date">
                        <?php echo get_comment_date() . ' at ' . get_comment_time(); ?>
                    </span>
                </div>

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>

                <div class="reply">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => '↩ Reply'
                    )));
                    ?>
                    <?php if (current_user_can('edit_comment', $comment->comment_ID)): ?>
                        <span class="comment-separator"> | </span>
                        <?php edit_comment_link('✎ Edit', '', ''); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php
}

