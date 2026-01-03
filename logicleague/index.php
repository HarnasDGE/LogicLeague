<?php
/**
 * Główny plik szablonu
 *
 * @package LogicLeague
 */

get_header();
?>

<!-- Sekcja CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h1 class="cta-title">Rozwijaj swoją logikę z LogicLeague</h1>
            <p class="cta-description">Dołącz do społeczności i rozpocznij swoją przygodę z programowaniem już dziś!</p>
            <div class="cta-buttons">
                <a href="#" class="btn btn-primary">Rozpocznij teraz</a>
                <a href="#" class="btn btn-outline">Dowiedz się więcej</a>
            </div>
        </div>
    </div>
</section>

<!-- Sekcja z postami -->
<section class="recent-posts">
    <div class="container">
        <h2 class="section-title">Wszystkie wpisy</h2>

        <div class="posts-grid">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article class="post-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-author">przez <?php the_author(); ?></span>
                            </div>

                            <h3 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more">
                                Czytaj więcej →
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;

                // Paginacja
                ?>
                <div class="pagination-wrapper">
                    <?php the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '← Poprzednie',
                        'next_text' => 'Następne →',
                    ) ); ?>
                </div>
                <?php
            else :
                ?>
                <p>Brak wpisów do wyświetlenia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
