<?php
/**
 * Front-page
 * @package WordPress
 * @subpackage inspiretheme
 *
*/
 get_header(); 

 echo '<main role="main">';
 get_template_part('template-parts/sc-banners');
 get_template_part('template-parts/sc-programa');
//  get_template_part('template-parts/sc-mensagem');
//  get_template_part('template-parts/sc-agenda');
//  get_template_part('template-parts/sc-pacientes');
//  get_template_part('template-parts/sc-noticias');
//  get_template_part('template-parts/sc-associado');   
//  get_template_part('template-parts/sc-apoio');
 echo '</main>';

 get_footer(); ?>

