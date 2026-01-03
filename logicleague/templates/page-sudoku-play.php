<?php
/**
 * Template Name: Sudoku Play
 * Interaktywna plansza do gry w Sudoku
 *
 * @package LogicLeague
 */

get_header();

// Pobierz poziom trudności z URL
$difficulty = get_query_var( 'sudoku_level' );

// Fallback dla starych URLi z query parameter
if ( empty( $difficulty ) && isset( $_GET['difficulty'] ) ) {
    $difficulty = sanitize_text_field( $_GET['difficulty'] );
}

// Domyślnie easy
if ( empty( $difficulty ) ) {
    $difficulty = 'easy';
}

$valid_difficulties = ['easy', 'medium', 'hard', 'expert'];
if (!in_array($difficulty, $valid_difficulties)) {
    $difficulty = 'easy';
}

// Pobierz typ gry (regular/daily)
$game_type = get_query_var( 'sudoku_type' );
if ( empty( $game_type ) ) {
    $game_type = 'regular';
}

// Generuj puzzle
$game_data = Sudoku_Generator::generate($difficulty);
$puzzle = $game_data['puzzle'];
$solution = $game_data['solution'];
$max_hints = $game_data['max_hints'];

// Mapa trudności na polskie nazwy
$difficulty_names = [
    'easy' => 'Łatwy',
    'medium' => 'Średni',
    'hard' => 'Trudny',
    'expert' => 'Ekspert'
];

// Tytuł w zależności od typu gry
$page_title = $game_type === 'daily'
    ? 'Daily Sudoku - ' . $difficulty_names[$difficulty]
    : 'Sudoku - ' . $difficulty_names[$difficulty];
?>

<div class="sudoku-play-container">
    <div class="sudoku-play-header">
        <a href="<?php echo home_url('/sudoku'); ?>" class="sudoku-back-button">
            ← Powrót do wyboru trudności
        </a>
        <h1 class="sudoku-play-title">
            <?php echo $page_title; ?>
        </h1>
    </div>

    <div class="sudoku-game-wrapper">
        <!-- Lewa kolumna: Plansza -->
        <div class="sudoku-board-section">
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

                        // Dodaj klasy dla grubszych granic (co 3 komórki)
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
                        </div>
                    <?php endfor; ?>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Prawa kolumna: Kontrolki -->
        <div class="sudoku-controls-section">
            <!-- Statystyki gry -->
            <div class="sudoku-game-stats">
                <div class="sudoku-stat">
                    <div class="sudoku-stat-icon">⏱️</div>
                    <div class="sudoku-stat-label">Czas</div>
                    <div class="sudoku-stat-value" id="timer">00:00</div>
                </div>
                <div class="sudoku-stat">
                    <div class="sudoku-stat-icon">❌</div>
                    <div class="sudoku-stat-label">Błędy</div>
                    <div class="sudoku-stat-value" id="mistakes">0</div>
                </div>
                <div class="sudoku-stat">
                    <div class="sudoku-stat-icon">💡</div>
                    <div class="sudoku-stat-label">Podpowiedzi</div>
                    <div class="sudoku-stat-value" id="hints">
                        <span id="hints-used">0</span> / <?php echo $max_hints; ?>
                    </div>
                </div>
            </div>

            <!-- Przyciski numeryczne -->
            <div class="sudoku-number-pad">
                <div class="sudoku-number-pad-label">Wybierz liczbę:</div>
                <div class="sudoku-number-buttons">
                    <?php for ($num = 1; $num <= 9; $num++): ?>
                        <button class="sudoku-number-button" data-number="<?php echo $num; ?>">
                            <?php echo $num; ?>
                        </button>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Przyciski akcji -->
            <div class="sudoku-action-buttons">
                <button class="sudoku-action-button sudoku-hint-button" id="hint-button">
                    💡 Podpowiedź
                </button>
                <button class="sudoku-action-button sudoku-clear-button" id="clear-button">
                    🗑️ Wyczyść
                </button>
                <button class="sudoku-action-button sudoku-check-button" id="check-button">
                    ✓ Sprawdź
                </button>
            </div>

            <!-- Przyciski gry -->
            <div class="sudoku-game-buttons">
                <button class="sudoku-game-button sudoku-new-game-button" id="new-game-button">
                    🔄 Nowa gra
                </button>
                <button class="sudoku-game-button sudoku-solve-button" id="solve-button">
                    🎯 Pokaż rozwiązanie
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal ukończenia gry -->
<div class="sudoku-completion-modal" id="completion-modal">
    <div class="sudoku-completion-content">
        <div class="sudoku-completion-emoji">🎉</div>
        <h2 class="sudoku-completion-title">Gratulacje!</h2>
        <p class="sudoku-completion-message">Ukończyłeś puzzle Sudoku!</p>

        <div class="sudoku-completion-stats">
            <div class="sudoku-completion-stat">
                <span class="sudoku-completion-stat-label">Czas:</span>
                <span class="sudoku-completion-stat-value" id="final-time">00:00</span>
            </div>
            <div class="sudoku-completion-stat">
                <span class="sudoku-completion-stat-label">Błędy:</span>
                <span class="sudoku-completion-stat-value" id="final-mistakes">0</span>
            </div>
            <div class="sudoku-completion-stat">
                <span class="sudoku-completion-stat-label">Poziom:</span>
                <span class="sudoku-completion-stat-value"><?php echo $difficulty_names[$difficulty]; ?></span>
            </div>
        </div>

        <div class="sudoku-completion-buttons">
            <a href="<?php echo home_url('/sudoku/' . ( $game_type === 'daily' ? 'daily/' : '' ) . $difficulty); ?>"
               class="sudoku-completion-button sudoku-completion-button-primary">
                Zagraj ponownie
            </a>
            <a href="<?php echo home_url('/sudoku'); ?>"
               class="sudoku-completion-button sudoku-completion-button-secondary">
                Wybierz poziom
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
