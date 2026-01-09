<?php
/**
 * Sudoku Custom Post Type
 *
 * @package LogicLeague
 */

// Register Sudoku CPT
function logicleague_register_sudoku_cpt() {
    $labels = array(
        'name'                  => 'Sudoku Puzzles',
        'singular_name'         => 'Sudoku',
        'menu_name'             => 'Sudoku',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Sudoku',
        'edit_item'             => 'Edit Sudoku',
        'new_item'              => 'New Sudoku',
        'view_item'             => 'View Sudoku',
        'search_items'          => 'Search Sudoku',
        'not_found'             => 'No sudoku found',
        'not_found_in_trash'    => 'No sudoku found in trash',
        'all_items'             => 'All Sudoku',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'sudoku' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-grid-view',
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'show_in_rest'          => true,
    );

    register_post_type( 'sudoku', $args );
}
add_action( 'init', 'logicleague_register_sudoku_cpt' );

// Add meta boxes
function logicleague_sudoku_meta_boxes() {
    add_meta_box(
        'sudoku_settings',
        'Sudoku Settings',
        'logicleague_sudoku_settings_callback',
        'sudoku',
        'side',
        'high'
    );

    add_meta_box(
        'sudoku_data',
        'Sudoku Data (Auto-generated)',
        'logicleague_sudoku_data_callback',
        'sudoku',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'logicleague_sudoku_meta_boxes' );

// Settings meta box callback
function logicleague_sudoku_settings_callback( $post ) {
    wp_nonce_field( 'sudoku_settings_nonce', 'sudoku_settings_nonce' );

    $difficulty = get_post_meta( $post->ID, '_sudoku_difficulty', true );
    $number = get_post_meta( $post->ID, '_sudoku_number', true );

    if ( empty( $difficulty ) ) {
        $difficulty = 'easy';
    }
    ?>
    <p>
        <label for="sudoku_difficulty"><strong>Difficulty Level:</strong></label><br>
        <select name="sudoku_difficulty" id="sudoku_difficulty" style="width: 100%;">
            <option value="easy" <?php selected( $difficulty, 'easy' ); ?>>Easy</option>
            <option value="medium" <?php selected( $difficulty, 'medium' ); ?>>Medium</option>
            <option value="hard" <?php selected( $difficulty, 'hard' ); ?>>Hard</option>
            <option value="expert" <?php selected( $difficulty, 'expert' ); ?>>Expert</option>
        </select>
    </p>
    <p>
        <label for="sudoku_number"><strong>Sudoku Number:</strong></label><br>
        <input type="text" name="sudoku_number" id="sudoku_number" value="<?php echo esc_attr( $number ); ?>" readonly style="width: 100%; background: #f0f0f0;" />
        <small>Auto-generated on first save</small>
    </p>
    <?php
}

// Data meta box callback
function logicleague_sudoku_data_callback( $post ) {
    $puzzle = get_post_meta( $post->ID, '_sudoku_puzzle', true );
    $solution = get_post_meta( $post->ID, '_sudoku_solution', true );

    if ( $puzzle && $solution ) {
        ?>
        <p><strong>Status:</strong> <span style="color: green;">✓ Sudoku generated</span></p>
        <p><small>Puzzle and solution are stored. They will not change on update.</small></p>
        <details>
            <summary style="cursor: pointer; color: #0073aa;">View Puzzle Data (JSON)</summary>
            <textarea readonly style="width: 100%; height: 100px; margin-top: 10px; font-family: monospace; font-size: 11px;"><?php echo esc_textarea( json_encode( $puzzle, JSON_PRETTY_PRINT ) ); ?></textarea>
        </details>
        <details style="margin-top: 10px;">
            <summary style="cursor: pointer; color: #0073aa;">View Solution Data (JSON)</summary>
            <textarea readonly style="width: 100%; height: 100px; margin-top: 10px; font-family: monospace; font-size: 11px;"><?php echo esc_textarea( json_encode( $solution, JSON_PRETTY_PRINT ) ); ?></textarea>
        </details>
        <?php
    } else {
        ?>
        <p><strong>Status:</strong> <span style="color: orange;">⚠ Not generated yet</span></p>
        <p><small>Sudoku will be automatically generated when you publish/save this post.</small></p>
        <?php
    }
}

// Save meta box data
function logicleague_save_sudoku_meta( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['sudoku_settings_nonce'] ) || ! wp_verify_nonce( $_POST['sudoku_settings_nonce'], 'sudoku_settings_nonce' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save difficulty
    if ( isset( $_POST['sudoku_difficulty'] ) ) {
        update_post_meta( $post_id, '_sudoku_difficulty', sanitize_text_field( $_POST['sudoku_difficulty'] ) );
    }

    // Generate sudoku number if not exists
    $sudoku_number = get_post_meta( $post_id, '_sudoku_number', true );
    if ( empty( $sudoku_number ) ) {
        $sudoku_number = logicleague_get_next_sudoku_number();
        update_post_meta( $post_id, '_sudoku_number', $sudoku_number );
    }

    // Generate puzzle and solution if not exists
    $puzzle = get_post_meta( $post_id, '_sudoku_puzzle', true );
    $solution = get_post_meta( $post_id, '_sudoku_solution', true );

    if ( empty( $puzzle ) || empty( $solution ) ) {
        $difficulty = get_post_meta( $post_id, '_sudoku_difficulty', true );
        if ( empty( $difficulty ) ) {
            $difficulty = 'easy';
        }

        // Generate new sudoku
        require_once get_template_directory() . '/inc/sudoku/class-sudoku-generator.php';
        $game_data = Sudoku_Generator::generate( $difficulty );

        update_post_meta( $post_id, '_sudoku_puzzle', $game_data['puzzle'] );
        update_post_meta( $post_id, '_sudoku_solution', $game_data['solution'] );
        update_post_meta( $post_id, '_sudoku_max_hints', $game_data['max_hints'] );
    }
}
add_action( 'save_post_sudoku', 'logicleague_save_sudoku_meta' );

// Get next sudoku number
function logicleague_get_next_sudoku_number() {
    global $wpdb;

    $max_number = $wpdb->get_var( "
        SELECT MAX(CAST(meta_value AS UNSIGNED))
        FROM {$wpdb->postmeta}
        WHERE meta_key = '_sudoku_number'
    " );

    return $max_number ? intval( $max_number ) + 1 : 1;
}

// Add custom columns to admin list
function logicleague_sudoku_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['sudoku_number'] = 'Number';
    $new_columns['difficulty'] = 'Difficulty';
    $new_columns['generated'] = 'Generated';
    $new_columns['date'] = $columns['date'];

    return $new_columns;
}
add_filter( 'manage_sudoku_posts_columns', 'logicleague_sudoku_columns' );

// Populate custom columns
function logicleague_sudoku_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'sudoku_number':
            $number = get_post_meta( $post_id, '_sudoku_number', true );
            echo $number ? '#' . esc_html( $number ) : '—';
            break;

        case 'difficulty':
            $difficulty = get_post_meta( $post_id, '_sudoku_difficulty', true );
            if ( $difficulty ) {
                $colors = array(
                    'easy'   => '#10b981',
                    'medium' => '#f59e0b',
                    'hard'   => '#ef4444',
                    'expert' => '#8b5cf6'
                );
                $color = isset( $colors[ $difficulty ] ) ? $colors[ $difficulty ] : '#6b7280';
                echo '<span style="background: ' . esc_attr( $color ) . '; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px; font-weight: 600;">' . esc_html( ucfirst( $difficulty ) ) . '</span>';
            } else {
                echo '—';
            }
            break;

        case 'generated':
            $puzzle = get_post_meta( $post_id, '_sudoku_puzzle', true );
            if ( $puzzle ) {
                echo '<span style="color: green;">✓ Yes</span>';
            } else {
                echo '<span style="color: orange;">⚠ No</span>';
            }
            break;
    }
}
add_action( 'manage_sudoku_posts_custom_column', 'logicleague_sudoku_column_content', 10, 2 );

// Make columns sortable
function logicleague_sudoku_sortable_columns( $columns ) {
    $columns['sudoku_number'] = 'sudoku_number';
    $columns['difficulty'] = 'difficulty';
    return $columns;
}
add_filter( 'manage_edit-sudoku_sortable_columns', 'logicleague_sudoku_sortable_columns' );
