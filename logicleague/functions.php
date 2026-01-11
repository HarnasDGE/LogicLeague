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

    // Global styles - header, navigation, footer (loaded on all pages)
    wp_enqueue_style(
        'global-styles',
        get_template_directory_uri() . '/assets/css/global.css',
        array(),
        filemtime( get_template_directory() . '/assets/css/global.css' )
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

        wp_enqueue_style(
            'quiz-grid',
            get_template_directory_uri() . '/assets/css/quiz-grid.css',
            array(),
            filemtime( get_template_directory() . '/assets/css/quiz-grid.css' )
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

        // Auth JS for login/register modals
        wp_enqueue_script(
            'auth',
            get_template_directory_uri() . '/assets/js/auth.js',
            array(),
            filemtime( get_template_directory() . '/assets/js/auth.js' ),
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

        // Pass auth data for login/register
        wp_localize_script('auth', 'authData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('auth_nonce'),
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
}
add_action( 'wp_enqueue_scripts', 'logicleague_enqueue_scripts' );

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
 * Create database table for quiz leaderboards on activation
 */
function logicleague_create_quiz_leaderboard_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz_leaderboard';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        quiz_id bigint(20) NOT NULL,
        user_id bigint(20) NOT NULL,
        score int(11) NOT NULL,
        total_questions int(11) NOT NULL,
        percentage decimal(5,2) NOT NULL,
        time_taken int(11) NOT NULL,
        points_earned int(11) NOT NULL DEFAULT 0,
        completed_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY quiz_id (quiz_id),
        KEY user_id (user_id),
        KEY score (score),
        KEY percentage (percentage)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    // Store database version
    update_option( 'logicleague_db_version', '1.0' );
}

// Check and create table if needed
function logicleague_check_database() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz_leaderboard';

    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;

    if (!$table_exists) {
        logicleague_create_quiz_leaderboard_table();
    }
}

// Run on theme activation
add_action( 'after_switch_theme', 'logicleague_create_quiz_leaderboard_table' );

// Also check on admin init (will create table if it doesn't exist)
add_action( 'admin_init', 'logicleague_check_database' );

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

    // Save to quiz leaderboard table
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz_leaderboard';

    // Check if table exists, if not create it
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
    if (!$table_exists) {
        logicleague_create_quiz_leaderboard_table();
    }

    $insert_result = $wpdb->insert(
        $table_name,
        array(
            'quiz_id' => $quiz_id,
            'user_id' => $user_id,
            'score' => $score,
            'total_questions' => $total_questions,
            'percentage' => $quiz_result['percentage'],
            'time_taken' => $time_taken,
            'points_earned' => $total_points,
            'completed_at' => current_time('mysql')
        ),
        array('%d', '%d', '%d', '%d', '%f', '%d', '%d', '%s')
    );

    // Log error if insert failed
    if ($insert_result === false) {
        error_log('LogicLeague: Failed to insert quiz result to leaderboard. Error: ' . $wpdb->last_error);
    }

    // Get user's rank for this quiz (based on score, then time as tiebreaker)
    $quiz_rank = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_id) + 1
        FROM (
            SELECT user_id, MAX(score) as best_score, MIN(time_taken) as best_time
            FROM $table_name
            WHERE quiz_id = %d
            GROUP BY user_id
        ) as best_scores
        WHERE best_score > %d OR (best_score = %d AND best_time < %d)",
        $quiz_id,
        $score,
        $score,
        $time_taken
    ));

    // Get global rank
    $global_rank = logicleague_get_user_rank($user_id);

    // Get total players for this quiz
    $total_players = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_id) FROM $table_name WHERE quiz_id = %d",
        $quiz_id
    ));

    // Return success with updated stats
    wp_send_json_success(array(
        'points_earned' => $total_points,
        'total_points' => $new_total_points,
        'quizzes_completed' => $quizzes_completed + 1,
        'level' => $level,
        'quiz_rank' => $quiz_rank,
        'total_players' => $total_players,
        'global_rank' => $global_rank,
        'score' => $score,
        'percentage' => $quiz_result['percentage'],
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

/**
 * AJAX Handler for Login
 */
function logicleague_ajax_login() {
    check_ajax_referer('auth_nonce', 'nonce');

    $email = sanitize_email($_POST['user_email']);
    $password = $_POST['user_password'];
    $remember = isset($_POST['remember_me']);

    if (empty($email) || empty($password)) {
        wp_send_json_error('Please fill in all fields.');
        return;
    }

    // Get user by email
    $user = get_user_by('email', $email);

    if (!$user) {
        wp_send_json_error('Invalid email or password.');
        return;
    }

    // Check password
    $creds = array(
        'user_login'    => $user->user_login,
        'user_password' => $password,
        'remember'      => $remember
    );

    $user_signon = wp_signon($creds, is_ssl());

    if (is_wp_error($user_signon)) {
        wp_send_json_error('Invalid email or password.');
    } else {
        wp_send_json_success('Login successful!');
    }
}
add_action('wp_ajax_nopriv_logicleague_login', 'logicleague_ajax_login');
add_action('wp_ajax_logicleague_login', 'logicleague_ajax_login');

/**
 * AJAX Handler for Registration
 */
function logicleague_ajax_register() {
    check_ajax_referer('auth_nonce', 'nonce');

    $username = sanitize_user($_POST['user_login']);
    $email = sanitize_email($_POST['user_email']);
    $password = $_POST['user_password'];

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        wp_send_json_error('Please fill in all fields.');
        return;
    }

    if (!is_email($email)) {
        wp_send_json_error('Please enter a valid email address.');
        return;
    }

    if (strlen($password) < 8) {
        wp_send_json_error('Password must be at least 8 characters long.');
        return;
    }

    if (username_exists($username)) {
        wp_send_json_error('Username already exists. Please choose another one.');
        return;
    }

    if (email_exists($email)) {
        wp_send_json_error('Email already registered. Please login or use another email.');
        return;
    }

    // Create user
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error($user_id->get_error_message());
        return;
    }

    // Initialize user meta
    update_user_meta($user_id, 'total_points', 0);
    update_user_meta($user_id, 'quizzes_completed', 0);
    update_user_meta($user_id, 'user_level', 1);

    // Auto login after registration
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user)) {
        wp_send_json_success('Account created! Please login.');
    } else {
        wp_send_json_success('Account created and logged in!');
    }
}
add_action('wp_ajax_nopriv_logicleague_register', 'logicleague_ajax_register');
add_action('wp_ajax_logicleague_register', 'logicleague_ajax_register');
