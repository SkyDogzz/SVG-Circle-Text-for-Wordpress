<?php
/*
Plugin Name: SVG Circle Text
Description: Ce plugin ajoute un SVG avec du texte courbé sur un cercle dans votre site WordPress.
Version: 1.0
Author: SkyDogzz
*/

function svg_circle_text_enqueue_scripts() {
  wp_enqueue_style( 'svg-circle-text-style', plugin_dir_url( __FILE__ ) . 'style.css' );
  wp_enqueue_script( 'svg-circle-text-script', plugin_dir_url( __FILE__ ) . 'main.js' );
}

function svg_circle_text_shortcode() {
  ob_start(); ?>
  <svg viewBox="0 0 500 500">
    <path id="circle" fill="aliceblue" d="M250,50 
      A200,200 0 1,1 250,450
      A200,200 0 1,1 250,50 Z" />
    <image x="150" y="150" width="200" height="200" xlink:href="<?php echo plugin_dir_url( __FILE__ ) . 'LOGO.png' ?>" />
    <text>
      <textPath id="textPath1" xlink:href="#circle">
        Texte courbé sur un cercle
      </textPath>
    </text>
    <text>
      <textPath id="textPath2" xlink:href="#circle">
        Deuxième texte courbé sur un cercle avec une longueur plus grande
      </textPath>
    </text>
    <text>
      <textPath id="textPath3" xlink:href="#circle">
        Troisième texte courbé sur un cercle avec une longueur encore plus grande
      </textPath>
    </text>
  </svg>
  <?php
  $output = ob_get_clean();
  return $output;
}

add_action( 'wp_enqueue_scripts', 'svg_circle_text_enqueue_scripts' );
add_shortcode( 'svg-circle-text', 'svg_circle_text_shortcode' );
