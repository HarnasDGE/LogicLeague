<?php
/**
 * Template for displaying single Quiz
 *
 * @package LogicLeague
 */

get_header();

while (have_posts()): the_post();
    $quiz_id = get_the_ID();
    $quiz_difficulty = get_post_meta($quiz_id, 'quiz_difficulty', true);
    $quiz_time_limit = get_post_meta($quiz_id, 'quiz_time_limit', true);
    $question_ids = get_post_meta($quiz_id, 'quiz_question_ids', true);

    // Get questions data
    $questions_data = array();
    if ($question_ids && is_array($question_ids)) {
        foreach ($question_ids as $q_id) {
            $questions_data[] = array(
                'id' => $q_id,
                'question' => get_the_title($q_id),
                'answer_a' => get_post_meta($q_id, 'answer_a', true),
                'answer_b' => get_post_meta($q_id, 'answer_b', true),
                'answer_c' => get_post_meta($q_id, 'answer_c', true),
                'answer_d' => get_post_meta($q_id, 'answer_d', true),
                'correct_answer' => get_post_meta($q_id, 'correct_answer', true),
                'image' => get_the_post_thumbnail_url($q_id, 'large'),
                'images' => get_post_meta($q_id, 'question_images', true),
            );
        }
    }
?>

<article id="quiz-<?php the_ID(); ?>" <?php post_class('single-quiz'); ?>>

    <!-- Quiz Hero -->
    <section class="quiz-hero">
        <div class="container">
            <div class="quiz-hero-content">
                <?php
                $terms = get_the_terms($quiz_id, 'quiz_category');
                if ($terms && !is_wp_error($terms)): ?>
                <span class="quiz-category-badge">
                    <?php echo esc_html($terms[0]->name); ?>
                </span>
                <?php endif; ?>

                <h1 class="quiz-title"><?php the_title(); ?></h1>

                <?php if (has_excerpt()): ?>
                <p class="quiz-description"><?php the_excerpt(); ?></p>
                <?php endif; ?>

                <div class="quiz-meta">
                    <div class="quiz-meta-item">
                        <span class="quiz-meta-icon">📝</span>
                        <span><?php echo count($questions_data); ?> Questions</span>
                    </div>
                    <?php if ($quiz_difficulty): ?>
                    <div class="quiz-meta-item">
                        <span class="quiz-meta-icon">⭐</span>
                        <span><?php echo esc_html($quiz_difficulty); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($quiz_time_limit): ?>
                    <div class="quiz-meta-item">
                        <span class="quiz-meta-icon">⏱️</span>
                        <span><?php echo esc_html($quiz_time_limit); ?> min</span>
                    </div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-start-quiz" id="startQuizBtn">
                    Start Quiz Now
                </button>
            </div>
        </div>
    </section>

    <!-- Quiz Content -->
    <section class="quiz-content-section">
        <div class="container">
            <div class="quiz-layout">
                <!-- Main Quiz Area -->
                <main class="quiz-main">
                    <!-- AdSense Placement -->
                    <div class="ad-placement ad-top">
                        <!-- Google AdSense code here -->
                        <div class="ad-placeholder">Advertisement</div>
                    </div>

                    <!-- Quiz Player Container -->
                    <div class="quiz-player" id="quizPlayer" style="display: none;">
                        <!-- Progress Bar -->
                        <div class="quiz-progress-container">
                            <div class="quiz-progress-bar">
                                <div class="quiz-progress-fill" id="progressFill"></div>
                            </div>
                            <div class="quiz-progress-text">
                                <span>Question <span id="currentQuestion">1</span> of <span id="totalQuestions"><?php echo count($questions_data); ?></span></span>
                                <span class="quiz-timer" id="quizTimer">00:00</span>
                            </div>
                        </div>

                        <!-- Question Container -->
                        <div class="quiz-question-container" id="questionContainer">
                            <!-- Questions will be loaded by JavaScript -->
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="quiz-navigation">
                            <button class="btn btn-secondary" id="prevBtn" disabled>
                                ← Previous
                            </button>
                            <button class="btn btn-primary" id="nextBtn">
                                Next →
                            </button>
                            <button class="btn btn-success" id="submitBtn" style="display: none;">
                                Submit Quiz
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Intro (before start) -->
                    <div class="quiz-intro" id="quizIntro">
                        <div class="quiz-intro-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- AdSense Placement -->
                    <div class="ad-placement ad-middle">
                        <div class="ad-placeholder">Advertisement</div>
                    </div>
                </main>

                <!-- Sidebar -->
                <?php get_template_part('template-parts/quiz/sidebar'); ?>
            </div>
        </div>
    </section>

</article>

<!-- Results Modal -->
<div class="quiz-results-modal" id="resultsModal" style="display: none;">
    <div class="results-overlay" id="resultsOverlay"></div>
    <div class="results-content">
        <div class="results-header">
            <h2>Quiz Complete!</h2>
            <div class="results-score">
                <div class="score-circle">
                    <span class="score-number" id="scoreNumber">0</span>
                    <span class="score-total">/ <span id="scoreTotal">0</span></span>
                </div>
            </div>
        </div>

        <div class="results-stats">
            <div class="stat-item">
                <span class="stat-label">Correct Answers</span>
                <span class="stat-value" id="correctAnswers">0</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Time Taken</span>
                <span class="stat-value" id="timeTaken">00:00</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Accuracy</span>
                <span class="stat-value" id="accuracy">0%</span>
            </div>
        </div>

        <div class="results-message" id="resultsMessage"></div>

        <div class="results-actions">
            <h3>Challenge Your Friends!</h3>
            <p>Share your score and see who can beat it</p>

            <div class="share-buttons">
                <button class="share-btn share-facebook" data-network="facebook">
                    <span class="share-icon">📘</span> Facebook
                </button>
                <button class="share-btn share-twitter" data-network="twitter">
                    <span class="share-icon">🐦</span> Twitter
                </button>
                <button class="share-btn share-whatsapp" data-network="whatsapp">
                    <span class="share-icon">💬</span> WhatsApp
                </button>
                <button class="share-btn share-copy" id="copyLinkBtn">
                    <span class="share-icon">🔗</span> Copy Link
                </button>
            </div>
        </div>

        <div class="results-quiz-suggestions">
            <h3>Try These Quizzes Next</h3>
            <div class="suggested-quizzes" id="suggestedQuizzes">
                <!-- Populated by JavaScript -->
            </div>
        </div>

        <div class="results-buttons">
            <button class="btn btn-secondary" id="retryBtn">Try Again</button>
            <button class="btn btn-primary" id="viewAnswersBtn">View Answers</button>
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<script type="application/json" id="quizQuestionsData">
<?php echo json_encode($questions_data); ?>
</script>

<?php endwhile; ?>

<!-- Other Quizzes Carousel -->
<?php get_template_part('template-parts/quiz/quiz-carousel'); ?>

<!-- Blog Posts Carousel -->
<?php get_template_part('template-parts/blog/posts-carousel'); ?>

<!-- CTA Section -->
<section class="quiz-cta-section">
    <div class="container">
        <div class="quiz-cta-box">
            <h2>Love Brain Teasers?</h2>
            <p>Try our Sudoku puzzles for more logic challenges!</p>
            <a href="<?php echo home_url('/sudoku'); ?>" class="btn btn-white">
                Play Sudoku Now
            </a>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter-cta-section">
    <div class="container">
        <div class="newsletter-cta-box">
            <h2>Get New Quizzes Weekly!</h2>
            <p>Subscribe to our newsletter and never miss a challenge.</p>
            <form class="newsletter-cta-form">
                <input type="email" placeholder="Enter your email" class="newsletter-cta-input" required>
                <button type="submit" class="btn btn-purple">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
