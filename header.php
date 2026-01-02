<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header>
    <div class="container">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; text-decoration: none;">
            <?php bloginfo( 'name' ); ?>
        </a></h1>
        <p><?php bloginfo( 'description' ); ?></p>

        <nav>
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
    </div>
</header>
