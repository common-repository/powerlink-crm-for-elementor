<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

/**
 * form powerlink action for Elementor.
 *
 * Custom Elementor form action which adds new subscriber to powerlink after form submission.
 *
 * @since 1.0.0
 */
class Powerlink_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base
{
    // 18b39c29e-8dee-4817-8684-f24dfce4cb071
    /**
     * Get action name.
     *
     * Retrieve powerlink action name.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_name()
    {
        return 'powerlink';
    }
    
    /**
     * Get action label.
     *
     * Retrieve powerlink action label.
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public function get_label()
    {
        return esc_html__( 'Powerlink', 'forms-powerlink-action-for-elementor' );
    }
    
    public function getToken()
    {
        $powerlink_crm_options = get_option( 'powerlink_crm_option_name' );
        // Array of All Options
        $TokenID = $powerlink_crm_options['token_id_0'];
        // Token ID
        return $TokenID;
    }
    
    /**
     * Register action controls.
     *
     * Add input fields to allow the user to customize the action settings.
     *
     * @since 1.0.0
     * @access public
     * @param \Elementor\Widget_Base $widget
     */
    public function register_settings_section( $widget )
    {
        //$API_URL = 'https://api.powerlink.co.il/';
        //$TokenID ='18b39c29e-8dee-4817-8684-f24dfce4cb071';
        $widget->start_controls_section( 'section_powerlink', [
            'label'     => esc_html__( 'Powerlink', 'forms-powerlink-action-for-elementor' ),
            'condition' => [
            'submit_actions' => $this->get_name(),
        ],
        ] );
        $records_typs = [];
        $tok = $this->getToken();
        $response = wp_remote_get( 'https://api.powerlink.co.il/metadata/records?tokenid=' . $tok );
        
        if ( is_array( $response ) && !is_wp_error( $response ) ) {
            $headers = $response['headers'];
            // array of http header lines
            //$body    = $response['body']; // use the content
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body );
        $records_typs['1'] = 'לקוחות';
        $widget->add_control( 'object_type', [
            'label'   => esc_html__( 'Object', 'forms-powerlink-action-for-elementor' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => $records_typs,
        ] );
        // $widget->add_control(
        //     'custom_field',
        //     [
        //         'label' => esc_html__( 'Custom Fields?', 'forms-powerlink-action-for-elementor' ),
        //         'type' => \Elementor\Controls_Manager::SWITCHER,
        //     ]
        // );
        // $widget->add_control(
        // 	'powerlink_email_field',
        // 	[
        // 		'label' => esc_html__( 'Email Field ID', 'forms-powerlink-action-for-elementor' ),
        // 		'type' => \Elementor\Controls_Manager::TEXT,
        // 		'dynamic' => [
        // 			'active' => true,
        // 		],
        //         'condition' => [
        //             'custom_field' => 'yes',
        //         ],
        // 	]
        // );
        // $widget->add_control(
        // 	'powerlink_name_field',
        // 	[
        // 		'label' => esc_html__( 'Name Field ID', 'forms-powerlink-action-for-elementor' ),
        // 		'type' => \Elementor\Controls_Manager::TEXT,
        // 		'dynamic' => [
        // 			'active' => true,
        // 		],
        //         'condition' => [
        //             'custom_field' => 'yes',
        //         ],
        // 	]
        // );
        $widget->end_controls_section();
    }
    
    /**
     * Run action.
     *
     * Runs the powerlink action after form submission.
     *
     * @since 1.0.0
     * @access public
     * @param \ElementorPro\Modules\Forms\Classes\Form_Record  $record
     * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
     */
    public function run( $record, $ajax_handler )
    {
        $settings = $record->get( 'form_settings' );
        // //  Make sure that there is a powerlink installation URL.
        // if ( empty( $settings['powerlink_url'] ) ) {
        // 	return;
        // }
        // //  Make sure that there is a powerlink list ID.
        // if ( empty( $settings['powerlink_list'] ) ) {
        // 	return;
        // }
        // // Make sure that there is a powerlink email field ID (required by powerlink to subscribe users).
        // if ( empty( $settings['powerlink_email_field'] ) ) {
        // 	return;
        // }
        // // Get submitted form data.
        $raw_fields = $record->get( 'fields' );
        // Normalize form data.
        $fields = [];
        foreach ( $raw_fields as $id => $field ) {
            $fields[$id] = $field['value'];
        }
        // // Make sure the user entered an email (required by powerlink to subscribe users).
        // if ( empty( $fields[ $settings['email'] ] ) ) {
        // 	return;
        // }
        // Request data based on the param list at https://powerlink.co.il
        // $powerlink_data = [
        // 	'emailaddress1' => $fields['email'],
        // 	'telephone1' => $fields['phone']
        // 	//'list' => $settings['powerlink_list'],
        // 	//'ipaddress' => \ElementorPro\Core\Utils::get_client_ip(),
        // 	//'referrer' => isset( $_POST['referrer'] ) ? $_POST['referrer'] : '',
        // ];
        foreach ( $fields as $key => $value ) {
            $powerlink_data[$key] = $value;
        }
        // Add name if field is mapped.
        // if ( !empty( $settings['powerlink_name_field'] ) ) {
        // 	$powerlink_data[$settings['powerlink_name_field']] = $fields['name'] ;
        // }
        // else{
        //     $powerlink_data['accountname'] = $fields['name'] ;
        // }
        // Send the request.
        wp_remote_post(
            //'https://webhook.site/5dd03669-ab22-429c-967b-8d7b48be72ac/?tokenid=' . $this->getToken(),
            //$API_URL,
            'https://api.powerlink.co.il/api/record/' . $settings['object_type'] . '/?tokenid=' . $this->getToken(),
            [
                'method'      => 'POST',
                'headers'     => [
                'Content-Type' => 'application/json',
            ],
                'body'        => wp_json_encode( $powerlink_data ),
                'httpversion' => '1.0',
                'timeout'     => 60,
            ]
        );
    }
    
    /**
     * On export.
     *
     * Clears powerlink form settings/fields when exporting.
     *
     * @since 1.0.0
     * @access public
     * @param array $element
     */
    public function on_export( $element )
    {
        unset(
            $element['powerlink_url'],
            $element['powerlink_list'],
            $element['powerlink_email_field'],
            $element['powerlink_name_field']
        );
        return $element;
    }

}