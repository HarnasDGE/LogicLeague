<?php
/**
 * Template Name: User Profile
 *
 * @package LogicLeague
 */

get_header();

// Check if user is logged in
if (!is_user_logged_in()) {
    ?>
    <div class="container" style="padding: 4rem 1rem; text-align: center;">
        <h1>Please Log In</h1>
        <p>You need to be logged in to view your profile.</p>
        <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn btn-yellow">Sign In</a>
    </div>
    <?php
    get_footer();
    exit;
}

$user_id = get_current_user_id();
$user = wp_get_current_user();

// Get user stats
$total_points = get_user_meta($user_id, 'total_points', true);
$total_points = $total_points ? intval($total_points) : 0;

$quizzes_completed = get_user_meta($user_id, 'quizzes_completed', true);
$quizzes_completed = $quizzes_completed ? intval($quizzes_completed) : 0;

$user_level = get_user_meta($user_id, 'user_level', true);
$user_level = $user_level ? intval($user_level) : 1;

$quiz_history = get_user_meta($user_id, 'quiz_history', true);
if (!is_array($quiz_history)) {
    $quiz_history = array();
}

// Calculate quizzes completed from history if meta doesn't exist
if ($quizzes_completed === 0 && count($quiz_history) > 0) {
    $quizzes_completed = count($quiz_history);
    update_user_meta($user_id, 'quizzes_completed', $quizzes_completed);
}

// Get user rank
$user_rank = logicleague_get_user_rank($user_id);

// Calculate level progress
$points_for_current_level = ($user_level - 1) * 1000;
$points_for_next_level = $user_level * 1000;
$points_in_current_level = $total_points - $points_for_current_level;
$level_progress = ($points_in_current_level / 1000) * 100;

// Calculate average score
$total_score = 0;
$total_questions = 0;
foreach ($quiz_history as $quiz) {
    if (isset($quiz['score']) && isset($quiz['total_questions'])) {
        $total_score += $quiz['score'];
        $total_questions += $quiz['total_questions'];
    }
}
$avg_accuracy = $total_questions > 0 ? round(($total_score / $total_questions) * 100, 1) : 0;

?>

<div class="profile-page">
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo get_avatar($user_id, 120); ?>
            </div>
            <div class="profile-info">
                <h1 class="profile-name"><?php echo esc_html($user->display_name); ?></h1>
                <p class="profile-email"><?php echo esc_html($user->user_email); ?></p>
                <div class="profile-badges">
                    <span class="badge badge-level">Level <?php echo $user_level; ?></span>
                    <span class="badge badge-rank">Rank #<?php echo $user_rank; ?></span>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏆</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo number_format($total_points); ?></div>
                    <div class="stat-label">Total Points</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $quizzes_completed; ?></div>
                    <div class="stat-label">Quizzes Completed</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $avg_accuracy; ?>%</div>
                    <div class="stat-label">Average Accuracy</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $user_level; ?></div>
                    <div class="stat-label">Current Level</div>
                </div>
            </div>
        </div>

        <!-- Level Progress -->
        <div class="level-progress-card">
            <div class="level-progress-header">
                <h3>Level <?php echo $user_level; ?> Progress</h3>
                <span class="level-progress-text"><?php echo $points_in_current_level; ?> / 1,000 XP</span>
            </div>
            <div class="level-progress-bar">
                <div class="level-progress-fill" style="width: <?php echo min($level_progress, 100); ?>%"></div>
            </div>
            <p class="level-progress-info">
                <?php echo max(0, 1000 - $points_in_current_level); ?> points until Level <?php echo $user_level + 1; ?>
            </p>
        </div>

        <!-- Quiz History -->
        <div class="quiz-history-section">
            <h2 class="section-title">Recent Quiz Results</h2>

            <?php if (empty($quiz_history)): ?>
                <div class="no-history">
                    <div class="no-history-icon">📚</div>
                    <h3>No Quizzes Completed Yet</h3>
                    <p>Start taking quizzes to see your results here!</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-yellow">Browse Quizzes</a>
                </div>
            <?php else: ?>
                <div class="quiz-history-table-wrapper">
                    <table class="quiz-history-table">
                        <thead>
                            <tr>
                                <th>Quiz</th>
                                <th>Score</th>
                                <th>Accuracy</th>
                                <th>Time</th>
                                <th>Points Earned</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($quiz_history, 0, 20) as $result): ?>
                                <tr>
                                    <td class="quiz-title">
                                        <a href="<?php echo get_permalink($result['quiz_id']); ?>">
                                            <?php echo esc_html($result['quiz_title']); ?>
                                        </a>
                                    </td>
                                    <td class="quiz-score">
                                        <strong><?php echo $result['score']; ?></strong> / <?php echo $result['total_questions']; ?>
                                    </td>
                                    <td class="quiz-accuracy">
                                        <span class="accuracy-badge accuracy-<?php
                                            $percentage = $result['percentage'];
                                            if ($percentage >= 90) echo 'excellent';
                                            elseif ($percentage >= 70) echo 'good';
                                            elseif ($percentage >= 50) echo 'average';
                                            else echo 'poor';
                                        ?>">
                                            <?php echo $result['percentage']; ?>%
                                        </span>
                                    </td>
                                    <td class="quiz-time">
                                        <?php
                                        $minutes = floor($result['time_taken'] / 60);
                                        $seconds = $result['time_taken'] % 60;
                                        echo sprintf('%02d:%02d', $minutes, $seconds);
                                        ?>
                                    </td>
                                    <td class="quiz-points">
                                        <span class="points-earned">+<?php echo number_format($result['points_earned']); ?></span>
                                    </td>
                                    <td class="quiz-date">
                                        <?php echo date('M j, Y', $result['timestamp']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (count($quiz_history) > 20): ?>
                    <p class="history-note">Showing 20 most recent results out of <?php echo count($quiz_history); ?> total</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="profile-actions">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-yellow">Take More Quizzes</a>
            <a href="<?php echo home_url('/rankings'); ?>" class="btn btn-outline-purple">View Rankings</a>
        </div>
    </div>
</div>

<?php
get_footer();
