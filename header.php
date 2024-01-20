<?php
/**
 * NMota header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<!-- body_class() = class="page page-id-2 page-parent page-template-default logged-in" -->
<body <?php body_class(); ?>>
    <header id="masthead" class="site-header">
        <div class="site-logo">
		
        </div>
        <nav id="site-navigation" class="primary-navigation">
            <div class="menu-button-container">
                <button id="primary-mobile-menu" class="button" aria-controls="primary-menu-list" aria-expanded="false">
                    <span class="dropdown-icon open">
    
                    </span>
                    <span class="dropdown-icon close">
                        
                    </span>
                </button><!-- #primary-mobile-menu -->
            </div><!-- .menu-button-container -->
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'menu_class'      => 'menu-wrapper',
                    'container_class' => 'primary-menu-container',
                    'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
                    'fallback_cb'     => false,
                )
            );
            ?>
        </nav><!-- #site-navigation -->
    </header><!-- #masthead -->
	<main id="main" class="site-main">
