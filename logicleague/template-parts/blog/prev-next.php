<!-- Previous/Next Navigation -->
<div class="post-navigation">
    <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    ?>

    <?php if ($prev_post): ?>
    <a href="<?php echo get_permalink($prev_post); ?>" class="post-nav-item post-nav-prev">
        <span class="post-nav-label">← Previous Post</span>
        <h4 class="post-nav-title"><?php echo get_the_title($prev_post); ?></h4>
    </a>
    <?php else: ?>
    <div class="post-nav-item post-nav-empty"></div>
    <?php endif; ?>

    <?php if ($next_post): ?>
    <a href="<?php echo get_permalink($next_post); ?>" class="post-nav-item post-nav-next">
        <span class="post-nav-label">Next Post →</span>
        <h4 class="post-nav-title"><?php echo get_the_title($next_post); ?></h4>
    </a>
    <?php else: ?>
    <div class="post-nav-item post-nav-empty"></div>
    <?php endif; ?>
</div>
