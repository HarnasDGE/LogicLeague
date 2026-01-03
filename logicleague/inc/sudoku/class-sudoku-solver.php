<?php
/**
 * Sudoku Solver
 * Rozwiązuje puzzle Sudoku używając algorytmu backtracking
 *
 * @package LogicLeague
 */

require_once get_template_directory() . '/inc/sudoku/class-sudoku-validator.php';

class Sudoku_Solver {

    /**
     * Fisher-Yates shuffle algorithm
     *
     * @param array $array Tablica do przetasowania
     * @return array Przetasowana tablica
     */
    private static function shuffle_array($array) {
        $new_array = $array;
        $count = count($new_array);

        for ($i = $count - 1; $i > 0; $i--) {
            $j = rand(0, $i);
            $temp = $new_array[$i];
            $new_array[$i] = $new_array[$j];
            $new_array[$j] = $temp;
        }

        return $new_array;
    }

    /**
     * Rozwiązuje Sudoku używając backtracking z randomizacją
     *
     * @param array &$board Referencja do planszy 9x9
     * @return bool True jeśli rozwiązano
     */
    public static function solve(&$board) {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                if ($board[$row][$col] === 0) {
                    // Losowa kolejność liczb dla różnorodności puzzli
                    $numbers = self::shuffle_array([1, 2, 3, 4, 5, 6, 7, 8, 9]);

                    foreach ($numbers as $num) {
                        if (Sudoku_Validator::is_valid_move($board, $row, $col, $num)) {
                            $board[$row][$col] = $num;

                            if (self::solve($board)) {
                                return true;
                            }

                            // Backtrack
                            $board[$row][$col] = 0;
                        }
                    }

                    return false;
                }
            }
        }

        return true; // Plansza kompletna
    }

    /**
     * Generuje pełne rozwiązanie Sudoku
     *
     * @return array Pełna plansza 9x9
     */
    public static function generate_solution() {
        // Pusta plansza
        $board = array_fill(0, 9, array_fill(0, 9, 0));

        // Rozwiąż
        self::solve($board);

        return $board;
    }
}
