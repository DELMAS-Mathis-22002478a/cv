<?php

class cvchekout_Public_Checkout
{
    public function reorganise_checkout_fields( $checkout_fields )
    {
        $checkout_fields = $this->edit_checkout_email_field($checkout_fields);
       /* $checkout_fields = $this->add_checkout_newsletter_field($checkout_fields);*/
        $checkout_fields = $this->edit_checkout_phone_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_first_name_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_last_name_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_company_field($checkout_fields);
       $checkout_fields = $this->edit_checkout_country_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_address_1_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_address_2_field($checkout_fields);

        $checkout_fields = $this->edit_checkout_postcode_field($checkout_fields);
        $checkout_fields = $this->edit_checkout_city_field($checkout_fields);
        return $checkout_fields;
    }

    private function edit_checkout_email_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_email']['priority'] = 1;
        $checkout_fields['billing']['billing_email']['placeholder'] = __('Your email address', 'cvchekout');
        $checkout_fields['billing']['billing_email']['class'] = array('form-row-half', 'cvchekout-field');
        return $checkout_fields;
    }


    /*
    private function add_checkout_newsletter_field($checkout_fields){
        $new_field = array(
            'label' => __('Keep me aware of news and offers', 'cvchekout'),
            'type' => 'checkbox',
            'class' => array('billing_field', 'cvchekout-field'),
            'priority' => 2
        );
        $checkout_fields['billing']['billing_newsletter'] = $new_field;
        return $checkout_fields;
    }

    */

    private function edit_checkout_phone_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_phone']['priority'] = 5;
        $checkout_fields['billing']['billing_phone']['placeholder'] = __('Phone (mandatory)', 'cvchekout');
        $checkout_fields['billing']['billing_phone']['class'] = array('form-row-half', 'cvchekout-field');
        return $checkout_fields;
    }

    private function edit_checkout_first_name_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_first_name']['placeholder'] = __('First name', 'cvchekout');
        $checkout_fields['billing']['billing_first_name']['class'] = array('form-row-first', 'cvchekout-field');
        $checkout_fields['shipping']['shipping_first_name']['placeholder'] = __('First name', 'cvchekout');
        $checkout_fields['shipping']['shipping_first_name']['class'] = array('form-row-first', 'cvchekout-field');
        return $checkout_fields;
    }

    private function edit_checkout_last_name_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_last_name']['placeholder'] = __('Last name', 'cvchekout');
        $checkout_fields['billing']['billing_last_name']['class'] = array('form-row-last', 'cvchekout-field');
        $checkout_fields['shipping']['shipping_last_name']['placeholder'] = __('Last name', 'cvchekout');
        $checkout_fields['shipping']['shipping_last_name']['class'] = array('form-row-last', 'cvchekout-field');
        return $checkout_fields;
    }

    private function edit_checkout_company_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_company']['placeholder'] = __('Company (optionnal)', 'cvchekout');
        $checkout_fields['billing']['billing_company']['class'] = array('form-row-wide', 'cvchekout-field');
        $checkout_fields['shipping']['shipping_company']['placeholder'] = __('Company (optionnal)', 'cvchekout');
        $checkout_fields['shipping']['shipping_company']['class'] = array('form-row-wide', 'cvchekout-field');
        return $checkout_fields;
    }

    private function edit_checkout_country_field($checkout_fields)
    {   $checkout_fields['billing']['billing_country']['placeholder'] = __('Country', 'cvchekout');
        $checkout_fields['billing']['billing_country']['class'] = array('form-row-half', 'cvchekout-field');
        $checkout_fields['shipping']['shipping_country']['placeholder'] = __('Country', 'cvchekout');
        $checkout_fields['shipping']['shipping_country']['class'] = array('form-row-half', 'cvchekout-field');
        return $checkout_fields;
    }

    private function edit_checkout_address_1_field($checkout_fields)
    {

        $checkout_fields['billing']['billing_address_1']['placeholder'] = __('Address', 'cvchekout');
        $checkout_fields['billing']['billing_address_1']['class'] = array('form-row-half', 'cvchekout-field'); // Updated class
        $checkout_fields['shipping']['shipping_address_1']['placeholder'] = __('Address', 'cvchekout');
        $checkout_fields['shipping']['shipping_address_1']['class'] = array('form-row-half', 'cvchekout-field'); // Updated class
        return $checkout_fields;
    }

    private function edit_checkout_address_2_field($checkout_fields)
    {
        $checkout_fields['billing']['billing_address_2']['placeholder'] = __('Apartment, ... (optional)', 'cvchekout');
        $checkout_fields['billing']['billing_address_2']['label_class'] = [];
        $checkout_fields['billing']['billing_address_2']['class'] = array('form-row-half', 'cvchekout-field'); // Updated class
        $checkout_fields['shipping']['shipping_address_2']['placeholder'] = __('Apartment, ... (optional)', 'cvchekout');
        $checkout_fields['shipping']['shipping_address_2']['label_class'] = [];
        $checkout_fields['shipping']['shipping_address_2']['class'] = array('form-row-half', 'cvchekout-field'); // Updated class
        return $checkout_fields;
    }



    private function edit_checkout_postcode_field($checkout_fields)
    {

        $checkout_fields['billing']['billing_postcode']['placeholder'] = __('Postcode', 'cvchekout');
        $checkout_fields['billing']['billing_postcode']['class'] = array('form-row-first', 'cvchekout-field');
        $checkout_fields['billing']['billing_postcode']['label'] = '<span class="space"></span>';
        $checkout_fields['shipping']['shipping_postcode']['placeholder'] = __('Postcode', 'cvchekout');
        $checkout_fields['shipping']['shipping_postcode']['class'] = array('form-row-first', 'cvchekout-field');
        $checkout_fields['shipping']['shipping_postcode']['label'] = '<span class="space"></span>';
        return $checkout_fields;
    }

    private function edit_checkout_city_field($checkout_fields)
    {

        $checkout_fields['billing']['billing_city']['placeholder'] = __('City', 'cvchekout');
        $checkout_fields['billing']['billing_city']['class'] = array('form-row-last', 'cvchekout-field');

        $checkout_fields['shipping']['shipping_city']['placeholder'] = __('City', 'cvchekout');
        $checkout_fields['shipping']['shipping_city']['class'] = array('form-row-last', 'cvchekout-field');
        return $checkout_fields;
    }






    public function display_admin_custom_order_fields($order_id){
        $limited_packaging = get_post_meta($order_id, 'order_packaging', true);
        ob_start();
        ?>
        <tr class="packaging">
            <td class="thumb"></td>
            <td class="name">
                <?php if($limited_packaging): ?>
                    <div class="view"><?php _e('Limited packaging', 'cvchekout'); ?></div>
                <?php else: ?>
                    <div class="view"><?php _e('Without Limited packaging', 'cvchekout'); ?></div>
                <?php endif; ?>
            </td>
        </tr>
        <?php
        $html = ob_get_clean();
        echo $html;
    }
}