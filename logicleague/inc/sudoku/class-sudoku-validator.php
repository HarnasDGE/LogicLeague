<?php
/**
 * Sudoku Validator
 * Walidacja ruchów w grze Sudoku
 *
 * @package LogicLeague
 */

class Sudoku_Validator {

    /**
     * Sprawdza czy ruch jest poprawny
     *
     * @param array $board Plansza 9x9
     * @param int $row Wiersz (0-8)
     * @param int $col Kolumna (0-8)
     * @param int $num Liczba do sprawdzenia (1-9)
     * @return bool
     */
    public static function is_valid_move($board, $row, $col, $num) {
        // Sprawdź wiersz
        for ($x = 0; $x < 9; $x++) {
            if ($board[$row][$x] === $num) {
                return false;
            }
        }

        // Sprawdź kolumnę
        for ($x = 0; $x < 9; $x++) {
            if ($board[$x][$col] === $num) {
                return false;
            }
        }

        // Sprawdź box 3x3
        $box_row = floor($row / 3) * 3;
        $box_col = floor($col / 3) * 3;

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($board[$box_row + $i][$box_col + $j] === $num) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Sprawdza czy plansza jest kompletna i poprawna
     *
     * @param array $board Plansza 9x9
     * @return bool
     */
    public static function is_complete($board) {
        for ($row = 0; $row < 9; $row++) {
            for ($col = 0; $col < 9; $col++) {
                $value = $board[$row][$col];

                // Jeśli pusta komórka
                if ($value === 0) {
                    return false;
                }

                // Tymczasowo wyzeruj komórkę
                $board[$row][$col] = 0;

                // Sprawdź czy wartość jest poprawna
                if (!self::is_valid_move($board, $row, $col, $value)) {
                    return false;
                }

                // Przywróć wartość
                $board[$row][$col] = $value;
            }
        }

        return true;
    }
}
