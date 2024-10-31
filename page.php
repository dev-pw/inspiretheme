<?php
/**
 * Page
 *
 * @package WordPress
 * @subpackage inspiretheme
 *
 */

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

			<?php if (have_posts()):while (have_posts()):the_post(); ?>
			<article id="article-id-<?php the_id(); ?>" <?php post_class(); ?>>
				<div class="entry-content-post">
					<?php the_content(); ?>
				</div>
			</article>
			<?php endwhile; endif; ?>

		</div>
	</div>

</main>

<?php get_footer(); ?>
