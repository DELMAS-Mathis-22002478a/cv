<?php

class cvchekout_Admin_Shipping
{
    public function add_shipping_form_fields(){
        $shipping_methods = WC()->shipping->get_shipping_methods();
        foreach($shipping_methods as $shipping_method) {
            if( $shipping_method->id != "free_shipping" ){
                add_filter('woocommerce_shipping_instance_form_fields_' . $shipping_method->id, array($this, 'shipping_instance_form_add_extra_fields'));
            }
        }
    }

    public function shipping_instance_form_add_extra_fields($settings){
        $delivery_days_options = array(
            '1' => __('Monday', 'cvchekout'),
            '2' => __('Tuesday', 'cvchekout'),
            '3' => __('Wednesday', 'cvchekout'),
            '4' => __('Thursday', 'cvchekout'),
            '5' => __('Friday', 'cvchekout'),
            '6' => __('Saturday', 'cvchekout'),
            '7' => __('Sunday', 'cvchekout'),
        );

        // Section title
        $settings['cvchekout_display_section'] = array(
            'title' => __('Data to display', 'cvchekout'),
            'type' => 'title',
            'description' => __('Configure here the data displayed on shipping listing', 'cvchekout')
        );
        // Add option to display minimum amount to get free shipping
        $settings['cvchekout_free_shipping_min_amount'] = array(
            'title' => __('Free shipping minimum amount', 'cvchekout'),
            'type' => 'number',
            'placeholder' => '0',
            'desc_tip' => __('Set minimum amount to get free shipping', 'cvchekout')
        );

        // Add option to display shipping method logo
        $settings['cvchekout_shipping_method_logo'] = array(
            'title' => __('Logo id', 'cvchekout'),
            'type' => 'number',
            'placeholder' => '0',
            'desc_tip' => __('Set the media id for this shipping method logo', 'cvchekout')
        );

        // Add option to set business delivery days
        $settings['cvchekout_shipping_method_business_delivery_days'] = array(
            'title' => __('Business delivery days', 'cvchekout'),
            'type' => 'multiselect',
            'options' => $delivery_days_options,
            'desc_tip' => __('Choose the business delivery days', 'cvchekout')
        );

        // Add option to display before shipping method delivery days
        $settings['cvchekout_shipping_method_before_delivery'] = array(
            'title' => __('Before delivery day(s)', 'cvchekout'),
            'type' => 'text',
            'placeholder' => __('Shipping', 'cvchekout'),
            'desc_tip' => __('Set the text before displaying delivery day(s)', 'cvchekout')
        );

        // Add option to display sheduled delivery days
        $settings['cvchekout_shipping_method_scheduled_delivery_start'] = array(
            'title' => __('Delivery scheduled starting for', 'cvchekout'),
            'type' => 'number',
            'placeholder' => '1',
            'default' => 1,
            'custom_attributes' => array( 
                'min' => '0'
            ),
            'desc_tip' => __('Set the scheduled delivery starting number of days', 'cvchekout')
        );

        $settings['cvchekout_shipping_method_scheduled_delivery_end'] = array(
            'title' => __('Delivery scheduled ended at', 'cvchekout'),
            'type' => 'number',
            'placeholder' => '1',
            'default' => 1,
            'custom_attributes' => array( 
                'min' => '0'
            ),
            'desc_tip' => __('Set the scheduled delivery ending number of days', 'cvchekout')
        );

        // Add option to display after shipping method delivery days
        $settings['cvchekout_shipping_method_after_delivery'] = array(
            'title' => __('After delivery day(s)', 'cvchekout'),
            'type' => 'text',
            'placeholder' => __('Shipping', 'cvchekout'),
            'desc_tip' => __('Set the text after displaying delivery day(s)', 'cvchekout')
        );

        return $settings;
    }

}
