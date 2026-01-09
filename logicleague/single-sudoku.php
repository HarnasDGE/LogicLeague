<?php
/**
 * Single Sudoku Template
 *
 * @package LogicLeague
 */

get_header();

// Get sudoku data
$sudoku_id = get_the_ID();
$puzzle = get_post_meta( $sudoku_id, '_sudoku_puzzle', true );
$solution = get_post_meta( $sudoku_id, '_sudoku_solution', true );
$max_hints = get_post_meta( $sudoku_id, '_sudoku_max_hints', true );
$difficulty = get_post_meta( $sudoku_id, '_sudoku_difficulty', true );
$sudoku_number = get_post_meta( $sudoku_id, '_sudoku_number', true );

// Difficulty names
$difficulty_names = array(
    'easy' => 'Easy',
    'medium' => 'Medium',
    'hard' => 'Hard',
    'expert' => 'Expert'
);

$difficulty_display = isset( $difficulty_names[ $difficulty ] ) ? $difficulty_names[ $difficulty ] : 'Easy';

// Page title
$page_title = 'Sudoku #' . $sudoku_number . ' - ' . $difficulty_display;

// Check if puzzle exists
if ( ! $puzzle || ! $solution ) {
    echo '<div class="container"><p>Sudoku puzzle not generated yet. Please contact administrator.</p></div>';
    get_footer();
    exit;
}
?>

<div class="sudoku-play-page">
    <!-- Compact Header -->
    <div class="sudoku-header-compact">
        <a href="<?php echo home_url('/sudoku'); ?>" class="sudoku-back-btn" aria-label="Back">
            ← Back
        </a>
        <h1 class="sudoku-title-compact"><?php echo esc_html( $page_title ); ?></h1>
    </div>

    <!-- Ad Space (Above Game) -->
    <div class="sudoku-ad-container">
        <div class="ad-placeholder">
            <!-- Google AdSense: Horizontal Banner (728x90 or 320x50 mobile) -->
            <div class="ad-label">Advertisement</div>
            <div class="ad-content" style="min-height: 50px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 12px;">
                Ad Space 728x90 / 320x50
            </div>
        </div>
    </div>

    <div class="sudoku-single-layout">
        <!-- Main Content: Game -->
        <div class="sudoku-game-section">
            <!-- Game Container (No Scroll Zone) -->
            <div class="sudoku-game-container">

                <!-- Stats Bar (Inline, Compact) -->
                <div class="sudoku-stats-bar">
                    <div class="stat-item">
                        <span class="stat-icon">⏱️</span>
                        <span class="stat-value" id="timer">00:00</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">❌</span>
                        <span class="stat-value" id="mistakes">0/3</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">💡</span>
                        <span class="stat-value" id="hints">
                            <span id="hints-used">0</span>/<?php echo esc_html( $max_hints ); ?>
                        </span>
                    </div>
                </div>

                <!-- Sudoku Board -->
                <div class="sudoku-board-wrapper">
                    <div class="sudoku-board" id="sudoku-board"
                         data-sudoku-id="<?php echo esc_attr( $sudoku_id ); ?>"
                         data-difficulty="<?php echo esc_attr( $difficulty ); ?>"
                         data-solution="<?php echo esc_attr(json_encode($solution)); ?>">
                        <?php for ($row = 0; $row < 9; $row++): ?>
                            <?php for ($col = 0; $col < 9; $col++): ?>
                                <?php
                                $value = $puzzle[$row][$col];
                                $is_initial = $value !== 0;
                                $cell_classes = ['sudoku-cell'];

                                if ($is_initial) {
                                    $cell_classes[] = 'sudoku-cell-initial';
                                }

                                // Add classes for thicker borders (every 3 cells)
                                if ($col % 3 === 2 && $col !== 8) {
                                    $cell_classes[] = 'sudoku-cell-border-right';
                                }
                                if ($row % 3 === 2 && $row !== 8) {
                                    $cell_classes[] = 'sudoku-cell-border-bottom';
                                }
                                ?>
                                <div class="<?php echo implode(' ', $cell_classes); ?>"
                                     data-row="<?php echo $row; ?>"
                                     data-col="<?php echo $col; ?>"
                                     data-initial="<?php echo $is_initial ? '1' : '0'; ?>"
                                     data-value="<?php echo $value; ?>">
                                    <?php if ($value !== 0): ?>
                                        <span class="sudoku-cell-value"><?php echo $value; ?></span>
                                    <?php endif; ?>
                                    <div class="sudoku-cell-notes"></div>
                                </div>
                            <?php endfor; ?>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Compact Controls -->
                <div class="sudoku-controls-compact">

                    <!-- Action Buttons (Icons Only) -->
                    <div class="action-buttons-row">
                        <button class="action-btn" id="undo-button" disabled title="Undo" aria-label="Undo">
                            <span class="btn-icon">↶</span>
                        </button>
                        <button class="action-btn" id="redo-button" disabled title="Redo" aria-label="Redo">
                            <span class="btn-icon">↷</span>
                        </button>
                        <button class="action-btn" id="pencil-button" title="Notes Mode" aria-label="Toggle notes">
                            <span class="btn-icon" id="pencil-icon">✏️</span>
                        </button>
                        <button class="action-btn" id="hint-button" title="Hint" aria-label="Get hint">
                            <span class="btn-icon">💡</span>
                        </button>
                        <button class="action-btn" id="clear-button" title="Clear Cell" aria-label="Clear selected cell">
                            <span class="btn-icon">🗑️</span>
                        </button>
                        <button class="action-btn" id="new-game-button" title="New Game" aria-label="New game">
                            <span class="btn-icon">🔄</span>
                        </button>
                    </div>

                    <!-- Number Pad (Compact Grid) -->
                    <div class="number-pad-compact">
                        <?php for ($num = 1; $num <= 9; $num++): ?>
                            <button class="number-btn" data-number="<?php echo $num; ?>" aria-label="Number <?php echo $num; ?>">
                                <?php echo $num; ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Post Content Below Game -->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php if ( get_the_content() ) : ?>
                    <div class="sudoku-post-content">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; endif; ?>
        </div>

        <!-- Sidebar: Leaderboard -->
        <aside class="sudoku-sidebar">
            <div class="sudoku-sidebar-sticky">
                <div class="sudoku-info-card">
                    <h3 class="card-title">Puzzle Info</h3>
                    <div class="info-items">
                        <div class="info-item">
                            <span class="info-label">Number:</span>
                            <span class="info-value">#<?php echo esc_html( $sudoku_number ); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Difficulty:</span>
                            <span class="info-value difficulty-<?php echo esc_attr( $difficulty ); ?>">
                                <?php echo esc_html( $difficulty_display ); ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Max Hints:</span>
                            <span class="info-value"><?php echo esc_html( $max_hints ); ?></span>
                        </div>
                    </div>
                </div>

                <div class="sudoku-leaderboard-card">
                    <h3 class="card-title">🏆 Leaderboard</h3>
                    <?php
                    $leaderboard = logicleague_get_sudoku_leaderboard( $sudoku_id, 10 );
                    if ( $leaderboard ) :
                    ?>
                        <div class="leaderboard-list">
                            <?php foreach ( $leaderboard as $index => $entry ) : ?>
                                <?php
                                $rank = $index + 1;
                                $rank_class = '';
                                if ( $rank === 1 ) $rank_class = 'rank-gold';
                                elseif ( $rank === 2 ) $rank_class = 'rank-silver';
                                elseif ( $rank === 3 ) $rank_class = 'rank-bronze';

                                $is_current_user = ( $entry['user_id'] && get_current_user_id() == $entry['user_id'] );
                                ?>
                                <div class="leaderboard-entry <?php echo $is_current_user ? 'current-user' : ''; ?>">
                                    <span class="entry-rank <?php echo $rank_class; ?>"><?php echo $rank; ?></span>
                                    <div class="entry-info">
                                        <span class="entry-name">
                                            <?php echo esc_html( $entry['user_name'] ? $entry['user_name'] : 'Anonymous' ); ?>
                                            <?php if ( $is_current_user ) : ?>
                                                <span class="you-badge">YOU</span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="entry-time"><?php echo esc_html( logicleague_format_time( $entry['best_time'] ) ); ?></span>
                                    </div>
                                    <div class="entry-stats">
                                        <?php if ( $entry['best_mistakes'] > 0 ) : ?>
                                            <span class="stat-badge">❌ <?php echo $entry['best_mistakes']; ?></span>
                                        <?php endif; ?>
                                        <?php if ( $entry['best_hints'] > 0 ) : ?>
                                            <span class="stat-badge">💡 <?php echo $entry['best_hints']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="no-results">No results yet. Be the first to complete this puzzle!</p>
                    <?php endif; ?>
                </div>

                <?php if ( is_user_logged_in() ) : ?>
                    <?php
                    $user_stats = logicleague_get_user_sudoku_stats( $sudoku_id, get_current_user_id() );
                    if ( $user_stats && $user_stats['attempts'] > 0 ) :
                    ?>
                        <div class="sudoku-stats-card">
                            <h3 class="card-title">📊 Your Stats</h3>
                            <div class="user-stats-grid">
                                <div class="stat-box">
                                    <div class="stat-number"><?php echo esc_html( $user_stats['attempts'] ); ?></div>
                                    <div class="stat-label">Attempts</div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-number"><?php echo esc_html( logicleague_format_time( $user_stats['best_time'] ) ); ?></div>
                                    <div class="stat-label">Best Time</div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<!-- Completion Modal -->
<div class="sudoku-completion-modal" id="completion-modal">
    <div class="sudoku-completion-content">
        <div class="completion-emoji">🎉</div>
        <h2 class="completion-title">Congratulations!</h2>
        <p class="completion-message">You completed the puzzle!</p>

        <div class="completion-stats">
            <div class="completion-stat">
                <span class="completion-label">Time:</span>
                <span class="completion-value" id="final-time">00:00</span>
            </div>
            <div class="completion-stat">
                <span class="completion-label">Mistakes:</span>
                <span class="completion-value" id="final-mistakes">0</span>
            </div>
            <div class="completion-stat">
                <span class="completion-label">Hints Used:</span>
                <span class="completion-value" id="final-hints">0</span>
            </div>
        </div>

        <div id="completion-result-message" class="result-message"></div>

        <div class="completion-buttons">
            <button id="try-again-completion" class="completion-btn completion-btn-primary">
                Try Again
            </button>
            <a href="<?php echo home_url('/sudoku'); ?>" class="completion-btn completion-btn-secondary">
                More Puzzles
            </a>
        </div>
    </div>
</div>

<!-- Game Over Modal -->
<div class="sudoku-completion-modal" id="gameover-modal">
    <div class="sudoku-completion-content">
        <div class="completion-emoji">😔</div>
        <h2 class="completion-title">Game Over</h2>
        <p class="completion-message">You've reached the maximum of 3 mistakes.</p>

        <div class="completion-stats">
            <div class="completion-stat">
                <span class="completion-label">Time:</span>
                <span class="completion-value" id="gameover-time">00:00</span>
            </div>
            <div class="completion-stat">
                <span class="completion-label">Mistakes:</span>
                <span class="completion-value">3</span>
            </div>
        </div>

        <div class="completion-buttons">
            <button id="try-again-button" class="completion-btn completion-btn-primary">
                Try Again
            </button>
            <a href="<?php echo home_url('/sudoku'); ?>" class="completion-btn completion-btn-secondary">
                Choose Another
            </a>
        </div>
    </div>
</div>

<!-- Guest Registration Modal -->
<?php if ( ! is_user_logged_in() ) : ?>
<div class="sudoku-completion-modal" id="guest-register-modal">
    <div class="sudoku-completion-content">
        <div class="completion-emoji">👤</div>
        <h2 class="completion-title">Save Your Result!</h2>
        <p class="completion-message">Create an account to save your time to the leaderboard and track your progress.</p>

        <div class="completion-stats">
            <div class="completion-stat">
                <span class="completion-label">Your Time:</span>
                <span class="completion-value" id="guest-final-time">00:00</span>
            </div>
        </div>

        <div class="completion-buttons">
            <a href="<?php echo wp_login_url( get_permalink() ); ?>" class="completion-btn completion-btn-primary">
                Sign Up / Login
            </a>
            <button id="skip-register" class="completion-btn completion-btn-secondary">
                Continue as Guest
            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// Pass PHP data to JavaScript
window.sudokuData = {
    sudokuId: <?php echo json_encode( $sudoku_id ); ?>,
    ajaxUrl: <?php echo json_encode( admin_url( 'admin-ajax.php' ) ); ?>,
    nonce: <?php echo json_encode( wp_create_nonce( 'sudoku_result' ) ); ?>,
    isLoggedIn: <?php echo json_encode( is_user_logged_in() ); ?>
};
</script>

<?php get_footer(); ?>
