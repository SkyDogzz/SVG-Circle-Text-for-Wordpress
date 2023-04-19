<?php
/*
Plugin Name: SVG Circle Text
Description: Ce plugin ajoute un SVG avec du texte courbé sur un cercle dans votre site WordPress.
Version: 1.0
Author: SkyDogzz
*/

function svg_circle_text_enqueue_scripts()
{
  wp_enqueue_style('svg-circle-text-style', plugin_dir_url(__FILE__) . 'style.css');
  wp_enqueue_script('svg-circle-text-script', plugin_dir_url(__FILE__) . 'main.js');
}

function svg_circle_text_shortcode($atts, $content = null)
{
  $enable_background = get_option('svg_circle_text_enable_background', true);
  $background_color = get_option('svg_circle_text_background_color', 'aliceblue');
  $background_opacity = get_option('svg_circle_text_background_opacity', '1.0');
  ob_start(); ?>
  <div class="svg-container">
    <svg viewBox="0 0 500 500">
      <path id="circle" fill="<?php echo $enable_background ? $background_color : 'transparent'; ?>" fill-opacity="<?php echo $enable_background ? $background_opacity : '0'; ?>" d="M250,50 
          A200,200 0 1,1 250,450
          A200,200 0 1,1 250,50 Z" />
      <image x="150" y="150" width="200" height="200" xlink:href="<?php echo plugin_dir_url(__FILE__) . 'LOGO.png' ?>" />
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
          Troisième texte courbé sur un cercle pas trop grand
        </textPath>
      </text>
    </svg>
  </div>
<?php
  $output = ob_get_clean();
  return $output;
}
add_shortcode('svg-circle-text', 'svg_circle_text_shortcode');

add_action('wp_enqueue_scripts', 'svg_circle_text_enqueue_scripts');
add_shortcode('svg-circle-text', 'svg_circle_text_shortcode');

function svg_circle_text_add_admin_page()
{
  add_menu_page(
    'SVG Circle Text Settings',
    'SVG Circle Text',
    'manage_options',
    'svg_circle_text_settings',
    'svg_circle_text_settings_page',
    'dashicons-admin-generic',
    75
  );
}
add_action('admin_menu', 'svg_circle_text_add_admin_page');

function svg_circle_text_settings_page()
{
  // Récupérer l'état actuel de la case à cocher
  $enable_background = get_option('svg_circle_text_enable_background', true);
  $background_color = get_option('svg_circle_text_background_color', 'aliceblue');
  $background_opacity = get_option('svg_circle_text_background_opacity', '1.0');
?>
  <div class="wrap">
    <h1>SVG Circle Text Settings</h1>
    <form method="post" action="">
      <label>
        <input type="checkbox" name="enable_background" <?php echo $enable_background ? 'checked' : ''; ?>>
        Enable background
      </label>
      <br>
      <label>
        Background color:
        <input type="color" name="background_color" value="<?php echo $background_color; ?>">
      </label>
      <br>
      <label>
        Background opacity:
        <input type="number" step="0.1" min="0" max="1" name="background_opacity" value="<?php echo $background_opacity; ?>">
      </label>
      <p><input type="submit" value="Save Changes"></p>
    </form>
  </div>
<?php
}

function svg_circle_text_settings_page_save()
{
  if (isset($_POST['enable_background'])) {
    update_option('svg_circle_text_enable_background', $_POST['enable_background']);
  }

  if (isset($_POST['background_color'])) {
    update_option('svg_circle_text_background_color', $_POST['background_color']);
  }

  if (isset($_POST['background_opacity'])) {
    update_option('svg_circle_text_background_opacity', $_POST['background_opacity']);
  }
}

add_action('admin_menu', 'svg_circle_text_add_admin_page');
add_action('admin_init', 'svg_circle_text_settings_page_save');
