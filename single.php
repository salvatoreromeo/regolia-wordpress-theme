<?php
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" class="rg-main">
    <div class="rg-container rg-page-layout">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article <?php post_class('rg-article'); ?>>

            <header class="rg-article__header">
                <div class="rg-article__meta">
                    <span class="rg-article__cat">
                        <?php the_category(', '); ?>
                    </span>
                    <span class="rg-article__date">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date()); ?>
                        </time>
                    </span>
                </div>
                <h1 class="rg-article__title"><?php the_title(); ?></h1>
                <div class="rg-article__byline">
                    <?php echo esc_html(get_the_author()); ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="rg-article__cover">
                    <?php the_post_thumbnail('regolia-hero', ['class' => 'rg-article__cover-img', 'loading' => 'eager']); ?>
                </div>
            <?php endif; ?>

            <div class="rg-article__body rg-prose">
                <?php the_content(); ?>
            </div>

            <?php
            wp_link_pages([
                'before' => '<nav class="rg-page-links"><span>' . __('Pagine:', 'regolia') . '</span>',
                'after'  => '</nav>',
            ]);
            ?>

            <footer class="rg-article__footer">
                <div class="rg-article__tags">
                    <?php the_tags('<span class="rg-tag-label">' . __('Tag:', 'regolia') . '</span> ', ', '); ?>
                </div>
                <nav class="rg-article__nav" aria-label="<?php esc_attr_e('Articoli adiacenti', 'regolia'); ?>">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    if ($prev) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="rg-article__nav-link rg-article__nav-link--prev">
                            <span class="rg-article__nav-label">&larr; <?php esc_html_e('Precedente', 'regolia'); ?></span>
                            <span class="rg-article__nav-title"><?php echo esc_html(get_the_title($prev)); ?></span>
                        </a>
                    <?php endif;
                    if ($next) : ?>
                        <a href="<?php echo esc_url(get_permalink($next)); ?>" class="rg-article__nav-link rg-article__nav-link--next">
                            <span class="rg-article__nav-label"><?php esc_html_e('Successivo', 'regolia'); ?> &rarr;</span>
                            <span class="rg-article__nav-title"><?php echo esc_html(get_the_title($next)); ?></span>
                        </a>
                    <?php endif; ?>
                </nav>
            </footer>

        </article>

        <?php endwhile; endif; ?>

    </div>
</main>

<?php get_footer(); ?>
