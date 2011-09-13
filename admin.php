<?php
// create custom plugin settings menu
add_action('admin_menu', 'privy_admin_menu');
privy_admin_warnings();


function privy_admin_warnings() {
  if (!get_option('privy_merchant_id')) {
    function privy_warning() {
      echo "<div id='privy-warning' class='updated fade'><p><strong>".__('Privy is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">enter your Privy Merchant ID</a> for it to work.'), "plugins.php?page=privy-config")."</p></div>";
    }
    add_action('admin_notices', 'privy_warning');
  }
}


function privy_admin_menu() {
	add_submenu_page('plugins.php', 'Privy Configuration', 'Privy Configuration', 'manage_options', 'privy-config', 'privy_settings_page');
  add_action( 'admin_init', 'register_privy_settings' );
}

function register_privy_settings() {
  register_setting( 'privy-config', 'privy_merchant_id' );
  add_settings_section('privy-settings', 'Privy Settings', 'privy_settings_text', 'privy');
  add_settings_field('privy_merchant_id', 'Merchant ID', 'privy_merchant_id_setting', 'privy', 'privy-settings');
}

function privy_settings_text() {
  echo '<p>Main description of this section here.</p>';
}

function privy_merchant_id_setting() {
  echo "<input name='privy_merchant_id' size='40' type='text' value='". get_option('privy_merchant_id') ."' />";
}

function privy_settings_page() {
?>
<div class="wrap">
  <h2>Privy Widget Loader</h2>

  <form method="post" action="options.php">
    <?php settings_fields( 'privy-config' ); ?>
    <?php do_settings_sections('privy'); ?>

    <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
  </form>
</div>
<?php } ?>