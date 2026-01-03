<?php
/**
 * Sudoku Generator
 * Generuje puzzle Sudoku o różnych poziomach trudności
 *
 * @package LogicLeague
 */

require_once get_template_directory() . '/inc/sudoku/class-sudoku-solver.php';

class Sudoku_Generator {

    /**
     * Parametry trudności
     */
    const DIFFICULTY_PARAMS = [
        'easy' => [
            'cells_to_remove' => 40,
            'max_hints' => 7
        ],
        'medium' => [
            'cells_to_remove' => 50,
            'max_hints' => 3
        ],
        'hard' => [
            'cells_to_remove' => 55,
            'max_hints' => 2
        ],
        'expert' => [
            'cells_to_remove' => 60,
            'max_hints' => 1
        ]
    ];

    /**
     * Tworzy puzzle poprzez usunięcie komórek z rozwiązania
     *
     * @param array $solution Pełne rozwiązanie 9x9
     * @param string $difficulty Poziom trudności
     * @return array Puzzle 9x9
     */
    private static function create_puzzle($solution, $difficulty) {
        $params = self::DIFFICULTY_PARAMS[$difficulty];
        $puzzle = [];

        // Deep copy
        for ($i = 0; $i < 9; $i++) {
            $puzzle[$i] = [];
            for ($j = 0; $j < 9; $j++) {
                $puzzle[$i][$j] = $solution[$i][$j];
            }
        }

        $cells_to_remove = $params['cells_to_remove'];
        $removed = 0;
        $max_attempts = $cells_to_remove * 2;
        $attempts = 0;

        while ($removed < $cells_to_remove && $attempts < $max_attempts) {
            $row = rand(0, 8);
            $col = rand(0, 8);

            if ($puzzle[$row][$col] !== 0) {
                $puzzle[$row][$col] = 0;
                $removed++;
            }

            $attempts++;
        }

        return $puzzle;
    }

    /**
     * Generuje kompletne puzzle z rozwiązaniem
     *
     * @param string $difficulty Poziom trudności
     * @return array ['puzzle' => array, 'solution' => array, 'difficulty' => string]
     */
    public static function generate($difficulty = 'easy') {
        // Walidacja poziomu trudności
        if (!isset(self::DIFFICULTY_PARAMS[$difficulty])) {
            $difficulty = 'easy';
        }

        // Generuj pełne rozwiązanie
        $solution = Sudoku_Solver::generate_solution();

        // Utwórz puzzle
        $puzzle = self::create_puzzle($solution, $difficulty);

        return [
            'puzzle' => $puzzle,
            'solution' => $solution,
            'difficulty' => $difficulty,
            'max_hints' => self::DIFFICULTY_PARAMS[$difficulty]['max_hints']
        ];
    }

    /**
     * Pobiera parametry trudności
     *
     * @param string $difficulty Poziom trudności
     * @return array
     */
    public static function get_difficulty_params($difficulty) {
        return self::DIFFICULTY_PARAMS[$difficulty] ?? self::DIFFICULTY_PARAMS['easy'];
    }
}
