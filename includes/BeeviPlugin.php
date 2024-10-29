<?php

require_once BEEVI_PATH.'includes/AnnouncementsWidget.php';
require_once BEEVI_PATH.'includes/EventsWidget.php';

class BeeviPlugin {

    protected $option_name = OPTION_NAME;
    protected $plugin_file_name = BEEVI_FILE;

    public function __construct(){
        register_activation_hook($this->plugin_file_name, array($this, 'activate'));
        register_deactivation_hook($this->plugin_file_name, array($this, 'cleanup'));

		add_action('widgets_init', create_function('', 'return register_widget("AnnouncementsWidget");'));
		add_action('widgets_init', create_function('', 'return register_widget("EventsWidget");'));

        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_notices', array($this, 'admin_notices_action'));
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    // Plugin activation & clean up code
    public function activate(){}
    public function cleanup(){
        delete_option($this->option_name);
    }

    // Register & validate the settings
    public function admin_init(){ register_setting('beevi_options', $this->option_name, array($this, 'admin_validate')); }
    public function admin_notices_action(){ settings_errors( 'beevi_options' ); }
	public function admin_validate($input) {
        $valid = array();
        $valid['api_key'] = sanitize_text_field($input['api_key']);	

        if (strlen($valid['api_key']) == 0) {
            add_settings_error(
                    'beevi_options',              // Setting title
                    'api_key_texterror',            // Error ID
                    'Please enter a valid API Key', // Error message
                    'error'                         // Type of message
            );
        } else {
            add_settings_error(
                    'beevi_options',              // Setting title
                    null,                           // Error ID
                    'Successfully updated',         // Error message
                    'updated'                       // Type of message
            );
        }
        return $valid;
    }

    // Registers & displays the admin setting page
    public function admin_menu(){ add_menu_page('Beevi', 'Beevi', 'manage_options', 'beevi', array($this, 'admin_view'), null, '20.35234'); }
	public function admin_view() {
        $options = get_option($this->option_name);
        ?>
            <div class="wrap">
            	<h2>Beevi</h2>
            	<form method="post" action="options.php">
                    <?php settings_fields('beevi_options'); ?>
                    <table class="form-table">
                        <tr valign="top"><th scope="row">API Key:</th>
                            <td><input type="text" name="<?php echo $this->option_name?>[api_key]" value="<?php echo $options['api_key']; ?>" class="regular-text"/ placeholder="API Key"></td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </p>
                </form>
            </div>
	   <?php 
    }
}
?>