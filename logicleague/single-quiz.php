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
    <div class="results-content-compact">
        <!-- Compact Header -->
        <div class="results-header-compact">
            <div class="score-circle-large">
                <span class="score-number-large" id="scoreNumber">0</span>
                <span class="score-divider">/</span>
                <span class="score-total-large" id="scoreTotal">0</span>
            </div>
            <p class="results-message-compact" id="resultsMessage"></p>
        </div>

        <!-- Compact Stats - Icons Only -->
        <div class="results-stats-compact">
            <div class="stat-compact stat-correct">
                <span class="stat-icon-only">✓</span>
                <span class="stat-value-only" id="correctAnswers">0</span>
            </div>
            <div class="stat-compact stat-wrong">
                <span class="stat-icon-only">✗</span>
                <span class="stat-value-only" id="wrongAnswers">0</span>
            </div>
            <div class="stat-compact stat-time">
                <span class="stat-icon-only">⏱</span>
                <span class="stat-value-only" id="timeTaken">00:00</span>
            </div>
            <div class="stat-compact stat-accuracy">
                <span class="stat-icon-only">🎯</span>
                <span class="stat-value-only" id="accuracy">0%</span>
            </div>
        </div>

        <!-- Logged In: Points & Share -->
        <div class="results-logged-in" id="resultsLoggedIn" style="display: none;">
            <div class="points-rank-compact" id="pointsRankInfo">
                <!-- Populated by JavaScript -->
            </div>
            <div class="share-icons-compact">
                <button class="share-icon-btn" data-network="facebook" title="Share on Facebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </button>
                <button class="share-icon-btn" data-network="twitter" title="Share on Twitter">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </button>
                <button class="share-icon-btn" data-network="whatsapp" title="Share on WhatsApp">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </button>
                <button class="share-icon-btn" id="copyLinkBtn" title="Copy Link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                </button>
            </div>
        </div>

        <!-- Not Logged In: Sign Up CTA -->
        <div class="results-guest" id="resultsGuest" style="display: none;">
            <div class="guest-cta">
                <p class="guest-cta-text">🏆 Sign up to save your progress and compete on leaderboards!</p>
                <div class="guest-cta-buttons">
                    <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn-guest btn-login">Login</a>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn-guest btn-register">Register</a>
                </div>
            </div>
        </div>

        <!-- Suggested Quizzes - Compact -->
        <div class="suggested-quizzes-compact" id="suggestedQuizzes">
            <!-- Populated by JavaScript - max 2 -->
        </div>

        <!-- Action Buttons -->
        <div class="results-actions-compact">
            <button class="btn-action btn-retry" id="retryBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                Try Again
            </button>
            <button class="btn-action btn-view-answers" id="viewAnswersBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                View Answers
            </button>
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
