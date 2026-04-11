<?php
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" class="rg-main">
    <div class="rg-container rg-page-layout">

        <article <?php post_class('rg-article'); ?>>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="rg-article__cover">
                        <?php the_post_thumbnail('regolia-hero', ['class' => 'rg-article__cover-img', 'loading' => 'eager']); ?>
                    </div>
                <?php endif; ?>

                <header class="rg-article__header">
                    <h1 class="rg-article__title"><?php the_title(); ?></h1>
                </header>

                <div class="rg-article__body rg-prose">
                    <?php the_content(); ?>
                </div>

                <?php
                wp_link_pages([
                    'before' => '<nav class="rg-page-links"><span>' . __('Pagine:', 'regolia') . '</span>',
                    'after'  => '</nav>',
                ]);
                ?>

            <?php endwhile; endif; ?>

        </article>

    </div>
</main>

<?php get_footer(); ?>
