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

        <!-- Not Logged In: Login Form -->
        <div class="results-guest" id="resultsGuest" style="display: none;">
            <div class="guest-login-form">
                <p class="guest-login-title">🏆 Login to save your score!</p>

                <form id="quizLoginForm" class="quiz-login-form">
                    <div class="form-group-compact">
                        <input type="email" name="user_email" id="quizLoginEmail" placeholder="Email" required>
                    </div>
                    <div class="form-group-compact">
                        <input type="password" name="user_password" id="quizLoginPassword" placeholder="Password" required>
                        <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password-compact">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn-login-submit">
                        <span class="btn-text">Login</span>
                        <span class="btn-loader" style="display: none;">...</span>
                    </button>
                    <div class="login-error" id="quizLoginError" style="display: none;"></div>
                </form>

                <div class="social-login-divider">
                    <span>or</span>
                </div>

                <div class="social-login-buttons">
                    <button class="btn-social btn-google" id="btnGoogleLogin">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        Google
                    </button>
                    <button class="btn-social btn-apple" id="btnAppleLogin">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                        Apple
                    </button>
                </div>

                <div class="register-link-compact">
                    Don't have an account? <a href="#" id="openRegisterModal">Sign up</a>
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

<!-- Login Modal (Standalone) -->
<div class="auth-modal" id="loginModal" style="display: none;">
    <div class="auth-modal-overlay" onclick="closeLoginModal()"></div>
    <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeLoginModal()" aria-label="Close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="auth-modal-header">
            <h2>Welcome Back!</h2>
            <p>Login to your LogicLeague account</p>
        </div>

        <form id="mainLoginForm" class="auth-form">
            <div class="form-group">
                <label for="mainLoginEmail">Email</label>
                <input type="email" id="mainLoginEmail" name="user_email" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label for="mainLoginPassword">Password</label>
                <input type="password" id="mainLoginPassword" name="user_password" placeholder="••••••••" required>
            </div>
            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember_me">
                    <span>Remember me</span>
                </label>
                <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password">Forgot password?</a>
            </div>
            <button type="submit" class="btn-auth-submit">
                <span class="btn-text">Login</span>
                <span class="btn-loader" style="display: none;">
                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/></svg>
                </span>
            </button>
            <div class="form-error" id="mainLoginError" style="display: none;"></div>
        </form>

        <div class="auth-divider">
            <span>or continue with</span>
        </div>

        <div class="social-auth-buttons">
            <button class="btn-social-auth btn-google-auth" onclick="loginWithGoogle()">
                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Google
            </button>
            <button class="btn-social-auth btn-apple-auth" onclick="loginWithApple()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                Apple
            </button>
        </div>

        <div class="auth-switch">
            Don't have an account? <a href="#" onclick="openRegisterModal(); closeLoginModal(); return false;">Sign up</a>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="auth-modal" id="registerModal" style="display: none;">
    <div class="auth-modal-overlay" onclick="closeRegisterModal()"></div>
    <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeRegisterModal()" aria-label="Close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="auth-modal-header">
            <h2>Create Account</h2>
            <p>Join LogicLeague and start competing!</p>
        </div>

        <form id="mainRegisterForm" class="auth-form">
            <div class="form-group">
                <label for="registerUsername">Username</label>
                <input type="text" id="registerUsername" name="user_login" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="registerEmail">Email</label>
                <input type="email" id="registerEmail" name="user_email" placeholder="your@email.com" required>
            </div>
            <div class="form-group">
                <label for="registerPassword">Password</label>
                <input type="password" id="registerPassword" name="user_password" placeholder="••••••••" required minlength="8">
                <small class="form-hint">At least 8 characters</small>
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required>
                    <span>I agree to the <a href="/terms" target="_blank">Terms of Service</a> and <a href="/privacy" target="_blank">Privacy Policy</a></span>
                </label>
            </div>
            <button type="submit" class="btn-auth-submit">
                <span class="btn-text">Create Account</span>
                <span class="btn-loader" style="display: none;">
                    <svg class="spinner" width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/></svg>
                </span>
            </button>
            <div class="form-error" id="mainRegisterError" style="display: none;"></div>
            <div class="form-success" id="mainRegisterSuccess" style="display: none;"></div>
        </form>

        <div class="auth-divider">
            <span>or sign up with</span>
        </div>

        <div class="social-auth-buttons">
            <button class="btn-social-auth btn-google-auth" onclick="registerWithGoogle()">
                <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Google
            </button>
            <button class="btn-social-auth btn-apple-auth" onclick="registerWithApple()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>
                Apple
            </button>
        </div>

        <div class="auth-switch">
            Already have an account? <a href="#" onclick="openLoginModal(); closeRegisterModal(); return false;">Login</a>
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
