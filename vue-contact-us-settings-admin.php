<?php
// This adds it to the WordPress Sidebar
function vue_contactus_add_theme_menu_item() {
    add_menu_page("Vue Contact Us Settings", "Vue Contact Us", "manage_options", "vue-contactus-settings", "vue_contactus_options_page", null, 99);
}

add_action("admin_menu", "vue_contactus_add_theme_menu_item");

// Register all of the settings for the settings page
function vue_contactus_register_settings() {
    //Declare all options and if applicable, the default information
    add_option('vue_contactus_from_email', '');
    add_option('vue_contactus_from_name', '');
    add_option('vue_contactus_sendgrid_key', '');

    //Register all previously declared settings
    register_setting('vue_contactus_options', 'vue_contactus_from_email');
    register_setting('vue_contactus_options', 'vue_contactus_from_name');
    register_setting('vue_contactus_options', 'vue_contactus_sendgrid_key');
}

add_action('admin_init', 'vue_contactus_register_settings');

// Build the theme options page
function vue_contactus_options_page() {
?>
    <div class="wrap">
        <div>
            <h1>Theme Options</h1>
            <form method="post" action="options.php">
                <?php
                //do this before building the inputs for the settings
                settings_fields('vue_contactus_options'); ?>

                <!-- API Keys -->
                <div class="postbox">
                    <h3>Vue Contact US</h3>
                    <div class="inside">
                    <label for="vue_contactus_from_email">From Email Address:</label><br>
                        <input style="width: 50%;"
                                type="text" id="vue_contactus_from_email"
                                name="vue_contactus_from_email"
                                value="<?php echo get_option('vue_contactus_from_email'); ?>" /><br>

                        <label for="vue_contactus_from_name">From Name:</label><br>
                        <input style="width: 50%;"
                                type="text" id="vue_contactus_from_name"
                                name="vue_contactus_from_name"
                                value="<?php echo get_option('vue_contactus_from_name'); ?>" /><br>


                        <label for="vue_contactus_sendgrid_key">Sendgrid Key:</label><br>
                        <input style="width: 100%;"
                                type="text" id="vue_contactus_sendgrid_key"
                                name="vue_contactus_sendgrid_key"
                                value="<?php echo get_option('vue_contactus_sendgrid_key'); ?>" /><br>

                    </div>
                </div>
                <!-- end API Keys -->

                <?php submit_button(); ?>
            </form>
        </div>
    </div>

<?php } //end options page ?>
