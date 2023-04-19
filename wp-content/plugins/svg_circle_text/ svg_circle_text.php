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

  $rotation_speed = get_option('svg_circle_text_rotation_speed', '20');
  $rotation_direction = get_option('svg_circle_text_rotation_direction', 'normal');
  wp_add_inline_style('svg-circle-text-style', "@keyframes rotate { 0% { transform: rotate(0deg); } 50% { transform: rotate(" . ($rotation_direction == 'normal' ? '-180deg' : '180deg') . "); } 100% { transform: rotate(" . ($rotation_direction == 'normal' ? '-360deg' : '360deg') . "); } } .svg-container path, .svg-container text { animation: rotate {$rotation_speed}s linear infinite;}");
}

function svg_circle_text_shortcode($atts, $content = null)
{
  // Récupérer l'état actuel des options
  $enable_background = get_option('svg_circle_text_enable_background', true);
  $background_color = get_option('svg_circle_text_background_color', 'aliceblue');
  $background_opacity = get_option('svg_circle_text_background_opacity', '1.0');
  $rotation_speed = get_option('svg_circle_text_rotation_speed', '20');  
  $rotation_direction = get_option('svg_circle_text_rotation_direction', 'normal');
  $num_texts = get_option('svg_circle_text_num_texts', '3');
  $texts = array();

  // Récupérer les textes courbés sur le cercle
  for ($i = 1; $i <= $num_texts; $i++) {
    $texts[] = get_option('svg_circle_text_text_' . $i, 'Texte courbé sur un cercle');
  }

  ob_start(); ?>
  <div class="svg-container">
    <svg viewBox="0 0 500 500">
      <path id="circle" fill="<?php echo $enable_background ? $background_color : 'transparent'; ?>" fill-opacity="<?php echo $background_opacity; ?>" d="M250,50 
            A200,200 0 1,1 250,450
            A200,200 0 1,1 250,50 Z" />
      <image x="150" y="150" width="200" height="200" xlink:href="<?php echo plugin_dir_url(__FILE__) . 'LOGO.png' ?>" />
      <?php
      // Afficher les textes courbés sur le cercle
      for ($i = 0; $i < $num_texts; $i++) {
      ?>
        <text>
          <textPath id="textPath<?php echo $i + 1; ?>" xlink:href="#circle">
            <?php echo $texts[$i]; ?>
          </textPath>
        </text>
      <?php } ?>
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
  // Récupérer l'état actuel des options
  $enable_background = get_option('svg_circle_text_enable_background', true);
  $background_color = get_option('svg_circle_text_background_color', 'aliceblue');
  $background_opacity = get_option('svg_circle_text_background_opacity', '1.0');
  $rotation_direction = get_option('svg_circle_text_rotation_direction', 'normal');
  $rotation_speed = get_option('svg_circle_text_rotation_speed', '20');
  $num_texts = get_option('svg_circle_text_num_texts', '3');
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
      <br>
      <label>
        Rotation speed (in seconds):
        <input type="number" step="1" min="10" max="120" name="rotation_speed" value="<?php echo $rotation_speed; ?>">
      </label>
      <br>
      <label>
        Rotation direction:
        <select name="rotation_direction">
          <option value="normal" <?php echo $rotation_direction == 'normal' ? 'selected' : ''; ?>>Normal</option>
          <option value="reverse" <?php echo $rotation_direction == 'reverse' ? 'selected' : ''; ?>>Reverse</option>
        </select>
      </label>
      <br>
      <label>
        Number of texts:
        <input type="number" step="1" min="1" name="num_texts" value="<?php echo $num_texts; ?>" onchange="this.form.submit();">
      </label>
      <br>
      <?php
      // Générer les champs de texte dynamiquement en fonction du nombre de textes
      for ($i = 1; $i <= $num_texts; $i++) {
      ?>
        <label>Text <?php echo $i; ?>:
          <input type="text" name="text_<?php echo $i; ?>" value="<?php echo get_option('svg_circle_text_text_' . $i, ''); ?>">
        </label><br>
      <?php } ?>
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

  if (isset($_POST['rotation_speed'])) {
    update_option('svg_circle_text_rotation_speed', $_POST['rotation_speed']);
  }

  if (isset($_POST['num_texts'])) {
    update_option('svg_circle_text_num_texts', $_POST['num_texts']);
  }

  for ($i = 1; $i <= $_POST['num_texts']; $i++) {
    $text_option_name = 'svg_circle_text_text_' . $i;
    if (isset($_POST['text_' . $i])) {
      update_option($text_option_name, $_POST['text_' . $i]);
    } else {
      delete_option($text_option_name);
    }
  }

  if (isset($_POST['rotation_direction'])) {
    update_option('svg_circle_text_rotation_direction', $_POST['rotation_direction']);
  }
}

add_action('admin_menu', 'svg_circle_text_add_admin_page');
add_action('admin_init', 'svg_circle_text_settings_page_save');
