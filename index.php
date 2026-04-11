<?php
/**
 * Regolia Theme — index.php
 * Fallback template.
 *
 * @package Regolia
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>

<main id="main-content" class="rg-main">
	<div class="rg-container">

		<?php if ( have_posts() ) : ?>
			<div class="rg-posts-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'rg-post-card' ); ?>>

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="rg-post-card__thumb" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'regolia-card', [ 'class' => 'rg-post-card__img', 'loading' => 'lazy' ] ); ?>
							</a>
						<?php endif; ?>

						<div class="rg-post-card__body">
							<div class="rg-post-card__meta">
								<span><?php the_category( ', ' ); ?></span>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
							</div>
							<h2 class="rg-post-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<div class="rg-post-card__excerpt">
								<?php the_excerpt(); ?>
							</div>
							<a href="<?php the_permalink(); ?>" class="rg-btn rg-btn--ghost rg-btn--sm">
								<?php esc_html_e( 'Leggi &rarr;', 'regolia' ); ?>
							</a>
						</div>

					</article>
				<?php endwhile; ?>
			</div>

			<nav class="rg-pagination" aria-label="<?php esc_attr_e( 'Paginazione', 'regolia' ); ?>">
				<?php
				the_posts_pagination( [
					'mid_size'  => 2,
					'prev_text' => '&larr; ' . __( 'Precedente', 'regolia' ),
					'next_text' => __( 'Successivo', 'regolia' ) . ' &rarr;',
				] );
				?>
			</nav>

		<?php else : ?>
			<p class="rg-no-results"><?php esc_html_e( 'Nessun contenuto trovato.', 'regolia' ); ?></p>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
