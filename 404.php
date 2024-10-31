<?php
/**
 * 404
 *
 * @package WordPress
 * @subpackage inspiretheme
 *
 */

get_header(); ?>

<main role="main">

	<header class="c-page-header">
		<div class="container">
			<h1 class="text-white">Página não encontrada</h1>
		</div>
	</header>

	<div class="container mt-3">
		<?php get_template_part("template-parts/breadcrumbs"); ?>
	</div>

	<div class="pt-5 u-pb-5">
		<div class="container">
			<p class="c-bloco-mensagem c-bloco-mensagem__primary mb-4">
				Ops!<br>
				Esta página não foi encontrada :(
			</p>
			<a href="<?php bloginfo('url'); ?>" title="Página inicial" class="btn btn-secondary">Home</a>
		</div>
	</div>

</main>

<?php get_footer(); ?>
