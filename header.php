<?php
/**
 * Header
 * @package WordPress
 * @subpackage pwtheme
 *
*/
?>
<!DOCTYPE html>
<html class="no-js" lang="<?= language_attributes(); ?>">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta id='getUrl' data-url="<?= bloginfo('url'); ?>">
   <?php wp_head();?>

</head>

<body <?php body_class(); ?> style="overflow-y: hidden;">

<div class="wrapper-site">

<!-- Preload -->
<div id="preload">
   <?php // wp_get_attachment_image( 65, 'full', '' ,['class' => 'img-fluid', 'style' => 'width: 100px']); ?>
</div>
<!-- Preload -->


<header class="l-header-site">

</header>

