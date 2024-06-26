<?php
/**
 * Theme Header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package royl-wp-theme-base
 */

use Royl\WpThemeBase\Util;
use Royl\WpThemeBase\Wp;
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div class="site" id="site">
    <a class="skip-link screen-reader-text visually-hidden" href="#main"><?php echo Util\Text::translate( 'Skip to content' ); ?></a>

    <?php Wp\Template::load( 'header/header' ); ?>

    <main class="site__body">