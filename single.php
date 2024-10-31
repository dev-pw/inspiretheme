<?php
/**
 * Single
 *
 * @package WordPress
 * @subpackage inspiretheme
 *
 */

if(get_post_type() == 'custom') :
	get_template_parts('singles/single-custom');
else :

get_header(); ?>

<main role="main">

	<header class="c-page-header">
		<div class="container">
			<h1 class="text-white"><?php the_title(); ?></h1>
		</div>
	</header>

	<div class="container mt-3">
		<?php get_template_part("template-parts/breadcrumbs"); ?>
	</div>

	<div class="pt-5 u-pb-5">

		<div class="container">
			<div class="row gy-5 gx-xl-5">

				<section class="col-xl-8">

					<div class="bg-light border-bottom gx-3 mb-5 p-2 row">
						<div class="col-auto c-post-metadata" style="font-size: 15px;">
							<span class="icon-calendar me-1 text-dark"></span>
							<span class="small">
								<?= get_the_date('d/m/Y'); ?>
							</span>
						</div>
						<?php if (get_the_category()): ?>
						<div class="col-auto c-post-metadata" style="font-size: 15px;">
							<span class="icon-folder me-1 text-dark"></span>
							<?php the_category(', '); ?>
						</div>
						<?php endif; ?>
					</div>

					<?php if (have_posts()): while (have_posts()): the_post(); ?>
					<article id="article-id-<?php the_id(); ?>" <?php post_class(); ?>>
						<div class="entry-content-post">
							<?php the_content(); ?>
						</div>
					</article>
					<?php endwhile; endif; ?>

					<div class="mt-5">
						<?php get_template_part('template-parts/compartilhe'); ?>
					</div>

				</section>

				<aside class="col-xl-4">

					<div class="mb-5">
						<p class="fs-5 fw-bold lh-base mb-3 text-primary">Pesquisar</p>
            			<?php get_search_form(); ?>
					</div>

					<div>
						<p class="fs-5 fw-bold lh-base mb-4 text-primary">Veja também</p>
						<div class="row gy-4">

							<?php
							$id_post = get_the_ID();
							$post_type = get_post_type();
							$args = array(
								'post_type' => '' . $post_type . '',
								'posts_per_page' => 5,
								'post__not_in' => array($id_post),
							);
							query_posts($args);

							if (have_posts()) : while(have_posts()) : the_post(); ?>

							<article id="post-<?= the_id(); ?>" <?php post_class('col-12'); ?>>
								<div class="bg-terciary text-white p-4">
									<a href="<?= the_permalink(); ?>" class="text-decoration-none text-white">
										<h3 class="fs-6 lh-base mb-0">
											<?= the_title(); ?>
										</h3>
									</a>
									<hr>
									<div class="gx-3 row">
										<div class="col-auto" style="font-size: 14px;">
											<span class="icon-calendar me-1 text-white"></span>
											<span class="small">
												<?= get_the_date('d/m/Y'); ?>
											</span>
										</div>
										<?php if (get_the_category()): ?>
											<div class="col-auto c-post-metadata c-post-metadata--light" style="font-size: 14px;">
												<span class="icon-folder me-1 text-white"></span>
												<?php the_category(', '); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</article>

							<?php endwhile; endif;
							wp_reset_query();
							?>

						</div>
					</div>

				</aside>

			</div>
		</div>
	</div>

</main>

<?php get_footer(); endif; ?>
