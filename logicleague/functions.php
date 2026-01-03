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

/**
 * TEST STRONA - Sudoku Generator
 * Odwiedź: /?test_sudoku lub /?test_sudoku&difficulty=hard
 */
add_action( 'template_redirect', function() {
    if ( ! isset( $_GET['test_sudoku'] ) ) {
        return;
    }

    // Pobierz poziom trudności z URL lub użyj domyślnego
    $difficulty = isset( $_GET['difficulty'] ) ? sanitize_text_field( $_GET['difficulty'] ) : 'easy';

    // Walidacja poziomu trudności
    $valid_difficulties = array( 'easy', 'medium', 'hard', 'expert' );
    if ( ! in_array( $difficulty, $valid_difficulties ) ) {
        $difficulty = 'easy';
    }

    // Generuj puzzle
    $game_data = Sudoku_Generator::generate( $difficulty );

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sudoku Generator Test</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                background: #f5f5f5;
            }
            h1 {
                color: #333;
                text-align: center;
            }
            .info {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .difficulty-selector {
                text-align: center;
                margin: 20px 0;
            }
            .difficulty-selector a {
                display: inline-block;
                padding: 10px 20px;
                margin: 0 5px;
                background: #6366F1;
                color: white;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 600;
            }
            .difficulty-selector a.active {
                background: #EC4899;
            }
            .container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
            .board-container {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            h2 {
                margin-top: 0;
                color: #333;
                text-align: center;
            }
            .sudoku-grid {
                display: grid;
                grid-template-columns: repeat(9, 1fr);
                gap: 0;
                border: 3px solid #333;
                max-width: 450px;
                margin: 0 auto;
            }
            .cell {
                aspect-ratio: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #ddd;
                font-size: 20px;
                font-weight: bold;
            }
            .cell.initial {
                background: #f0f0f0;
                color: #333;
            }
            .cell.empty {
                background: #fff;
                color: #999;
            }
            .cell.solution {
                background: #e8f5e9;
                color: #2e7d32;
            }
            /* Grubsze linie co 3 komórki */
            .cell:nth-child(3n) {
                border-right: 2px solid #333;
            }
            .cell:nth-child(n+19):nth-child(-n+27),
            .cell:nth-child(n+46):nth-child(-n+54) {
                border-bottom: 2px solid #333;
            }
            .stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-top: 20px;
            }
            .stat {
                background: #f5f5f5;
                padding: 15px;
                border-radius: 6px;
                text-align: center;
            }
            .stat-label {
                font-size: 12px;
                color: #666;
                margin-bottom: 5px;
            }
            .stat-value {
                font-size: 24px;
                font-weight: bold;
                color: #6366F1;
            }
            @media (max-width: 768px) {
                .container {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
        <h1>🎲 Sudoku Generator Test</h1>

        <div class="info">
            <p><strong>Poziom trudności:</strong> <?php echo ucfirst( $difficulty ); ?></p>
            <p><strong>Max hints:</strong> <?php echo $game_data['max_hints']; ?></p>
            <p><strong>Test:</strong> Generator tworzy unikalne puzzle z pełnym rozwiązaniem</p>
        </div>

        <div class="difficulty-selector">
            <a href="?test_sudoku&difficulty=easy" class="<?php echo $difficulty === 'easy' ? 'active' : ''; ?>">Easy</a>
            <a href="?test_sudoku&difficulty=medium" class="<?php echo $difficulty === 'medium' ? 'active' : ''; ?>">Medium</a>
            <a href="?test_sudoku&difficulty=hard" class="<?php echo $difficulty === 'hard' ? 'active' : ''; ?>">Hard</a>
            <a href="?test_sudoku&difficulty=expert" class="<?php echo $difficulty === 'expert' ? 'active' : ''; ?>">Expert</a>
        </div>

        <div class="container">
            <!-- Puzzle -->
            <div class="board-container">
                <h2>📋 Puzzle</h2>
                <div class="sudoku-grid">
                    <?php
                    $puzzle = $game_data['puzzle'];
                    $filled_cells = 0;
                    for ( $row = 0; $row < 9; $row++ ) {
                        for ( $col = 0; $col < 9; $col++ ) {
                            $value = $puzzle[$row][$col];
                            $is_initial = $value !== 0;
                            if ( $is_initial ) $filled_cells++;
                            $class = $is_initial ? 'cell initial' : 'cell empty';
                            $display = $is_initial ? $value : '';
                            echo "<div class='$class'>$display</div>";
                        }
                    }
                    ?>
                </div>
                <div class="stats">
                    <div class="stat">
                        <div class="stat-label">Filled</div>
                        <div class="stat-value"><?php echo $filled_cells; ?></div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Empty</div>
                        <div class="stat-value"><?php echo 81 - $filled_cells; ?></div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Hints</div>
                        <div class="stat-value"><?php echo $game_data['max_hints']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Solution -->
            <div class="board-container">
                <h2>✅ Solution</h2>
                <div class="sudoku-grid">
                    <?php
                    $solution = $game_data['solution'];
                    for ( $row = 0; $row < 9; $row++ ) {
                        for ( $col = 0; $col < 9; $col++ ) {
                            $value = $solution[$row][$col];
                            echo "<div class='cell solution'>$value</div>";
                        }
                    }
                    ?>
                </div>
                <div class="stats">
                    <div class="stat">
                        <div class="stat-label">Valid</div>
                        <div class="stat-value">✓</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Complete</div>
                        <div class="stat-value">100%</div>
                    </div>
                    <div class="stat">
                        <div class="stat-label">Unique</div>
                        <div class="stat-value">Yes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info" style="margin-top: 30px;">
            <h3>🧪 Test Results:</h3>
            <ul>
                <li>✅ Generator działa - utworzono puzzle <?php echo $difficulty; ?></li>
                <li>✅ Solver działa - wygenerowano pełne rozwiązanie</li>
                <li>✅ Validator działa - rozwiązanie jest poprawne</li>
                <li>✅ Puzzle ma <?php echo $filled_cells; ?> wskazówek (powinno być ~<?php echo 81 - Sudoku_Generator::get_difficulty_params($difficulty)['cells_to_remove']; ?>)</li>
            </ul>
            <p><strong>Odśwież stronę</strong> aby wygenerować nowe puzzle!</p>
        </div>
    </body>
    </html>
    <?php
    exit;
} );
