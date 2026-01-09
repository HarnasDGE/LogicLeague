<?php
/**
 * Sudoku Leaderboard System
 *
 * @package LogicLeague
 */

// Create database table for leaderboard
function logicleague_create_sudoku_leaderboard_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'sudoku_leaderboard';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        sudoku_id bigint(20) NOT NULL,
        user_id bigint(20) DEFAULT NULL,
        user_name varchar(255) DEFAULT NULL,
        time_seconds int(11) NOT NULL,
        mistakes int(11) NOT NULL DEFAULT 0,
        hints_used int(11) NOT NULL DEFAULT 0,
        completed_at datetime NOT NULL,
        PRIMARY KEY  (id),
        KEY sudoku_id (sudoku_id),
        KEY user_id (user_id),
        KEY time_seconds (time_seconds)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Create table on theme activation
add_action( 'after_switch_theme', 'logicleague_create_sudoku_leaderboard_table' );

// AJAX: Save sudoku result
function logicleague_save_sudoku_result() {
    global $wpdb;

    // Verify nonce
    if ( ! check_ajax_referer( 'sudoku_result', 'nonce', false ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed' ) );
    }

    $sudoku_id = isset( $_POST['sudoku_id'] ) ? intval( $_POST['sudoku_id'] ) : 0;
    $time_seconds = isset( $_POST['time_seconds'] ) ? intval( $_POST['time_seconds'] ) : 0;
    $mistakes = isset( $_POST['mistakes'] ) ? intval( $_POST['mistakes'] ) : 0;
    $hints_used = isset( $_POST['hints_used'] ) ? intval( $_POST['hints_used'] ) : 0;

    if ( ! $sudoku_id || ! $time_seconds ) {
        wp_send_json_error( array( 'message' => 'Missing required data' ) );
    }

    // Check if sudoku post exists
    if ( get_post_type( $sudoku_id ) !== 'sudoku' ) {
        wp_send_json_error( array( 'message' => 'Invalid sudoku' ) );
    }

    $table_name = $wpdb->prefix . 'sudoku_leaderboard';
    $user_id = get_current_user_id();
    $user_name = null;

    if ( $user_id ) {
        $user = wp_get_current_user();
        $user_name = $user->display_name;
    }

    // Insert result
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'sudoku_id'     => $sudoku_id,
            'user_id'       => $user_id ? $user_id : null,
            'user_name'     => $user_name,
            'time_seconds'  => $time_seconds,
            'mistakes'      => $mistakes,
            'hints_used'    => $hints_used,
            'completed_at'  => current_time( 'mysql' ),
        ),
        array( '%d', '%d', '%s', '%d', '%d', '%d', '%s' )
    );

    if ( $inserted ) {
        // Get user's best time for this sudoku
        $best_time = $wpdb->get_var( $wpdb->prepare(
            "SELECT MIN(time_seconds) FROM $table_name WHERE sudoku_id = %d AND user_id = %d",
            $sudoku_id,
            $user_id
        ) );

        // Get user's rank
        $rank = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(DISTINCT user_id) + 1
            FROM $table_name
            WHERE sudoku_id = %d
            AND time_seconds < %d",
            $sudoku_id,
            $time_seconds
        ) );

        wp_send_json_success( array(
            'message'    => 'Result saved!',
            'best_time'  => $best_time,
            'rank'       => $rank,
            'is_logged_in' => (bool) $user_id,
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to save result' ) );
    }
}
add_action( 'wp_ajax_save_sudoku_result', 'logicleague_save_sudoku_result' );
add_action( 'wp_ajax_nopriv_save_sudoku_result', 'logicleague_save_sudoku_result' );

// Get leaderboard for sudoku
function logicleague_get_sudoku_leaderboard( $sudoku_id, $limit = 10 ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'sudoku_leaderboard';

    // Get best time for each user
    $results = $wpdb->get_results( $wpdb->prepare(
        "SELECT
            MIN(lb.time_seconds) as best_time,
            lb.user_id,
            lb.user_name,
            MIN(lb.mistakes) as best_mistakes,
            MIN(lb.hints_used) as best_hints,
            MAX(lb.completed_at) as last_completed
        FROM $table_name lb
        WHERE lb.sudoku_id = %d
        GROUP BY lb.user_id
        ORDER BY best_time ASC
        LIMIT %d",
        $sudoku_id,
        $limit
    ), ARRAY_A );

    return $results;
}

// Get user's stats for sudoku
function logicleague_get_user_sudoku_stats( $sudoku_id, $user_id ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'sudoku_leaderboard';

    $stats = $wpdb->get_row( $wpdb->prepare(
        "SELECT
            COUNT(*) as attempts,
            MIN(time_seconds) as best_time,
            AVG(time_seconds) as avg_time,
            MIN(mistakes) as best_mistakes
        FROM $table_name
        WHERE sudoku_id = %d AND user_id = %d",
        $sudoku_id,
        $user_id
    ), ARRAY_A );

    return $stats;
}

// Format time (seconds to MM:SS)
function logicleague_format_time( $seconds ) {
    $minutes = floor( $seconds / 60 );
    $secs = $seconds % 60;
    return sprintf( '%02d:%02d', $minutes, $secs );
}
