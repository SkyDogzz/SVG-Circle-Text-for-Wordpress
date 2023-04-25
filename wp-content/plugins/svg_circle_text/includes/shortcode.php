<?php
function svg_circle_text_shortcode($atts, $content = null)
{
  global $ip;

  // Récupérer l'état actuel des options
  $enable_background = get_option('svg_circle_text_enable_background', true);
  $background_color = get_option('svg_circle_text_background_color', 'aliceblue');
  $background_opacity = get_option('svg_circle_text_background_opacity', '1.0');
  $num_texts = get_option('svg_circle_text_num_texts', '3');
  $texts = array();
  $logo_size = get_option('svg_circle_text_logo_size', '200');


  // Récupérer les textes courbés sur le cercle
  for ($i = 1; $i <= $num_texts; $i++) {
    $texts[] = get_option('svg_circle_text_text_' . $i, 'Texte courbé sur un cercle');
  }

  // Récupérer les autres paramètres
  $font_char = get_option('svg_circle_text_char_size', '16');
  $font_family = get_option('svg_circle_text_font_family', 'Arial');
  $letter_spacing = get_option('svg_circle_text_letter_spacing', '0');
  $font_weight = get_option('svg_circle_text_font_weight', 'normal');

  $circle_size = get_option('svg_circle_text_circle_size', '200');
  //donne moi la formule svg pour un cercle de diametre $circle_size

  ob_start(); ?>
  <div class="svg-container" style="max-width:<?php echo $circle_size ?>px;">
	  <?php   echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
	<svg viewBox="0 0 500 500" width="<?php echo $circle_size ?>px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <path id="circle" fill="<?php echo $enable_background ? $background_color : 'transparent'; ?>" fill-opacity="<?php echo $background_opacity; ?>" d="M250,50 
            A200,200 0 1,1 250,450
            A200,200 0 1,1 250, 50 Z" />
		  <a href="https://www.google.com/maps/place/One+conciergerie/@48.8780703,2.286654,17z/data=!4m16!1m9!3m8!1s0x47e66f5c8ea1a01b:0x55802d3a7b6e6663!2sOne+conciergerie!8m2!3d48.8780703!4d2.2888427!9m1!1b1!16s%2Fg%2F11n6rkz5dk!3m5!1s0x47e66f5c8ea1a01b:0x55802d3a7b6e6663!8m2!3d48.8780703!4d2.2888427!16s%2Fg%2F11n6rkz5dk" target="_blank">
      <image x="<?php echo 250 - $logo_size / 2; ?>" y="<?php echo 250 - $logo_size / 2; ?>" width="<?php echo $logo_size; ?>" height="<?php echo $logo_size; ?>" xlink:href="<?php echo str_replace('localhost', $ip, esc_attr(get_option('svg_circle_text_logo'))) ?>" />
		</a>
      <?php
      // Afficher les textes courbés sur le cercle
      for ($i = 0; $i < $num_texts; $i++) {
      ?>
        <text font-size="<?php echo $font_char; ?>" font-family="<?php echo $font_family; ?>" letter-spacing="<?php echo $letter_spacing; ?>" font-weight="<?php echo $font_weight; ?>">
          <textPath id="textPath<?php echo $i + 1; ?>" xlink:href="#circle" startOffset="<?php echo ($i * 100) / $num_texts; ?>%">
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