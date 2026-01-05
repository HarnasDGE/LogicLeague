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
<section class="hero-section-new">
    <div class="hero-gradient-bg"></div>
    <div class="container">
        <div class="hero-wrapper-new">
            <div class="hero-content-new">
                <h1 class="hero-title-new">Test Your Knowledge,<br>Master Every Quiz!</h1>
                <p class="hero-description-new">
                    Join LogicLeague - the ultimate destination for trivia lovers and puzzle enthusiasts!
                    Challenge yourself with thousands of engaging quizzes across Movies, Geography, History,
                    Science, Sports and more. Compete with players worldwide, earn points, level up, and prove
                    you're the ultimate quiz master. From Sudoku puzzles to brain-teasing trivia - your next
                    challenge awaits!
                </p>

                <!-- Colorful CTAs -->
                <div class="hero-cta-group">
                    <a href="#featured" class="btn btn-primary-hero">
                        <span>Play Quiz Now</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="<?php echo home_url('/sudoku'); ?>" class="btn btn-secondary-hero">
                        <span>Try Sudoku</span>
                    </a>
                </div>

                <!-- Social Proof -->
                <div class="hero-proof">
                    <div class="proof-item">
                        <div class="proof-icon">🎮</div>
                        <div class="proof-content">
                            <strong>1,000+</strong>
                            <span>Quiz Games</span>
                        </div>
                    </div>
                    <div class="proof-item">
                        <div class="proof-icon">👥</div>
                        <div class="proof-content">
                            <strong>50K+</strong>
                            <span>Active Players</span>
                        </div>
                    </div>
                    <div class="proof-item">
                        <div class="proof-icon">🏆</div>
                        <div class="proof-content">
                            <strong>1M+</strong>
                            <span>Quizzes Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-illustration">
                <div class="brain-character">
                    🧠
                    <div class="floating-element" style="top: -10%; left: -15%;">💡</div>
                    <div class="floating-element" style="top: -5%; right: -20%;">❓</div>
                    <div class="floating-element" style="bottom: 20%; left: -20%;">⚙️</div>
                    <div class="floating-element" style="bottom: 10%; right: -15%;">⭐</div>
                    <div class="floating-element" style="top: 50%; right: -25%;">🏅</div>
                    <div class="floating-element" style="bottom: -5%; left: 10%;">🎯</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave Divider -->
    <div class="hero-wave-new">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- CTA Banner -->
<section class="cta-banner-ranking">
    <div class="container">
        <div class="cta-banner-content">
            <div class="cta-banner-icon">
                <div class="trophy-illustration">
                    🏆
                    <div class="confetti-piece" style="top: -20%; left: -10%;">🎉</div>
                    <div class="confetti-piece" style="top: -15%; right: -5%;">✨</div>
                    <div class="confetti-piece" style="bottom: 10%; left: -15%;">🎊</div>
                </div>
            </div>
            <div class="cta-banner-text">
                <h2>Don't Play Alone!</h2>
                <p>Collect points, earn badges, and climb the League Rankings. Compete with thousands of players worldwide.</p>
            </div>
            <div class="cta-banner-action">
                <a href="#" class="btn btn-purple-gradient">View League Rankings</a>
            </div>
        </div>
    </div>
    <div class="cta-banner-waves"></div>
</section>

<!-- Featured Quizzes Carousel -->
<section class="featured-quizzes-section">
    <div class="container">
        <div class="section-header-featured">
            <h2 class="section-title-featured" id="featured">
                <span class="fire-icon">🔥</span> Featured Weekly Challenges
            </h2>
        </div>

        <div class="quizzes-carousel-wrapper">
            <button class="carousel-nav carousel-nav-prev" aria-label="Previous">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>

            <div class="quizzes-carousel">
                <div class="quizzes-carousel-track">
                    <!-- Quiz Card 1 -->
                    <div class="quiz-card-featured">
                        <div class="quiz-card-badge">🏆 TOP PICK</div>
                        <div class="quiz-card-bg quiz-card-bg-purple"></div>
                        <div class="quiz-card-content">
                            <div class="quiz-card-icon">
                                ❓
                                <div class="quiz-icon-decoration">💡</div>
                                <div class="quiz-icon-decoration">🧩</div>
                            </div>
                            <h3 class="quiz-card-title">Brain Teaser Challenge</h3>
                            <div class="quiz-card-difficulty">
                                <span>Difficulty</span>
                                <div class="difficulty-bar">
                                    <div class="difficulty-fill" style="width: 60%;"></div>
                                </div>
                            </div>
                            <div class="quiz-card-meta">
                                <span>👥 356 players</span>
                                <span>🔍 Hover zoom</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Card 2 -->
                    <div class="quiz-card-featured">
                        <div class="quiz-card-badge">🏆 TOP PICK</div>
                        <div class="quiz-card-bg quiz-card-bg-blue"></div>
                        <div class="quiz-card-content">
                            <div class="quiz-card-icon">
                                ❓
                                <div class="quiz-icon-decoration">🏔️</div>
                                <div class="quiz-icon-decoration">☀️</div>
                            </div>
                            <h3 class="quiz-card-title">Geography Master Quiz</h3>
                            <div class="quiz-card-difficulty">
                                <span>Difficulty</span>
                                <div class="difficulty-bar">
                                    <div class="difficulty-fill" style="width: 45%;"></div>
                                </div>
                            </div>
                            <div class="quiz-card-meta">
                                <span>👥 325 players</span>
                                <span>🔍 Hover zoom</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Card 3 -->
                    <div class="quiz-card-featured">
                        <div class="quiz-card-badge">🏆 TOP PICK</div>
                        <div class="quiz-card-bg quiz-card-bg-yellow"></div>
                        <div class="quiz-card-content">
                            <div class="quiz-card-icon">
                                ❓
                                <div class="quiz-icon-decoration">🏆</div>
                                <div class="quiz-icon-decoration">🧠</div>
                            </div>
                            <h3 class="quiz-card-title">Science & Logic Quiz</h3>
                            <div class="quiz-card-difficulty">
                                <span>Difficulty</span>
                                <div class="difficulty-bar">
                                    <div class="difficulty-fill" style="width: 75%;"></div>
                                </div>
                            </div>
                            <div class="quiz-card-meta">
                                <span>👥 326 players</span>
                                <span>🔍 Hover zoom</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-nav carousel-nav-next" aria-label="Next">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        </div>

        <div class="carousel-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="categories-section-new">
    <div class="container">
        <div class="section-header-center">
            <h2 class="section-title-main">Discover Your Knowledge Category</h2>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <button class="category-tab" data-category="filmy">
                <span class="tab-icon">🎬</span> Filmy
            </button>
            <button class="category-tab active" data-category="geografia">
                <span class="tab-icon">🌍</span> Geografia
            </button>
            <button class="category-tab" data-category="historia">
                <span class="tab-icon">📜</span> Historia
            </button>
            <button class="category-tab" data-category="science">
                <span class="tab-icon">🧪</span> Science
            </button>
            <button class="category-tab" data-category="sport">
                <span class="tab-icon">⚽</span> Sport
            </button>
        </div>

        <!-- Category Cards Grid -->
        <div class="category-cards-grid">
            <!-- Row 1 -->
            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #FF6B9D 0%, #FFC837 100%);">
                        🎬
                    </div>
                </div>
                <h3 class="category-card-title">Filmy and Rethinkr</h3>
                <p class="category-card-subtitle">Category</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 18 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #4A90E2 0%, #7FB3D5 100%);">
                        🌍
                    </div>
                </div>
                <h3 class="category-card-title">Geografia</h3>
                <p class="category-card-subtitle">History</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 18 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #F093FB 0%, #F5576C 100%);">
                        👥
                    </div>
                </div>
                <h3 class="category-card-title">Histori'ond Science</h3>
                <p class="category-card-subtitle">Kategory</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 15 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #FFD26F 0%, #3677FF 100%);">
                        ⚽
                    </div>
                </div>
                <h3 class="category-card-title">Sport</h3>
                <p class="category-card-subtitle">Sport</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 18 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #FA709A 0%, #FEE140 100%);">
                        🎨
                    </div>
                </div>
                <h3 class="category-card-title">Geogr ofr oshart</h3>
                <p class="category-card-subtitle">Category</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 15 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);">
                        📄
                    </div>
                </div>
                <h3 class="category-card-title">Wute Practions</h3>
                <p class="category-card-subtitle">Category</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 15 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #F5AF19 0%, #F12711 100%);">
                        🏆
                    </div>
                </div>
                <h3 class="category-card-title">Wirld Zaczetaru</h3>
                <p class="category-card-subtitle">Category</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 15 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>

            <div class="category-card-new">
                <button class="category-bookmark" aria-label="Bookmark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                </button>
                <div class="category-card-illustration">
                    <div class="illustration-placeholder" style="background: linear-gradient(135deg, #3EECAC 0%, #EE74E1 100%);">
                        🏔️
                    </div>
                </div>
                <h3 class="category-card-title">Super lire doat to</h3>
                <p class="category-card-subtitle">History</p>
                <div class="category-card-footer">
                    <span class="category-duration">⏱️ 18 min</span>
                    <a href="#" class="btn btn-purple-small">Play Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community CTA Section -->
<section class="community-cta-section">
    <div class="container">
        <div class="community-cta-wrapper">
            <div class="community-illustration">
                <div class="campfire-scene">
                    <div class="campfire-people">👥👥👥</div>
                    <div class="campfire">🔥</div>
                </div>
                <div class="confetti-float" style="top: 10%; left: 10%;">🎉</div>
                <div class="confetti-float" style="top: 20%; right: 15%;">✨</div>
                <div class="confetti-float" style="bottom: 30%; left: 20%;">🎊</div>
                <div class="confetti-float" style="bottom: 15%; right: 10%;">⭐</div>
            </div>

            <div class="community-cta-content">
                <h2 class="community-title">Join Our Community</h2>
                <p class="community-subtitle">Sign up for our newsletter and get weekly challenges, tips, and exclusive content!</p>
                <form class="community-newsletter-form">
                    <input type="email" class="community-email-input" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-purple-cta">Subscribe Now!</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Knowledge Base Section -->
<section class="knowledge-base-section">
    <div class="container">
        <div class="section-header-center">
            <h2 class="section-title-main">Knowledge Base & Fun Facts</h2>
        </div>

        <div class="knowledge-grid">
            <!-- Article 1 -->
            <article class="knowledge-card">
                <div class="knowledge-card-image">
                    <div class="knowledge-illustration" style="background: linear-gradient(135deg, #84FAB0 0%, #8FD3F4 100%);">
                        📚
                    </div>
                </div>
                <div class="knowledge-card-content">
                    <h3 class="knowledge-card-title">10 Brain Training Tips for Daily Success</h3>
                    <p class="knowledge-card-label">Blog Article</p>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="knowledge-card">
                <div class="knowledge-card-image">
                    <div class="knowledge-illustration" style="background: linear-gradient(135deg, #FFD89B 0%, #19547B 100%);">
                        👥
                    </div>
                </div>
                <div class="knowledge-card-content">
                    <h3 class="knowledge-card-title">How to Improve Your Memory: Science-Backed Methods</h3>
                    <p class="knowledge-card-label">Blog Article</p>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="knowledge-card">
                <div class="knowledge-card-image">
                    <div class="knowledge-illustration" style="background: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);">
                        ❓❓
                    </div>
                </div>
                <div class="knowledge-card-content">
                    <h3 class="knowledge-card-title">The Psychology Behind Puzzle Solving</h3>
                    <p class="knowledge-card-label">Blog Article</p>
                </div>
            </article>
        </div>
    </div>
</section>

<?php get_footer(); ?>
