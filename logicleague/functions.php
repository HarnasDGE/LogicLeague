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
 * Ładowanie Contact Form Handler
 */
require_once get_template_directory() . '/inc/contact-form-handler.php';

/**
 * Debug Styles Helper (add ?debug_styles=1 to URL)
 */
require_once get_template_directory() . '/debug-styles.php';

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

    // Navigation JS - loaded on all pages
    wp_enqueue_script(
        'navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/navigation.js' ),
        true
    );

    // Front Page CSS & JS
    if ( is_front_page() ) {
        wp_enqueue_style(
            'front-page-new',
            get_template_directory_uri() . '/assets/css/front-page-new.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/front-page-new.css' )
        );

        wp_enqueue_script(
            'front-page',
            get_template_directory_uri() . '/assets/js/front-page.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/front-page.js' ),
            true
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

        // Pass quiz player data for AJAX (results saving)
        wp_localize_script('quiz-player', 'quizPlayerData', array(
            'quizId' => get_the_ID(),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('quiz_nonce'),
            'isLoggedIn' => is_user_logged_in(),
        ));
    }

    // Profile Page CSS
    if ( is_page_template('page-profile.php') ) {
        wp_enqueue_style(
            'profile',
            get_template_directory_uri() . '/assets/css/profile.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/profile.css' )
        );
    }

    // Rankings Page CSS
    if ( is_page_template('page-rankings.php') ) {
        wp_enqueue_style(
            'rankings',
            get_template_directory_uri() . '/assets/css/rankings.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/rankings.css' )
        );
    }

    // Legal Pages CSS (Privacy Policy, Terms, Disclaimer, Contact)
    if ( is_page_template('page-privacy-policy.php') ||
         is_page_template('page-terms.php') ||
         is_page_template('page-disclaimer.php') ||
         is_page_template('page-contact.php') ) {
        wp_enqueue_style(
            'legal',
            get_template_directory_uri() . '/assets/css/legal.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/legal.css' )
        );
    }

    // About Us Page CSS & JS - Multiple detection methods
    $is_about_page = false;

    // Method 1: Template detection
    if ( is_page_template('page-about.php') ) {
        $is_about_page = true;
    }

    // Method 2: Slug detection
    if ( is_page(array('about', 'about-us', 'o-nas', 'about-logicleague')) ) {
        $is_about_page = true;
    }

    // Method 3: URL path detection
    if ( isset($_SERVER['REQUEST_URI']) && preg_match('/\/(about|o-nas|about-us)/i', $_SERVER['REQUEST_URI']) ) {
        $is_about_page = true;
    }

    // Method 4: Page title detection
    if ( is_page() ) {
        $page_title = get_the_title();
        if ( stripos($page_title, 'about') !== false || stripos($page_title, 'o nas') !== false ) {
            $is_about_page = true;
        }
    }

    if ( $is_about_page ) {
        wp_enqueue_style(
            'about',
            get_template_directory_uri() . '/assets/css/about.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/about.css' )
        );

        wp_enqueue_script(
            'about',
            get_template_directory_uri() . '/assets/js/about.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/about.js' ),
            true
        );
    }

    // Author Archive CSS
    if ( is_author() ) {
        wp_enqueue_style(
            'author',
            get_template_directory_uri() . '/assets/css/author.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/author.css' )
        );
    }

    // Team Page CSS - Multiple detection methods
    $is_team_page = false;

    // Method 1: Template detection
    if ( is_page_template('page-team.php') ) {
        $is_team_page = true;
    }

    // Method 2: Slug detection
    if ( is_page(array('team', 'our-team', 'zesp', 'zespol', 'the-team')) ) {
        $is_team_page = true;
    }

    // Method 3: URL path detection
    if ( isset($_SERVER['REQUEST_URI']) && preg_match('/\/(team|zespol|zesp)/i', $_SERVER['REQUEST_URI']) ) {
        $is_team_page = true;
    }

    // Method 4: Page title detection
    if ( is_page() ) {
        $page_title = get_the_title();
        if ( stripos($page_title, 'team') !== false || stripos($page_title, 'zespół') !== false || stripos($page_title, 'zespol') !== false ) {
            $is_team_page = true;
        }
    }

    if ( $is_team_page ) {
        wp_enqueue_style(
            'team',
            get_template_directory_uri() . '/assets/css/team.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/team.css' )
        );
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

// Quiz and Question CPTs are registered via ACF

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


/**
 * Quiz Results System
 * Save quiz results to user meta and calculate points
 */

// AJAX handler to save quiz results
function logicleague_save_quiz_result() {
    // Check nonce for security
    check_ajax_referer('quiz_nonce', 'nonce');

    // Get user ID (0 for guests)
    $user_id = get_current_user_id();

    if (!$user_id) {
        wp_send_json_error('User must be logged in to save results');
        return;
    }

    // Get quiz data
    $quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
    $score = isset($_POST['score']) ? intval($_POST['score']) : 0;
    $total_questions = isset($_POST['total_questions']) ? intval($_POST['total_questions']) : 0;
    $time_taken = isset($_POST['time_taken']) ? intval($_POST['time_taken']) : 0; // in seconds

    if (!$quiz_id || !$total_questions) {
        wp_send_json_error('Invalid quiz data');
        return;
    }

    // Calculate points (100 points per correct answer, bonus for speed)
    $base_points = $score * 100;
    $speed_bonus = 0;

    // Speed bonus: max 50 points per question if answered in < 10 seconds
    $avg_time_per_question = $time_taken / $total_questions;
    if ($avg_time_per_question < 10) {
        $speed_bonus = intval(($total_questions * 50) * (1 - ($avg_time_per_question / 10)));
    }

    $total_points = $base_points + $speed_bonus;

    // Create quiz result entry
    $quiz_result = array(
        'quiz_id' => $quiz_id,
        'quiz_title' => get_the_title($quiz_id),
        'score' => $score,
        'total_questions' => $total_questions,
        'percentage' => round(($score / $total_questions) * 100, 2),
        'time_taken' => $time_taken,
        'points_earned' => $total_points,
        'date' => current_time('mysql'),
        'timestamp' => time()
    );

    // Get existing quiz history
    $quiz_history = get_user_meta($user_id, 'quiz_history', true);
    if (!is_array($quiz_history)) {
        $quiz_history = array();
    }

    // Add new result at the beginning of the array
    array_unshift($quiz_history, $quiz_result);

    // Keep only last 50 results
    $quiz_history = array_slice($quiz_history, 0, 50);

    // Save updated history
    update_user_meta($user_id, 'quiz_history', $quiz_history);

    // Update total points
    $current_total_points = get_user_meta($user_id, 'total_points', true);
    $current_total_points = $current_total_points ? intval($current_total_points) : 0;
    $new_total_points = $current_total_points + $total_points;
    update_user_meta($user_id, 'total_points', $new_total_points);

    // Update quizzes completed count
    $quizzes_completed = get_user_meta($user_id, 'quizzes_completed', true);
    $quizzes_completed = $quizzes_completed ? intval($quizzes_completed) : 0;
    update_user_meta($user_id, 'quizzes_completed', $quizzes_completed + 1);

    // Calculate user level based on total points
    $level = logicleague_calculate_user_level($new_total_points);
    update_user_meta($user_id, 'user_level', $level);

    // Return success with updated stats
    wp_send_json_success(array(
        'points_earned' => $total_points,
        'total_points' => $new_total_points,
        'quizzes_completed' => $quizzes_completed + 1,
        'level' => $level,
        'message' => 'Quiz result saved successfully!'
    ));
}
add_action('wp_ajax_save_quiz_result', 'logicleague_save_quiz_result');

// AJAX handler to get user stats
function logicleague_get_user_stats() {
    $user_id = get_current_user_id();

    if (!$user_id) {
        wp_send_json_error('User must be logged in');
        return;
    }

    $total_points = get_user_meta($user_id, 'total_points', true);
    $quizzes_completed = get_user_meta($user_id, 'quizzes_completed', true);
    $user_level = get_user_meta($user_id, 'user_level', true);
    $quiz_history = get_user_meta($user_id, 'quiz_history', true);

    wp_send_json_success(array(
        'total_points' => $total_points ? intval($total_points) : 0,
        'quizzes_completed' => $quizzes_completed ? intval($quizzes_completed) : 0,
        'user_level' => $user_level ? intval($user_level) : 1,
        'quiz_history' => is_array($quiz_history) ? array_slice($quiz_history, 0, 10) : array()
    ));
}
add_action('wp_ajax_get_user_stats', 'logicleague_get_user_stats');

// Calculate user level based on total points
function logicleague_calculate_user_level($total_points) {
    // Level progression: 1000 points per level
    return max(1, floor($total_points / 1000) + 1);
}

// Get user rank among all users
function logicleague_get_user_rank($user_id) {
    global $wpdb;

    $user_points = get_user_meta($user_id, 'total_points', true);
    $user_points = $user_points ? intval($user_points) : 0;

    // Count users with more points
    $rank = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_id) + 1
        FROM {$wpdb->usermeta}
        WHERE meta_key = 'total_points'
        AND CAST(meta_value AS UNSIGNED) > %d",
        $user_points
    ));

    return $rank ? intval($rank) : 1;
}

// Shortcode to display user stats widget
function logicleague_user_stats_widget() {
    if (!is_user_logged_in()) {
        return '<div class="user-stats-widget"><p>Please log in to view your stats.</p></div>';
    }

    $user_id = get_current_user_id();
    $total_points = get_user_meta($user_id, 'total_points', true);
    $quizzes_completed = get_user_meta($user_id, 'quizzes_completed', true);
    $user_level = get_user_meta($user_id, 'user_level', true);
    $user_rank = logicleague_get_user_rank($user_id);

    $total_points = $total_points ? intval($total_points) : 0;
    $quizzes_completed = $quizzes_completed ? intval($quizzes_completed) : 0;
    $user_level = $user_level ? intval($user_level) : 1;

    ob_start();
    ?>
    <div class="user-stats-widget">
        <div class="stat-item">
            <span class="stat-icon">🏆</span>
            <div class="stat-content">
                <strong><?php echo number_format($total_points); ?></strong>
                <span>Total Points</span>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-icon">✅</span>
            <div class="stat-content">
                <strong><?php echo $quizzes_completed; ?></strong>
                <span>Quizzes Completed</span>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-icon">⭐</span>
            <div class="stat-content">
                <strong>Level <?php echo $user_level; ?></strong>
                <span>Current Level</span>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-icon">📊</span>
            <div class="stat-content">
                <strong>#<?php echo $user_rank; ?></strong>
                <span>Global Rank</span>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('user_stats', 'logicleague_user_stats_widget');
