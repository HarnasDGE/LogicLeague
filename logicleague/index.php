<?php
/**
 * Główny plik szablonu
 *
 * @package LogicLeague
 */

get_header();
?>

<main>
    <div class="container">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="entry-meta">
                        <p>Opublikowano: <?php the_date(); ?> | Autor: <?php the_author(); ?></p>
                    </div>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>">Czytaj więcej...</a>
                </article>
                <hr>
                <?php
            endwhile;

            // Paginacja
            the_posts_pagination();
        else :
            ?>
            <p>Brak wpisów do wyświetlenia.</p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
