<?php
/**
 * Template Name: Sudoku Landing Page
 *
 * Szablon strony głównej Sudoku - wybór poziomu trudności
 *
 * @package LogicLeague
 */

get_header();
?>

<!-- Hero Section -->
<section class="sudoku-hero">
    <div class="container">
        <div class="sudoku-hero-emoji">🎲</div>
        <h1 class="sudoku-hero-title">Play Sudoku Online</h1>
        <p class="sudoku-hero-description">
            Challenge your brain with classic 9×9 Sudoku puzzles.<br>
            From beginner to expert, we have the perfect puzzle for you!
        </p>
        <div class="sudoku-hero-buttons">
            <a href="#difficulties" class="btn btn-primary">Start Playing Now</a>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="sudoku-stats">
    <div class="container">
        <div class="sudoku-stats-grid">
            <div class="sudoku-stat">
                <div class="sudoku-stat-number">∞</div>
                <div class="sudoku-stat-label">Unique Puzzles</div>
            </div>
            <div class="sudoku-stat">
                <div class="sudoku-stat-number">24/7</div>
                <div class="sudoku-stat-label">Available</div>
            </div>
            <div class="sudoku-stat">
                <div class="sudoku-stat-number">100%</div>
                <div class="sudoku-stat-label">Free to Play</div>
            </div>
            <div class="sudoku-stat">
                <div class="sudoku-stat-number">4</div>
                <div class="sudoku-stat-label">Difficulty Levels</div>
            </div>
        </div>
    </div>
</section>

<!-- Difficulty Cards -->
<section id="difficulties" class="sudoku-difficulties">
    <div class="container">
        <div class="sudoku-section-header">
            <h2 class="sudoku-section-title">Choose Your Difficulty</h2>
            <p class="sudoku-section-description">
                Select a difficulty level that matches your skills. Each puzzle is carefully crafted to provide the perfect challenge.
            </p>
        </div>

        <div class="sudoku-difficulty-grid">
            <!-- Easy -->
            <a href="<?php echo home_url('/sudoku/easy'); ?>" class="sudoku-difficulty-card">
                <div class="sudoku-difficulty-emoji">😊</div>
                <h3 class="sudoku-difficulty-title">Easy</h3>
                <p class="sudoku-difficulty-description">
                    Perfect for beginners. Learn the basics with generous hints.
                </p>
                <div class="sudoku-difficulty-stats">
                    <div class="sudoku-difficulty-stat">
                        <span>Clues:</span>
                        <strong>40-45</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Time:</span>
                        <strong>5-10 min</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Hints:</span>
                        <strong>7</strong>
                    </div>
                </div>
                <div class="sudoku-difficulty-button sudoku-difficulty-button-easy">
                    Play Easy →
                </div>
            </a>

            <!-- Medium -->
            <a href="<?php echo home_url('/sudoku/medium'); ?>" class="sudoku-difficulty-card">
                <div class="sudoku-difficulty-emoji">🤔</div>
                <h3 class="sudoku-difficulty-title">Medium</h3>
                <p class="sudoku-difficulty-description">
                    For players with some experience. A balanced challenge.
                </p>
                <div class="sudoku-difficulty-stats">
                    <div class="sudoku-difficulty-stat">
                        <span>Clues:</span>
                        <strong>30-35</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Time:</span>
                        <strong>10-15 min</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Hints:</span>
                        <strong>3</strong>
                    </div>
                </div>
                <div class="sudoku-difficulty-button sudoku-difficulty-button-medium">
                    Play Medium →
                </div>
            </a>

            <!-- Hard -->
            <a href="<?php echo home_url('/sudoku/hard'); ?>" class="sudoku-difficulty-card">
                <div class="sudoku-difficulty-emoji">😤</div>
                <h3 class="sudoku-difficulty-title">Hard</h3>
                <p class="sudoku-difficulty-description">
                    For skilled players. Requires advanced techniques.
                </p>
                <div class="sudoku-difficulty-stats">
                    <div class="sudoku-difficulty-stat">
                        <span>Clues:</span>
                        <strong>25-30</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Time:</span>
                        <strong>15-25 min</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Hints:</span>
                        <strong>2</strong>
                    </div>
                </div>
                <div class="sudoku-difficulty-button sudoku-difficulty-button-hard">
                    Play Hard →
                </div>
            </a>

            <!-- Expert -->
            <a href="<?php echo home_url('/sudoku/expert'); ?>" class="sudoku-difficulty-card">
                <div class="sudoku-difficulty-emoji">🔥</div>
                <h3 class="sudoku-difficulty-title">Expert</h3>
                <p class="sudoku-difficulty-description">
                    Only for masters. The ultimate Sudoku challenge!
                </p>
                <div class="sudoku-difficulty-stats">
                    <div class="sudoku-difficulty-stat">
                        <span>Clues:</span>
                        <strong>20-25</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Time:</span>
                        <strong>25-40 min</strong>
                    </div>
                    <div class="sudoku-difficulty-stat">
                        <span>Hints:</span>
                        <strong>1</strong>
                    </div>
                </div>
                <div class="sudoku-difficulty-button sudoku-difficulty-button-expert">
                    Play Expert →
                </div>
            </a>
        </div>
    </div>
</section>

<!-- How to Play -->
<section class="sudoku-how-to-play">
    <div class="container">
        <div class="sudoku-section-header">
            <h2 class="sudoku-section-title">How to Play Sudoku</h2>
            <p class="sudoku-section-description">
                Master the classic puzzle game in 4 simple steps
            </p>
        </div>

        <div class="sudoku-how-to-play-grid">
            <div class="sudoku-how-to-play-step">
                <div class="sudoku-how-to-play-number">1</div>
                <div class="sudoku-how-to-play-content">
                    <h3>Fill the Grid</h3>
                    <p>Each row must contain numbers 1-9 without repetition</p>
                </div>
            </div>

            <div class="sudoku-how-to-play-step">
                <div class="sudoku-how-to-play-number">2</div>
                <div class="sudoku-how-to-play-content">
                    <h3>Check Columns</h3>
                    <p>Each column must also have all numbers 1-9 exactly once</p>
                </div>
            </div>

            <div class="sudoku-how-to-play-step">
                <div class="sudoku-how-to-play-number">3</div>
                <div class="sudoku-how-to-play-content">
                    <h3>Verify Boxes</h3>
                    <p>Each 3×3 box must contain numbers 1-9 without duplicates</p>
                </div>
            </div>

            <div class="sudoku-how-to-play-step">
                <div class="sudoku-how-to-play-number">4</div>
                <div class="sudoku-how-to-play-content">
                    <h3>Solve the Puzzle</h3>
                    <p>Use logic and elimination to fill all 81 cells correctly</p>
                </div>
            </div>
        </div>

        <div class="sudoku-pro-tip">
            <h3>💡 Pro Tip</h3>
            <p>
                Start by looking for rows, columns, or boxes that are almost complete. Fill in the easy numbers first,
                then use process of elimination for the harder ones. With practice, you'll develop pattern recognition
                skills that make solving faster!
            </p>
        </div>
    </div>
</section>

<?php
get_footer();
