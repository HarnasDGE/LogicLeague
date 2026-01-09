/**
 * Sudoku Player
 * Obsługa interaktywnej planszy Sudoku
 *
 * @package LogicLeague
 */

(function() {
    'use strict';

    // Constants
    const MAX_MISTAKES = 3;

    // Stan gry
    let gameState = {
        board: null,
        solution: null,
        initialPuzzle: null, // Zapisana początkowa plansza do resetowania
        selectedCell: null,
        mistakes: 0,
        hintsUsed: 0,
        maxHints: 0,
        difficulty: '',
        timerSeconds: 0,
        timerInterval: null,
        isComplete: false,
        pencilMode: false,
        pencilMarks: {}, // Format: "row,col": [1,2,3...]
        undoStack: [],
        redoStack: [],
        gameId: null
    };

    // Inicjalizacja
    document.addEventListener('DOMContentLoaded', function() {
        initGame();
    });

    /**
     * Inicjalizuje grę
     */
    function initGame() {
        const boardElement = document.getElementById('sudoku-board');
        if (!boardElement) return;

        // Pobierz rozwiązanie i trudność
        gameState.solution = JSON.parse(boardElement.dataset.solution);
        gameState.difficulty = boardElement.dataset.difficulty;

        // Pobierz maksymalną liczbę podpowiedzi
        const hintsElement = document.getElementById('hints');
        if (hintsElement) {
            const hintsText = hintsElement.textContent;
            const match = hintsText.match(/\/\s*(\d+)/);
            if (match) {
                gameState.maxHints = parseInt(match[1]);
            }
        }

        // Inicjalizuj stan planszy i zapisz początkową planszę
        gameState.board = [];
        gameState.initialPuzzle = [];
        for (let i = 0; i < 9; i++) {
            gameState.board[i] = [];
            gameState.initialPuzzle[i] = [];
            for (let j = 0; j < 9; j++) {
                gameState.board[i][j] = 0;
                gameState.initialPuzzle[i][j] = 0;
            }
        }

        // Załaduj wartości początkowe
        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => {
            const row = parseInt(cell.dataset.row);
            const col = parseInt(cell.dataset.col);
            const value = parseInt(cell.dataset.value);
            if (value !== 0) {
                gameState.board[row][col] = value;
                gameState.initialPuzzle[row][col] = value; // Zapisz również w initialPuzzle
            }
        });

        // Dodaj event listenery
        addEventListeners();

        // Rozpocznij timer
        startTimer();
    }

    /**
     * Dodaje event listenery
     */
    function addEventListeners() {
        // Kliknięcia na komórki
        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => {
            cell.addEventListener('click', function() {
                if (gameState.isComplete) return;
                selectCell(this);
            });
        });

        // Number buttons
        const numberButtons = document.querySelectorAll('.number-btn');
        numberButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (gameState.isComplete) return;
                const number = parseInt(this.dataset.number);
                inputNumber(number);
            });
        });

        // Klawiatura
        document.addEventListener('keydown', function(e) {
            if (gameState.isComplete) return;

            // Liczby 1-9
            if (e.key >= '1' && e.key <= '9') {
                inputNumber(parseInt(e.key));
            }
            // Backspace/Delete - wyczyść
            else if (e.key === 'Backspace' || e.key === 'Delete') {
                clearSelectedCell();
            }
            // Strzałki - nawigacja
            else if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.preventDefault();
                navigateWithArrows(e.key);
            }
        });

        // Przycisk wyczyść
        const clearButton = document.getElementById('clear-button');
        if (clearButton) {
            clearButton.addEventListener('click', clearSelectedCell);
        }

        // Przycisk podpowiedź
        const hintButton = document.getElementById('hint-button');
        if (hintButton) {
            hintButton.addEventListener('click', giveHint);
        }

        // Przycisk undo
        const undoButton = document.getElementById('undo-button');
        if (undoButton) {
            undoButton.addEventListener('click', undo);
        }

        // Przycisk redo
        const redoButton = document.getElementById('redo-button');
        if (redoButton) {
            redoButton.addEventListener('click', redo);
        }

        // Przycisk pencil (notes mode)
        const pencilButton = document.getElementById('pencil-button');
        if (pencilButton) {
            pencilButton.addEventListener('click', togglePencilMode);
        }

        // Przycisk nowa gra
        const newGameButton = document.getElementById('new-game-button');
        if (newGameButton) {
            newGameButton.addEventListener('click', function() {
                window.location.reload();
            });
        }

        // Przycisk pokaż rozwiązanie
        const solveButton = document.getElementById('solve-button');
        if (solveButton) {
            solveButton.addEventListener('click', showSolution);
        }

        // Zamknięcie modali
        const modal = document.getElementById('completion-modal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }

        const gameoverModal = document.getElementById('gameover-modal');
        if (gameoverModal) {
            gameoverModal.addEventListener('click', function(e) {
                if (e.target === gameoverModal) {
                    gameoverModal.style.display = 'none';
                }
            });
        }

        // Przycisk "Try Again" w gameover modal
        const tryAgainButton = document.getElementById('try-again-button');
        if (tryAgainButton) {
            tryAgainButton.addEventListener('click', resetGame);
        }

        // Przycisk "Try Again" w completion modal
        const tryAgainCompletionBtn = document.getElementById('try-again-completion');
        if (tryAgainCompletionBtn) {
            tryAgainCompletionBtn.addEventListener('click', function() {
                const modal = document.getElementById('completion-modal');
                if (modal) modal.style.display = 'none';
                resetGame();
            });
        }
    }

    /**
     * Zaznacza komórkę
     */
    function selectCell(cellElement) {
        // Nie zaznaczaj komórek początkowych
        if (cellElement.dataset.initial === '1') return;

        // Usuń poprzednie zaznaczenie
        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => {
            cell.classList.remove('sudoku-cell-selected');
            cell.classList.remove('sudoku-cell-highlighted');
        });

        // Zaznacz nową komórkę
        cellElement.classList.add('sudoku-cell-selected');
        gameState.selectedCell = cellElement;

        // Podświetl ten sam wiersz, kolumnę i box
        const row = parseInt(cellElement.dataset.row);
        const col = parseInt(cellElement.dataset.col);
        highlightRelatedCells(row, col);
    }

    /**
     * Podświetla powiązane komórki (wiersz, kolumna, box)
     */
    function highlightRelatedCells(row, col) {
        const cells = document.querySelectorAll('.sudoku-cell');
        const boxRow = Math.floor(row / 3);
        const boxCol = Math.floor(col / 3);

        cells.forEach(cell => {
            const cellRow = parseInt(cell.dataset.row);
            const cellCol = parseInt(cell.dataset.col);
            const cellBoxRow = Math.floor(cellRow / 3);
            const cellBoxCol = Math.floor(cellCol / 3);

            if (cellRow === row || cellCol === col ||
                (cellBoxRow === boxRow && cellBoxCol === boxCol)) {
                if (!cell.classList.contains('sudoku-cell-selected')) {
                    cell.classList.add('sudoku-cell-highlighted');
                }
            }
        });
    }

    /**
     * Wpisuje liczbę do zaznaczonej komórki
     */
    function inputNumber(number) {
        if (!gameState.selectedCell) return;

        const row = parseInt(gameState.selectedCell.dataset.row);
        const col = parseInt(gameState.selectedCell.dataset.col);
        const cellKey = `${row},${col}`;

        // Jeśli tryb notatek
        if (gameState.pencilMode) {
            togglePencilMark(row, col, number);
            return;
        }

        // Sprawdź czy poprawna
        const correctValue = gameState.solution[row][col];
        const isCorrect = number === correctValue;

        // Usuń poprzednie klasy błędu
        gameState.selectedCell.classList.remove('sudoku-cell-error');

        // Usuń notatki z tej komórki
        delete gameState.pencilMarks[cellKey];
        const notesDiv = gameState.selectedCell.querySelector('.sudoku-cell-notes');
        if (notesDiv) {
            notesDiv.innerHTML = '';
        }

        // Aktualizuj wartość
        gameState.board[row][col] = number;
        gameState.selectedCell.dataset.value = number;

        // Aktualizuj wyświetlanie
        let valueSpan = gameState.selectedCell.querySelector('.sudoku-cell-value');
        if (!valueSpan) {
            valueSpan = document.createElement('span');
            valueSpan.className = 'sudoku-cell-value';
            gameState.selectedCell.appendChild(valueSpan);
        }
        valueSpan.textContent = number;

        // Jeśli błąd
        if (!isCorrect) {
            gameState.selectedCell.classList.add('sudoku-cell-error');
            gameState.mistakes++;
            updateMistakes();

            // Sprawdź czy osiągnięto limit błędów
            if (gameState.mistakes >= MAX_MISTAKES) {
                setTimeout(() => {
                    gameOver();
                }, 1000);
                return;
            }

            // Usuń błąd po 1 sekundzie
            setTimeout(() => {
                gameState.selectedCell.classList.remove('sudoku-cell-error');
            }, 1000);
        }

        // Sprawdź czy ukończone
        if (isBoardComplete()) {
            completeGame();
        }
    }

    /**
     * Czyści zaznaczoną komórkę
     */
    function clearSelectedCell() {
        if (!gameState.selectedCell) return;
        if (gameState.selectedCell.dataset.initial === '1') return;

        const row = parseInt(gameState.selectedCell.dataset.row);
        const col = parseInt(gameState.selectedCell.dataset.col);
        const cellKey = `${row},${col}`;

        gameState.board[row][col] = 0;
        gameState.selectedCell.dataset.value = '0';

        const valueSpan = gameState.selectedCell.querySelector('.sudoku-cell-value');
        if (valueSpan) {
            valueSpan.remove();
        }

        // Wyczyść także notatki
        delete gameState.pencilMarks[cellKey];
        const notesDiv = gameState.selectedCell.querySelector('.sudoku-cell-notes');
        if (notesDiv) {
            notesDiv.innerHTML = '';
        }

        gameState.selectedCell.classList.remove('sudoku-cell-error');
    }

    /**
     * Dodaje/usuwa notatkę w komórce
     */
    function togglePencilMark(row, col, number) {
        const cellKey = `${row},${col}`;
        const cellElement = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);

        if (!cellElement) return;

        // Nie dodawaj notatek do komórek z wartościami
        if (gameState.board[row][col] !== 0) return;

        // Inicjalizuj tablicę notatek dla tej komórki
        if (!gameState.pencilMarks[cellKey]) {
            gameState.pencilMarks[cellKey] = [];
        }

        const marks = gameState.pencilMarks[cellKey];
        const index = marks.indexOf(number);

        if (index === -1) {
            // Dodaj notatkę
            marks.push(number);
            marks.sort((a, b) => a - b);
        } else {
            // Usuń notatkę
            marks.splice(index, 1);
        }

        // Renderuj notatki
        renderPencilMarks(cellElement, marks);
    }

    /**
     * Renderuje notatki w komórce
     */
    function renderPencilMarks(cellElement, marks) {
        const notesDiv = cellElement.querySelector('.sudoku-cell-notes');
        if (!notesDiv) return;

        notesDiv.innerHTML = '';

        // Utwórz siatkę 3x3 dla notatek
        for (let i = 1; i <= 9; i++) {
            const noteSpan = document.createElement('span');
            if (marks.includes(i)) {
                noteSpan.textContent = i;
            }
            notesDiv.appendChild(noteSpan);
        }
    }

    /**
     * Nawigacja strzałkami
     */
    function navigateWithArrows(key) {
        if (!gameState.selectedCell) {
            // Zaznacz pierwszą komórkę
            const firstCell = document.querySelector('.sudoku-cell:not([data-initial="1"])');
            if (firstCell) selectCell(firstCell);
            return;
        }

        let row = parseInt(gameState.selectedCell.dataset.row);
        let col = parseInt(gameState.selectedCell.dataset.col);

        switch (key) {
            case 'ArrowUp':
                row = row > 0 ? row - 1 : 8;
                break;
            case 'ArrowDown':
                row = row < 8 ? row + 1 : 0;
                break;
            case 'ArrowLeft':
                col = col > 0 ? col - 1 : 8;
                break;
            case 'ArrowRight':
                col = col < 8 ? col + 1 : 0;
                break;
        }

        const targetCell = document.querySelector(`[data-row="${row}"][data-col="${col}"]`);
        if (targetCell) selectCell(targetCell);
    }

    /**
     * Daje podpowiedź
     */
    function giveHint() {
        if (gameState.hintsUsed >= gameState.maxHints) {
            alert('Wykorzystałeś wszystkie podpowiedzi!');
            return;
        }

        // Znajdź pustą komórkę
        let emptyCells = [];
        for (let row = 0; row < 9; row++) {
            for (let col = 0; col < 9; col++) {
                if (gameState.board[row][col] === 0) {
                    emptyCells.push({ row, col });
                }
            }
        }

        if (emptyCells.length === 0) return;

        // Losowa pusta komórka
        const randomCell = emptyCells[Math.floor(Math.random() * emptyCells.length)];
        const cellElement = document.querySelector(
            `[data-row="${randomCell.row}"][data-col="${randomCell.col}"]`
        );

        if (cellElement) {
            selectCell(cellElement);
            const correctValue = gameState.solution[randomCell.row][randomCell.col];
            inputNumber(correctValue);

            gameState.hintsUsed++;
            updateHints();
        }
    }

    /**
     * Sprawdza czy plansza jest ukończona
     */
    function isBoardComplete() {
        for (let row = 0; row < 9; row++) {
            for (let col = 0; col < 9; col++) {
                if (gameState.board[row][col] !== gameState.solution[row][col]) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Pokazuje rozwiązanie
     */
    function showSolution() {
        if (!confirm('Czy na pewno chcesz zobaczyć rozwiązanie? Gra zostanie zakończona.')) {
            return;
        }

        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => {
            const row = parseInt(cell.dataset.row);
            const col = parseInt(cell.dataset.col);
            const correctValue = gameState.solution[row][col];

            cell.dataset.value = correctValue;
            gameState.board[row][col] = correctValue;

            let valueSpan = cell.querySelector('.sudoku-cell-value');
            if (!valueSpan) {
                valueSpan = document.createElement('span');
                valueSpan.className = 'sudoku-cell-value';
                cell.appendChild(valueSpan);
            }
            valueSpan.textContent = correctValue;
            cell.classList.remove('sudoku-cell-error');
        });

        stopTimer();
    }

    /**
     * Ukończenie gry
     */
    function completeGame() {
        gameState.isComplete = true;
        stopTimer();

        // Aktualizuj modal
        const finalTimeEl = document.getElementById('final-time');
        const finalMistakesEl = document.getElementById('final-mistakes');
        const finalHintsEl = document.getElementById('final-hints');

        if (finalTimeEl) finalTimeEl.textContent = document.getElementById('timer').textContent;
        if (finalMistakesEl) finalMistakesEl.textContent = gameState.mistakes;
        if (finalHintsEl) finalHintsEl.textContent = gameState.hintsUsed;

        // Wyślij wynik na serwer
        saveResultToLeaderboard();
    }

    /**
     * Zapisz wynik do leaderboard
     */
    function saveResultToLeaderboard() {
        // Sprawdź czy mamy dane z PHP
        if (typeof window.sudokuData === 'undefined') {
            // Nie jesteśmy w single-sudoku.php, pokaż zwykły modal
            showCompletionModal();
            return;
        }

        const data = new FormData();
        data.append('action', 'save_sudoku_result');
        data.append('nonce', window.sudokuData.nonce);
        data.append('sudoku_id', window.sudokuData.sudokuId);
        data.append('time_seconds', gameState.timerSeconds);
        data.append('mistakes', gameState.mistakes);
        data.append('hints_used', gameState.hintsUsed);

        fetch(window.sudokuData.ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Dla zalogowanych - pokaż wynik
                if (window.sudokuData.isLoggedIn) {
                    const messageEl = document.getElementById('completion-result-message');
                    if (messageEl) {
                        messageEl.className = 'result-message success';
                        messageEl.textContent = `🎉 Your result saved! Rank: #${result.data.rank} | Best time: ${formatTime(result.data.best_time)}`;
                    }
                    showCompletionModal();
                } else {
                    // Dla gości - pokaż modal rejestracji
                    showGuestRegisterModal();
                }
            } else {
                console.error('Save failed:', result.data.message);
                showCompletionModal();
            }
        })
        .catch(error => {
            console.error('AJAX error:', error);
            showCompletionModal();
        });
    }

    /**
     * Pokaż completion modal
     */
    function showCompletionModal() {
        const modal = document.getElementById('completion-modal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    /**
     * Pokaż guest register modal
     */
    function showGuestRegisterModal() {
        const guestTimeEl = document.getElementById('guest-final-time');
        if (guestTimeEl) {
            guestTimeEl.textContent = document.getElementById('timer').textContent;
        }

        const modal = document.getElementById('guest-register-modal');
        if (modal) {
            modal.style.display = 'flex';
        }

        // Przycisk "Skip register" - pokaż zwykły modal
        const skipBtn = document.getElementById('skip-register');
        if (skipBtn) {
            skipBtn.addEventListener('click', function() {
                if (modal) modal.style.display = 'none';
                showCompletionModal();
            });
        }
    }

    /**
     * Format czasu (sekundy → MM:SS)
     */
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }

    /**
     * Koniec gry (za dużo błędów)
     */
    function gameOver() {
        gameState.isComplete = true;
        stopTimer();

        // Aktualizuj modal
        document.getElementById('gameover-time').textContent = document.getElementById('timer').textContent;

        // Pokaż modal
        const modal = document.getElementById('gameover-modal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    /**
     * Resetuje grę do stanu początkowego (ta sama plansza)
     */
    function resetGame() {
        // Zatrzymaj timer
        stopTimer();

        // Zresetuj stan gry
        gameState.mistakes = 0;
        gameState.hintsUsed = 0;
        gameState.timerSeconds = 0;
        gameState.isComplete = false;
        gameState.pencilMode = false;
        gameState.pencilMarks = {};
        gameState.selectedCell = null;
        gameState.undoStack = [];
        gameState.redoStack = [];

        // Skopiuj początkową planszę do board
        for (let i = 0; i < 9; i++) {
            for (let j = 0; j < 9; j++) {
                gameState.board[i][j] = gameState.initialPuzzle[i][j];
            }
        }

        // Wyczyść wszystkie komórki na planszy
        const cells = document.querySelectorAll('.sudoku-cell');
        cells.forEach(cell => {
            const row = parseInt(cell.dataset.row);
            const col = parseInt(cell.dataset.col);
            const isInitial = cell.dataset.initial === '1';

            // Wyczyść komórki edytowalne
            if (!isInitial) {
                cell.dataset.value = '0';
                const valueSpan = cell.querySelector('.sudoku-cell-value');
                if (valueSpan) {
                    valueSpan.remove();
                }
                const notesDiv = cell.querySelector('.sudoku-cell-notes');
                if (notesDiv) {
                    notesDiv.innerHTML = '';
                }
            }

            // Usuń wszystkie klasy
            cell.classList.remove('sudoku-cell-selected', 'sudoku-cell-highlighted', 'sudoku-cell-error');
        });

        // Zaktualizuj interfejs
        updateMistakes();
        updateHints();
        updateTimerDisplay();

        // Wyłącz pencil mode jeśli aktywny
        const pencilButton = document.getElementById('pencil-button');
        if (pencilButton) {
            pencilButton.classList.remove('active');
        }

        // Zamknij modal
        const modal = document.getElementById('gameover-modal');
        if (modal) {
            modal.style.display = 'none';
        }

        // Uruchom timer od nowa
        startTimer();
    }

    /**
     * Timer
     */
    function startTimer() {
        gameState.timerInterval = setInterval(() => {
            gameState.timerSeconds++;
            updateTimerDisplay();
        }, 1000);
    }

    function stopTimer() {
        if (gameState.timerInterval) {
            clearInterval(gameState.timerInterval);
            gameState.timerInterval = null;
        }
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(gameState.timerSeconds / 60);
        const seconds = gameState.timerSeconds % 60;
        const display = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        document.getElementById('timer').textContent = display;
    }

    /**
     * Aktualizuj licznik błędów
     */
    function updateMistakes() {
        document.getElementById('mistakes').textContent = `${gameState.mistakes}/${MAX_MISTAKES}`;
    }

    /**
     * Aktualizuj licznik podpowiedzi
     */
    function updateHints() {
        document.getElementById('hints-used').textContent = gameState.hintsUsed;
    }

    /**
     * Undo - cofnij ruch
     */
    function undo() {
        // TODO: Implement undo logic
        console.log('Undo clicked');
    }

    /**
     * Redo - ponów ruch
     */
    function redo() {
        // TODO: Implement redo logic
        console.log('Redo clicked');
    }

    /**
     * Toggle pencil mode - tryb notatek
     */
    function togglePencilMode() {
        gameState.pencilMode = !gameState.pencilMode;
        const pencilButton = document.getElementById('pencil-button');
        if (pencilButton) {
            if (gameState.pencilMode) {
                pencilButton.classList.add('active');
            } else {
                pencilButton.classList.remove('active');
            }
        }
        console.log('Pencil mode:', gameState.pencilMode);
    }

})();
