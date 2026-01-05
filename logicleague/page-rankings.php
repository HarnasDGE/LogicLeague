<?php
/**
 * Template Name: Rankings
 *
 * @package LogicLeague
 */

get_header();

// Get all users with points, sorted by total_points
global $wpdb;

$rankings = $wpdb->get_results("
    SELECT
        u.ID,
        u.display_name,
        um.meta_value as total_points
    FROM {$wpdb->users} u
    INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id
    WHERE um.meta_key = 'total_points'
    AND CAST(um.meta_value AS UNSIGNED) > 0
    ORDER BY CAST(um.meta_value AS UNSIGNED) DESC
    LIMIT 100
");

$current_user_id = get_current_user_id();

?>

<div class="rankings-page">
    <div class="container">
        <!-- Rankings Header -->
        <div class="rankings-header">
            <h1 class="rankings-title">
                <span class="rankings-icon">🏆</span>
                Top Players Leaderboard
            </h1>
            <p class="rankings-subtitle">
                See where you rank among the best minds in LogicLeague
            </p>

            <?php if (is_user_logged_in()):
                $user_rank = logicleague_get_user_rank($current_user_id);
                $user_points = get_user_meta($current_user_id, 'total_points', true);
                $user_points = $user_points ? intval($user_points) : 0;
            ?>
                <div class="your-rank-card">
                    <div class="your-rank-content">
                        <div class="your-rank-label">Your Rank</div>
                        <div class="your-rank-number">#<?php echo $user_rank; ?></div>
                    </div>
                    <div class="your-rank-points">
                        <strong><?php echo number_format($user_points); ?></strong> points
                    </div>
                    <a href="<?php echo home_url('/profile'); ?>" class="btn-view-profile">View Profile →</a>
                </div>
            <?php else: ?>
                <div class="login-prompt">
                    <p>Log in to see your rank and compete with others!</p>
                    <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn btn-yellow">Sign In</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Rankings Table -->
        <div class="rankings-list">
            <?php if (empty($rankings)): ?>
                <div class="no-rankings">
                    <div class="no-rankings-icon">📊</div>
                    <h3>No Rankings Yet</h3>
                    <p>Be the first to complete quizzes and climb the leaderboard!</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-yellow">Start Quiz</a>
                </div>
            <?php else: ?>
                <?php foreach ($rankings as $index => $user):
                    $rank = $index + 1;
                    $is_current_user = $current_user_id == $user->ID;

                    // Get additional user stats
                    $user_level = get_user_meta($user->ID, 'user_level', true);
                    $user_level = $user_level ? intval($user_level) : 1;

                    $quizzes_completed = get_user_meta($user->ID, 'quizzes_completed', true);
                    $quizzes_completed = $quizzes_completed ? intval($quizzes_completed) : 0;

                    $rank_class = '';
                    if ($rank == 1) $rank_class = 'rank-1';
                    elseif ($rank == 2) $rank_class = 'rank-2';
                    elseif ($rank == 3) $rank_class = 'rank-3';
                    elseif ($is_current_user) $rank_class = 'rank-current-user';
                ?>
                    <div class="rank-card <?php echo $rank_class; ?>">
                        <div class="rank-position">
                            <?php if ($rank == 1): ?>
                                <span class="trophy gold">🥇</span>
                            <?php elseif ($rank == 2): ?>
                                <span class="trophy silver">🥈</span>
                            <?php elseif ($rank == 3): ?>
                                <span class="trophy bronze">🥉</span>
                            <?php else: ?>
                                <span class="rank-number">#<?php echo $rank; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="rank-avatar">
                            <?php echo get_avatar($user->ID, 60); ?>
                        </div>

                        <div class="rank-info">
                            <div class="rank-name">
                                <?php echo esc_html($user->display_name); ?>
                                <?php if ($is_current_user): ?>
                                    <span class="you-badge">You</span>
                                <?php endif; ?>
                            </div>
                            <div class="rank-stats">
                                <span class="rank-stat">
                                    <span class="stat-icon">⚡</span>
                                    Level <?php echo $user_level; ?>
                                </span>
                                <span class="rank-stat">
                                    <span class="stat-icon">📝</span>
                                    <?php echo $quizzes_completed; ?> Quizzes
                                </span>
                            </div>
                        </div>

                        <div class="rank-points">
                            <div class="points-value"><?php echo number_format($user->total_points); ?></div>
                            <div class="points-label">points</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Call to Action -->
        <?php if (!empty($rankings)): ?>
            <div class="rankings-cta">
                <h3>Ready to Climb the Ranks?</h3>
                <p>Take more quizzes to earn points and improve your ranking!</p>
                <a href="<?php echo home_url('/'); ?>" class="btn btn-yellow">Start Quiz</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
