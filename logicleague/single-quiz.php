<?php
/**
 * Template for displaying single Quiz
 *
 * @package LogicLeague
 */

get_header();

while (have_posts()): the_post();
    $quiz_id = get_the_ID();
    $quiz_difficulty = get_field('quiz_difficulty');
    $quiz_time_limit = get_field('quiz_time_limit');

    // Get questions using ACF relationship field
    $questions = get_field('questions'); // Returns array of post objects

    // Get questions data
    $questions_data = array();
    if ($questions && is_array($questions)) {
        foreach ($questions as $question_post) {
            // Get question data using ACF
            $correct_answer_raw = get_field('correct_answer', $question_post->ID);
            // Convert 'answer_a' to 'a', 'answer_b' to 'b', etc.
            $correct_answer = str_replace('answer_', '', $correct_answer_raw);

            $questions_data[] = array(
                'id' => $question_post->ID,
                'question' => $question_post->post_title,
                'answer_a' => get_field('answer_a', $question_post->ID),
                'answer_b' => get_field('answer_b', $question_post->ID),
                'answer_c' => get_field('answer_c', $question_post->ID),
                'answer_d' => get_field('answer_d', $question_post->ID),
                'correct_answer' => $correct_answer,
                'image' => get_the_post_thumbnail_url($question_post->ID, 'large'),
                'images' => get_field('images', $question_post->ID),
            );
        }
    }

    // Debug info (remove after testing)
    if (current_user_can('edit_posts')) {
        echo '<!-- Debug Info:';
        echo ' Questions from ACF: ' . print_r($questions, true);
        echo ' Questions Data Count: ' . count($questions_data);
        if (!empty($questions_data)) {
            echo ' First Question Data: ' . print_r($questions_data[0], true);
        }
        echo ' -->';
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
            </div>
        </div>
    </section>

    <!-- Quiz Content -->
    <section class="quiz-content-section">
        <div class="container">
            <div class="quiz-layout">
                <!-- Main Quiz Area -->
                <main class="quiz-main">
                    <!-- Quiz Player Container -->
                    <div class="quiz-player" id="quizPlayer">
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

                        <!-- Ad Space (rotates every 3 questions) -->
                        <div class="quiz-ad-space" id="quizAdSpace">
                            <!-- AdSense code will be inserted here -->
                            <div class="ad-placeholder" data-ad="1">
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-XXXXXXXXXX"
                                     data-ad-slot="XXXXXXXXXX"
                                     data-ad-format="auto"
                                     data-full-width-responsive="true"></ins>
                            </div>
                            <div class="ad-placeholder" data-ad="2" style="display: none;">
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-XXXXXXXXXX"
                                     data-ad-slot="XXXXXXXXXX"
                                     data-ad-format="auto"
                                     data-full-width-responsive="true"></ins>
                            </div>
                            <div class="ad-placeholder" data-ad="3" style="display: none;">
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-XXXXXXXXXX"
                                     data-ad-slot="XXXXXXXXXX"
                                     data-ad-format="auto"
                                     data-full-width-responsive="true"></ins>
                            </div>
                        </div>

                        <!-- Question Container -->
                        <div class="quiz-question-container" id="questionContainer">
                            <!-- Questions will be loaded by JavaScript -->
                        </div>
                    </div>

                    <?php if (empty($questions_data) && current_user_can('edit_posts')): ?>
                    <div class="quiz-warning" style="background: #fee; border: 2px solid #f00; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                        <h4 style="color: #c00; margin-top: 0;">⚠️ Admin Notice: No Questions Found</h4>
                        <p><strong>How to fix:</strong></p>
                        <ol>
                            <li>Edit this quiz</li>
                            <li>In the "Questions" field, select the questions you want to include</li>
                            <li>Make sure each Question post has all answer fields filled (answer_a, answer_b, answer_c, answer_d, correct_answer)</li>
                            <li>Save/Update the quiz</li>
                        </ol>
                        <p><em>This message is only visible to editors.</em></p>
                    </div>
                    <?php endif; ?>

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
