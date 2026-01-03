<?php
/**
 * Template Name: Front Page
 * Strona główna LogicLeague
 *
 * @package LogicLeague
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-shapes">
            <div class="floating-emoji" style="top: 15%; right: 20%;">🧠</div>
            <div class="floating-emoji" style="top: 30%; right: 15%;">💡</div>
            <div class="floating-emoji" style="top: 45%; right: 25%;">❓</div>
            <div class="floating-shape circle" style="top: 20%; right: 10%;"></div>
            <div class="floating-shape square" style="top: 60%; right: 18%;"></div>
            <div class="floating-shape triangle" style="top: 75%; right: 12%;"></div>
        </div>
    </div>

    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Exercise Your Grey Matter!</h1>
            <p class="hero-subtitle">
                Welcome to LogicLeague - the best platform for developing<br>
                your logical thinking skills. Practice daily and watch your<br>
                brain power grow with our carefully crafted puzzles!
            </p>

            <div class="hero-features">
                <div class="hero-feature">
                    <div class="hero-feature-icon">🔒</div>
                    <span>100% Secure Platform</span>
                </div>
                <div class="hero-feature">
                    <div class="hero-feature-icon">🔑</div>
                    <span>Unlimited Access</span>
                </div>
                <div class="hero-feature">
                    <div class="hero-feature-icon">🏆</div>
                    <span>Track Your Progress</span>
                </div>
            </div>

            <div class="hero-cta">
                <a href="#categories" class="btn btn-yellow">Join now for free!</a>
            </div>

            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <span>5.0 Rating</span>
                </div>
                <div class="hero-stat">
                    <strong>100K+</strong>
                    <span>Active Users</span>
                </div>
                <div class="hero-stat">
                    <strong>50K+</strong>
                    <span>Puzzles Solved</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-header">
            <div class="stats-emoji">💡</div>
            <h2 class="stats-title">Don't Play Alone!</h2>
            <p class="stats-description">Join our vibrant community and discover new ways of thinking</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-icon-purple">🧩</div>
                <div class="stat-number">500K+</div>
                <div class="stat-label">Brain Puzzles</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">👥</div>
                <div class="stat-number">10K+</div>
                <div class="stat-label">Active Players</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-yellow">🏅</div>
                <div class="stat-number">20K+</div>
                <div class="stat-label">Daily Challenges</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon-orange">📊</div>
                <div class="stat-number">13K+</div>
                <div class="stat-label">Success Stories</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Discover Your Knowledge Category</h2>
            <p class="section-description">Choose a topic that interests you and test your knowledge</p>
        </div>

        <div class="categories-grid">
            <!-- Sudoku -->
            <a href="<?php echo home_url('/sudoku'); ?>" class="category-card">
                <div class="category-icon">🎲</div>
                <h3 class="category-title">Sudoku</h3>
                <div class="category-stats">
                    <span class="category-quizzes">4 levels</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button">Practice</div>
            </a>

            <!-- Geography -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">🌍</div>
                <h3 class="category-title">Geography</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- History & Science -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">📚</div>
                <h3 class="category-title">History & Science</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- Sports -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">⚽</div>
                <h3 class="category-title">Sports</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- Arts & Crafts -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">🎨</div>
                <h3 class="category-title">Arts & Crafts</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- Food & Drink -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">🍔</div>
                <h3 class="category-title">Food & Drink</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- Logic Puzzles -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">🧠</div>
                <h3 class="category-title">Logic Puzzles</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>

            <!-- Math Challenges -->
            <div class="category-card category-card-disabled">
                <div class="category-icon">🔢</div>
                <h3 class="category-title">Math Challenges</h3>
                <div class="category-stats">
                    <span class="category-quizzes">Coming Soon</span>
                    <div class="category-rating">⭐⭐⭐⭐⭐</div>
                </div>
                <div class="category-button category-button-disabled">Soon</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section-blue">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Test Your Knowledge<br>Right Now!</h2>
            <p class="cta-description">
                Join thousands of players and challenge yourself with our<br>
                brain-teasing puzzles. Start your journey today!
            </p>

            <div class="cta-buttons">
                <a href="<?php echo home_url('/sudoku'); ?>" class="btn btn-yellow">Start Playing</a>
                <a href="#categories" class="btn btn-outline-white">Browse Categories</a>
                <a href="#" class="btn btn-outline-white">Learn More</a>
            </div>

            <div class="cta-features">
                <div class="cta-feature">✓ No credit card required</div>
                <div class="cta-feature">✓ Instant access</div>
                <div class="cta-feature">✓ Cancel anytime</div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Sudoku Section -->
<section class="puzzles-section">
    <div class="container">
        <div class="section-header-with-link">
            <h2 class="section-title">Latest Sudoku Puzzles</h2>
            <a href="<?php echo home_url('/sudoku'); ?>" class="view-all-link">View All →</a>
        </div>

        <div class="puzzles-grid">
            <div class="puzzle-card">
                <div class="puzzle-icon">🎲</div>
                <h3 class="puzzle-title">Easy Sudoku</h3>
                <p class="puzzle-description">Perfect for beginners. Practice your logical thinking with gentle puzzles.</p>
                <div class="puzzle-meta">
                    <span>⏱️ 5-10 min</span>
                    <span>👥 10K+ players</span>
                </div>
                <a href="<?php echo home_url('/sudoku/easy'); ?>" class="btn btn-purple-full">Start</a>
            </div>

            <div class="puzzle-card">
                <div class="puzzle-icon">🎯</div>
                <h3 class="puzzle-title">Medium Sudoku</h3>
                <p class="puzzle-description">Challenge yourself with more complex patterns and logical deductions.</p>
                <div class="puzzle-meta">
                    <span>⏱️ 10-15 min</span>
                    <span>👥 8K+ players</span>
                </div>
                <a href="<?php echo home_url('/sudoku/medium'); ?>" class="btn btn-purple-full">Start</a>
            </div>

            <div class="puzzle-card">
                <div class="puzzle-icon">🔥</div>
                <h3 class="puzzle-title">Expert Sudoku</h3>
                <p class="puzzle-description">For masters only. The ultimate test of your Sudoku solving skills.</p>
                <div class="puzzle-meta">
                    <span>⏱️ 25-40 min</span>
                    <span>👥 5K+ players</span>
                </div>
                <a href="<?php echo home_url('/sudoku/expert'); ?>" class="btn btn-purple-full">Start</a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="newsletter-background">
        <div class="newsletter-shapes">
            <div class="floating-emoji" style="top: 20%; left: 10%;">🎯</div>
            <div class="floating-emoji" style="top: 40%; left: 15%;">🧩</div>
            <div class="floating-emoji" style="top: 60%; left: 8%;">🏆</div>
            <div class="floating-emoji" style="top: 30%; right: 10%;">💡</div>
            <div class="floating-emoji" style="top: 70%; right: 15%;">⭐</div>
        </div>
    </div>

    <div class="container">
        <div class="newsletter-content">
            <h2 class="newsletter-title">Join Our Community</h2>
            <p class="newsletter-description">
                Get weekly challenges and stay updated with new puzzles
            </p>

            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-purple">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
