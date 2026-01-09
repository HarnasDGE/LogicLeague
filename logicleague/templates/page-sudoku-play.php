<?php
/**
 * Template Name: Sudoku Play
 * Interactive Sudoku game board - Mobile-optimized
 *
 * @package LogicLeague
 */

get_header();

// Get difficulty level from URL
$difficulty = get_query_var( 'sudoku_level' );

// Fallback for old URLs with query parameter
if ( empty( $difficulty ) && isset( $_GET['difficulty'] ) ) {
    $difficulty = sanitize_text_field( $_GET['difficulty'] );
}

// Default to easy
if ( empty( $difficulty ) ) {
    $difficulty = 'easy';
}

$valid_difficulties = ['easy', 'medium', 'hard', 'expert'];
if (!in_array($difficulty, $valid_difficulties)) {
    $difficulty = 'easy';
}

// Get game type (regular/daily)
$game_type = get_query_var( 'sudoku_type' );
if ( empty( $game_type ) ) {
    $game_type = 'regular';
}

// Generate puzzle
$game_data = Sudoku_Generator::generate($difficulty);
$puzzle = $game_data['puzzle'];
$solution = $game_data['solution'];
$max_hints = $game_data['max_hints'];

// Difficulty names
$difficulty_names = [
    'easy' => 'Easy',
    'medium' => 'Medium',
    'hard' => 'Hard',
    'expert' => 'Expert'
];

// Title based on game type
$page_title = $game_type === 'daily'
    ? 'Daily Sudoku - ' . $difficulty_names[$difficulty]
    : 'Sudoku - ' . $difficulty_names[$difficulty];
?>

<div class="sudoku-play-page">
    <!-- Compact Header -->
    <div class="sudoku-header-compact">
        <a href="<?php echo home_url('/sudoku'); ?>" class="sudoku-back-btn" aria-label="Back">
            ← Back
        </a>
        <h1 class="sudoku-title-compact"><?php echo $page_title; ?></h1>
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
                    <span id="hints-used">0</span>/<?php echo $max_hints; ?>
                </span>
            </div>
        </div>

        <!-- Sudoku Board -->
        <div class="sudoku-board-wrapper">
            <div class="sudoku-board" id="sudoku-board"
                 data-difficulty="<?php echo esc_attr($difficulty); ?>"
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

    <!-- Content Below Game (Scrollable) -->
    <div class="sudoku-secondary-content">

        <!-- How to Play Section -->
        <section class="sudoku-instructions">
            <h2>How to Play</h2>
            <div class="instructions-grid">
                <div class="instruction-item">
                    <span class="instruction-icon">🎯</span>
                    <p>Fill each row, column, and 3×3 box with numbers 1-9</p>
                </div>
                <div class="instruction-item">
                    <span class="instruction-icon">📝</span>
                    <p>Use <strong>Notes Mode</strong> (✏️) for pencil marks</p>
                </div>
                <div class="instruction-item">
                    <span class="instruction-icon">⌨️</span>
                    <p>Use keyboard: 1-9 for numbers, arrow keys to navigate</p>
                </div>
                <div class="instruction-item">
                    <span class="instruction-icon">💡</span>
                    <p>Need help? Use hints, but they're limited!</p>
                </div>
            </div>
        </section>

        <!-- Leaderboard Preview -->
        <section class="sudoku-leaderboard-preview">
            <h2>Today's Leaderboard</h2>
            <div class="leaderboard-placeholder">
                <p>Complete this puzzle to see your rank!</p>
                <a href="<?php echo home_url('/sudoku/leaderboard'); ?>" class="view-leaderboard-btn">
                    View Full Leaderboard →
                </a>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="sudoku-stats-section">
            <h2>Your Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Games Played</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">0%</div>
                    <div class="stat-label">Win Rate</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">--:--</div>
                    <div class="stat-label">Best Time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">--:--</div>
                    <div class="stat-label">Avg Time</div>
                </div>
            </div>
        </section>
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
                <span class="completion-label">Level:</span>
                <span class="completion-value"><?php echo $difficulty_names[$difficulty]; ?></span>
            </div>
        </div>

        <div class="completion-buttons">
            <a href="<?php echo home_url('/sudoku/' . ( $game_type === 'daily' ? 'daily/' : '' ) . $difficulty); ?>"
               class="completion-btn completion-btn-primary">
                Play Again
            </a>
            <a href="<?php echo home_url('/sudoku'); ?>"
               class="completion-btn completion-btn-secondary">
                Choose Level
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
            <div class="completion-stat">
                <span class="completion-label">Level:</span>
                <span class="completion-value"><?php echo $difficulty_names[$difficulty]; ?></span>
            </div>
        </div>

        <div class="completion-buttons">
            <button onclick="location.reload()" class="completion-btn completion-btn-primary">
                Try Again
            </button>
            <a href="<?php echo home_url('/sudoku'); ?>"
               class="completion-btn completion-btn-secondary">
                Choose Level
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
