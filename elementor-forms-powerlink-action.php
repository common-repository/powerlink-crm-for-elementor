<?php

/**
 * Plugin Name: PowerLink CRM for Elementor
 * Description: Custom addon which adds new subscriber to  Fireberry (Powerlink) CRM after form submission.
 * Plugin URI:  https://powerlink.co.il
 * Version:     1.0.0
 * Author:      Ido Navarro
 * Author URI:  https://wpnavarro.com
 * Text Domain: powerlink-action-for-elementor
 *
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */

if ( !function_exists( 'elp' ) ) {
    // Create a helper function for easy SDK access.
    function elp()
    {
        global  $elp ;
        
        if ( !isset( $elp ) ) {
            // Activate multisite network integration.
            if ( !defined( 'WP_FS__PRODUCT_11258_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_11258_MULTISITE', true );
            }
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $elp = fs_dynamic_init( array(
                'id'             => '11258',
                'slug'           => 'powerlink-elementor-form',
                'type'           => 'plugin',
                'public_key'     => 'pk_6cc0bc418a9c6f74e1fe9ac5690ba',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                'days'               => 7,
                'is_require_payment' => false,
            ),
                'menu'           => array(
                'slug'    => 'powerlink-crm',
                'support' => false,
                'parent'  => array(
                'slug' => 'index.php',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $elp;
    }
    
    // Init Freemius.
    elp();
    // Signal that SDK was initiated.
    do_action( 'elp_loaded' );
}


if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

include_once __DIR__ . '/admin/admin_powerlink.php';
/**
 * Add new subscriber to Powerlink.
 *
 * @since 1.0.0
 * @param ElementorPro\Modules\Forms\Registrars\Form_Actions_Registrar $form_actions_registrar
 * @return void
 */
function add_new_powerlink_form_action( $form_actions_registrar )
{
    include_once __DIR__ . '/form-actions/powerlink.php';
    $form_actions_registrar->register( new Powerlink_Action_After_Submit() );
}

add_action( 'elementor_pro/forms/actions/register', 'add_new_powerlink_form_action' );