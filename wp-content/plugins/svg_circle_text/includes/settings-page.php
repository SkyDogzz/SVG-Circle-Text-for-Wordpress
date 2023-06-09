<?php
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
    $circle_size = get_option('svg_circle_text_circle_size', '200');

    $logo = get_option('svg_circle_text_logo');
    if (isset($_FILES['logo'])) {
        $uploaded_file = $_FILES['logo'];
        if ($uploaded_file['error'] === UPLOAD_ERR_OK) {
            $file_name = basename($uploaded_file['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_exts = array('png', 'jpg', 'jpeg', 'gif');
            if (in_array($file_ext, $allowed_exts)) {
                $upload_overrides = array('test_form' => false);
                $uploaded_file = wp_handle_upload($uploaded_file, $upload_overrides);
                if ($uploaded_file && !isset($uploaded_file['error'])) {
                    $logo = $uploaded_file['url'];
                    update_option('svg_circle_text_logo', $logo);
                }
            }
        }
    }
?>
    <div class="wrap">
        <h1>SVG Circle Text Settings</h1>
        <form method="post" action="" enctype="multipart/form-data">

            <h2>Background</h2>
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

            <h2>Rotation</h2>
            <label>
                Rotation speed (in seconds):
                <input type="number" step="1" min="1" max="120" name="rotation_speed" value="<?php echo $rotation_speed; ?>">
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

            <h2>Texts</h2>
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
            <?php } ?><br>
            <label>
                Character size (in pixels):
                <input type="number" step="1" min="10" max="100" name="char_size" value="<?php echo get_option('svg_circle_text_char_size', '20'); ?>">
            </label>
            <br>
            <label>
                Font family:
                <input type="text" name="font_family" value="<?php echo get_option('svg_circle_text_font_family', 'Arial'); ?>">
            </label>
            <br>
            <label>
                Letter spacing (in pixels):
                <input type="number" step="1" min="0" max="50" name="letter_spacing" value="<?php echo get_option('svg_circle_text_letter_spacing', '2'); ?>">
            </label>
            <br>
            <label>
                Text color:
                <input type="color" name="text_color" value="<?php echo get_option('svg_circle_text_text_color', 'black'); ?>">
            </label>
            <br>
            <label>
                Font weight:
                <select name="font_weight">
                    <option value="normal" <?php echo get_option('svg_circle_text_font_weight', 'normal') == 'normal' ? 'selected' : ''; ?>>Normal</option>
                    <option value="bold" <?php echo get_option('svg_circle_text_font_weight', 'normal') == 'bold' ? 'selected' : ''; ?>>Bold</option>
                </select>
            </label>
            <p><input type="submit" name="reset" value="Reset to Default Style"></p>
            <br>

            <h2>Logo</h2>
            <label>
                Circle size:
                <input type="number" step="1" min="100" max="1000" name="circle_size" value="<?php echo $circle_size; ?>">
            </label>
            <br>
            <label>
                Upload logo:
                <input type="file" name="logo" accept="image/*">
                <?php if (get_option('svg_circle_text_logo')) : ?>
                    <br>
                    <img src="<?php echo esc_attr(get_option('svg_circle_text_logo')); ?>" alt="Logo" style="max-width: 150px; margin-top: 10px;">
                <?php endif; ?>
            </label>
            <br>
            <label>
                Logo size (in pixels):
                <input type="number" step="1" min="10" max="500" name="logo_size" value="<?php echo get_option('svg_circle_text_logo_size', '200'); ?>">
            </label>
            <br>
            <p><input type="submit" value="Save Changes"></p>
        </form>
    </div>
<?php
}

function svg_circle_text_settings_page_save()
{
    if (isset($_POST['enable_background'])) {
        update_option('svg_circle_text_enable_background', $_POST['enable_background']);
    } else {
        update_option('svg_circle_text_enable_background', false);
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

    if (isset($_POST['char_size'])) {
        update_option('svg_circle_text_char_size', $_POST['char_size']);
    }

    if (isset($_POST['font_family'])) {
        update_option('svg_circle_text_font_family', $_POST['font_family']);
    }

    if (isset($_POST['letter_spacing'])) {
        update_option('svg_circle_text_letter_spacing', $_POST['letter_spacing']);
    }

    if (isset($_POST['font_weight'])) {
        update_option('svg_circle_text_font_weight', $_POST['font_weight']);
    }

    if (isset($_POST['text_color'])) {
        update_option('svg_circle_text_text_color', $_POST['text_color']);
    }

    if (isset($_POST['circle_size'])) {
        update_option('svg_circle_text_circle_size', $_POST['circle_size']);
    }

    if (isset($_FILES['logo'])) {
        $logo = wp_handle_upload($_FILES['logo'], array('test_form' => false));
        if ($logo && !isset($logo['error'])) {
            update_option('svg_circle_text_logo', $logo['url']);
        }
    }

    if (isset($_POST['logo_size'])) {
        update_option('svg_circle_text_logo_size', $_POST['logo_size']);
    }

    if (isset($_POST['reset'])) {
        svg_circle_text_settings_page_reset();
    }
}
add_action('admin_init', 'svg_circle_text_settings_page_save');

function svg_circle_text_settings_page_reset()
{
  // Réinitialiser les options de style des textes à leur valeur par défaut
  update_option('svg_circle_text_char_size', '16');
  update_option('svg_circle_text_font_family', 'Arial');
  update_option('svg_circle_text_letter_spacing', '0');
  update_option('svg_circle_text_font_weight', 'normal');
  update_option('svg_circle_text_text_color', 'black');

  // Rafraîchir la page
  wp_redirect(admin_url('admin.php?page=svg_circle_text_settings'));
  exit;
}
