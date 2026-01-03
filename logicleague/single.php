<?php
/**
 * Single Post Template
 *
 * @package LogicLeague
 */

get_header();
?>

<?php while (have_posts()): the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

    <!-- Post Hero -->
    <section class="post-hero">
        <div class="container-narrow">
            <div class="post-hero-meta">
                <span class="post-hero-date">
                    <?php echo get_the_date(); ?>
                </span>
                <?php
                $categories = get_the_category();
                if (!empty($categories)): ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"
                   class="post-hero-category">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
                <?php endif; ?>
            </div>

            <h1 class="post-hero-title"><?php the_title(); ?></h1>

            <div class="post-hero-author">
                <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                <div class="post-hero-author-info">
                    <span class="post-hero-author-name">By <?php the_author(); ?></span>
                    <span class="post-hero-reading-time">
                        <?php
                        $content = get_post_field('post_content', get_the_ID());
                        $word_count = str_word_count(strip_tags($content));
                        $reading_time = ceil($word_count / 200);
                        echo $reading_time . ' min read';
                        ?>
                    </span>
                </div>
            </div>

            <?php if (has_post_thumbnail()): ?>
            <div class="post-hero-image">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Post Content -->
    <section class="post-content-section">
        <div class="container">
            <div class="post-layout">
                <!-- Main Content -->
                <main class="post-content">
                    <div class="post-content-inner">
                        <?php the_content(); ?>

                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . __('Pages:', 'logicleague'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>

                    <!-- Tags -->
                    <?php if (has_tag()): ?>
                    <div class="post-tags">
                        <h3>Tags</h3>
                        <?php the_tags('<div class="tags-list">', '', '</div>'); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Social Share -->
                    <?php get_template_part('template-parts/blog/social-share'); ?>

                    <!-- Author Box -->
                    <?php get_template_part('template-parts/blog/author-box'); ?>

                    <!-- Previous/Next Navigation -->
                    <?php get_template_part('template-parts/blog/prev-next'); ?>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()):
                        comments_template();
                    endif;
                    ?>
                </main>

                <!-- Sidebar -->
                <?php get_template_part('template-parts/blog/sidebar'); ?>
            </div>
        </div>
    </section>

</article>

<?php endwhile; ?>

<!-- Newsletter CTA -->
<section class="newsletter-cta-section">
    <div class="container">
        <div class="newsletter-cta-box">
            <h2>Stay Updated with Our Latest Posts!</h2>
            <p>Subscribe to our newsletter and never miss a brain-teasing article.</p>
            <form class="newsletter-cta-form">
                <input type="email" placeholder="Enter your email" class="newsletter-cta-input" required>
                <button type="submit" class="btn btn-purple">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
