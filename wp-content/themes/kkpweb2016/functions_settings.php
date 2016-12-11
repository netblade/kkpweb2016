<?php
class KKPWeb2016SettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'KKPWeb Asetukset',
            'KKPWeb Asetukset',
            'manage_options',
            'kkpweb2016_settings_admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'kkpweb2016_settings_template' );
?>
<div class="wrap">
    <h2>KKPWeb Asetukset</h2>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'kkpweb2016_settings_group' );
        do_settings_sections( 'kkpweb2016_settings_admin' );
        submit_button();
        ?>
    </form>
</div>
<?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'kkpweb2016_settings_group', // Option group
            'kkpweb2016_settings_template', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );



        for ($i = 0; $i < 3; $i++) {
            add_settings_section(
                'kkpweb2016_settings_group_section_'.$i, // ID
                'Yl&auml;osan linkki '.($i+1).'', // Title
                null, // Callback
                'kkpweb2016_settings_admin' // Page
            );
            add_settings_field(
                'kkpweb2016_settings_template_header_link_'.$i.'_page', // ID
                'Linkki '.($i+1).'', // Title
                array( $this, 'pagelink_callback' ), // Callback
                'kkpweb2016_settings_admin', // Page
                'kkpweb2016_settings_group_section_'.$i, // Section
                array('field_name' => 'kkpweb2016_settings_template_header_link_'.$i.'_page')
            );

            add_settings_field(
                'kkpweb2016_settings_template_header_link_'.$i.'_title', // ID
                'Linkki '.($i+1).' teksti', // Title
                array( $this, 'title_callback' ), // Callback
                'kkpweb2016_settings_admin', // Page
                'kkpweb2016_settings_group_section_'.$i, // Section
                array('field_name' => 'kkpweb2016_settings_template_header_link_'.$i.'_title')
            );
        }


        add_settings_section(
            'kkpweb2016_settings_frontpage_boxes', // ID
            'Etusivun laatikot', // Title
            null, // Callback
            'kkpweb2016_settings_admin' // Page
        );
        add_settings_field(
            'kkpweb2016_settings_frontpage_boxes_events', // ID
            'Tapahtumat', // Title
            array( $this, 'pagelink_callback' ), // Callback
            'kkpweb2016_settings_admin', // Page
            'kkpweb2016_settings_frontpage_boxes', // Section
            array('field_name' => 'kkpweb2016_settings_frontpage_boxes_events')
        );
        add_settings_field(
            'kkpweb2016_settings_frontpage_boxes_meetings', // ID
            'Kokoukset', // Title
            array( $this, 'pagelink_callback' ), // Callback
            'kkpweb2016_settings_admin', // Page
            'kkpweb2016_settings_frontpage_boxes', // Section
            array('field_name' => 'kkpweb2016_settings_frontpage_boxes_meetings')
        );
        add_settings_field(
            'kkpweb2016_settings_frontpage_boxes_news', // ID
            'Uutiset', // Title
            array( $this, 'pagelink_callback' ), // Callback
            'kkpweb2016_settings_admin', // Page
            'kkpweb2016_settings_frontpage_boxes', // Section
            array('field_name' => 'kkpweb2016_settings_frontpage_boxes_news')
        );


    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        $new_input = array();

        foreach ($input as $input_key => $input_value) {
            $new_input[$input_key] = sanitize_text_field($input_value);

            if (substr($input_key, -5) == '_page') {
                $new_input[$input_key] = absint($input_value);
            }

        }


        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Headering linkit ja sen semmoset';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function pagelink_callback($args)
    {

        $wp_dropdown_pages_args = array(
            'depth'                 => 0,
            'child_of'              => 0,
            'selected'              => isset( $this->options[$args['field_name']] ) ? esc_attr( $this->options[$args['field_name']]) : '',
            'echo'                  => 1,
            'name'                  => 'kkpweb2016_settings_template['.$args['field_name'].']',
            'id'                    => 'kkpweb2016_settings_template_'.$args['field_name'],
            'class'                 => null, // string
            'show_option_none'      => null, // string
            'show_option_no_change' => null, // string
            'option_none_value'     => null, // string
        );

        wp_dropdown_pages( $wp_dropdown_pages_args );

    }

    /**
     * Get the settings option array and print one of its values
     */
    public function title_callback($args)
    {
        printf(
            '<input type="text" id="kkpweb2016_settings_template_'.$args['field_name'].'" name="kkpweb2016_settings_template['.$args['field_name'].']" value="%s" />',
            isset( $this->options[$args['field_name']] ) ? esc_attr( $this->options[$args['field_name']]) : ''
        );
    }

}

if( is_admin() ) {
    $kkpweb2016SettingsPage = new KKPWeb2016SettingsPage();
}