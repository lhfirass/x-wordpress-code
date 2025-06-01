<?php 

class Expcod_Order{

      
    /**
     * create woocommerce order 
     *
     * @return void
     */
    public function create_order(){
        
        $customerDetails =  WC()->session->get('expcod_customer');   
        $order = $this->checkout($customerDetails['billing']);


        if($order->get_id()){

           wc()->cart->empty_cart();
           $response = array(
               'success'=> true,
               'message' =>__( 'order placed successfully!','cod-express-checkout'),
               'redirect'=> $this->get_thank_you_page($order)
           );

           wp_send_json($response);
           
        }else{
           $response = array(
               'success'=>false,
               'message' => __('Sorry we can not process this order now , please try later','cod-express-checkout') 
           );

           wp_send_json($response);
        }
   }

   
   /**
    * add item to cart
    *
    * @return void
    */
   public function add_to_cart()
   {
 
    $expcod_firstName       = $_POST['field_type_1'] ;
    $expcod_lastName        = $_POST['field_type_2'] ;
    $expcod_addr1           = $_POST['field_type_3'] ;
    $expcod_city            = $_POST['field_type_4'] ;
    $expcod_state           = $_POST['field_type_5'] ;
    $expcod_email           = $_POST['field_type_6'] ;
    $expcod_phone           = $_POST['field_type_7'] ;
    $expcod_country         = $_POST['field_type_8'] ;
    $expcod_customerNote    = $_POST['field_type_9'] ;
    $expcod_zipCode         = $_POST['field_type_10'] ;
    $expcod_company         = $_POST['field_type_11'] ;


    $customerSession = array(
        'billing' => array(),
        'preview' => array()
    );
    WC()->cart->empty_cart();
    WC()->session->set('expcod_customer' , null);

    // First Name
    if(!codexp()->validate->is_empty($expcod_firstName)){

        $firstName = sanitize_text_field($expcod_firstName);
        $labelText = codexp()->settings->get_field_label('field_type_1');
        $customerSession['billing']['billing_first_name'] = $firstName;
        array_push($customerSession['preview'] , array($labelText,$firstName));
        
       
    }
    // Last Name
    if(!codexp()->validate->is_empty($expcod_lastName)){
       
        $lastName = sanitize_text_field($expcod_lastName);
        $labelText = codexp()->settings->get_field_label('field_type_2');
        $customerSession['billing']['billing_last_name'] =  $lastName ;
        array_push($customerSession['preview'] , array($labelText,$lastName));

    }
    // Company
    if(!codexp()->validate->is_empty($expcod_company)){
       
        $company = sanitize_text_field($expcod_company);
        $labelText = codexp()->settings->get_field_label('field_type_11');
        $customerSession['billing']['billing_company'] = $company;
        array_push($customerSession['preview'] , array($labelText,$company));

    }

    // adress 1 and 2 are considered as same adress
    if(!codexp()->validate->is_empty($expcod_addr1)){
       
        $adress = sanitize_text_field($expcod_addr1);
        $labelText = codexp()->settings->get_field_label('field_type_3');
        $customerSession['billing']['billing_address_1'] =  $adress;
        array_push($customerSession['preview'] , array($labelText,$adress));
    }
    // City
    if(!codexp()->validate->is_empty($expcod_city)){
        
        $city = sanitize_text_field($expcod_city);
        $labelText = codexp()->settings->get_field_label('field_type_4');
        $customerSession['billing']['billing_city'] = $city;
        array_push($customerSession['preview'] , array($labelText,$city));

    }
    // State
    if(!codexp()->validate->is_empty($expcod_state)){

        $state = sanitize_text_field($expcod_state);
        $labelText = codexp()->settings->get_field_label('field_type_5');
        $customerSession['billing']['billing_state'] = $state;
        array_push($customerSession['preview'] , array($labelText,$state));
    }
    //Postal code
    if(!codexp()->validate->is_empty($expcod_zipCode)){
        
        $postCode = sanitize_text_field($expcod_zipCode);
        $labelText = codexp()->settings->get_field_label('field_type_10');
        $customerSession['billing']['billing_postcode'] = $postCode;
        array_push($customerSession['preview'] , array($labelText,$postCode));

    }
    // Country
    if(!codexp()->validate->is_empty($expcod_country)){
        
        $country = sanitize_text_field($expcod_country);
        $labelText = codexp()->settings->get_field_label('field_type_8');
        $customerSession['billing']['billing_country'] = $country;
        array_push($customerSession['preview'] , array($labelText,$country));

    }
    // Phone
    if(!codexp()->validate->is_empty($expcod_phone)){

        $phone = sanitize_text_field($expcod_phone);
        $labelText = codexp()->settings->get_field_label('field_type_7');
        $customerSession['billing']['billing_phone'] = $phone;
        array_push($customerSession['preview'] , array($labelText,$phone));

    }
    // Email
    if(!codexp()->validate->is_empty($expcod_email)){

        $email = sanitize_text_field($expcod_email);
        $labelText = codexp()->settings->get_field_label('field_type_6');
        $customerSession['billing']['billing_email'] = $email;
        array_push($customerSession['preview'] , array($labelText,$email));

    }


    WC()->session->set('expcod_customer' , $customerSession);  

    if($_POST['product_type'] == "variable"): 
        $added = WC()->cart->add_to_cart( $_POST['product_id'], $_POST['quantity'], $_POST['variation_id'] );
        else:
        $added = WC()->cart->add_to_cart( $_POST['product_id'], $_POST['quantity']);
    endif;

    if($added != false){

        $error_message = array(
            'success'=>true,
            'message'=>__('product added to cart sucessfully','cod-express-checkout')
        );


        $customerInfo_preview   = WC()->session->get('expcod_customer');
        $shipping_total         = get_post_meta($_POST['product_id'],'expcod_shipping_price');
        $checkoutNote           = get_post_meta($_POST['product_id'],'expcod_checkout_note');

        WC()->cart->set_shipping_total($shipping_total[0]);
        $shipping_price         = wc_price(WC()->cart->get_shipping_total());
        if($shipping_price){
            $total = wc_price(WC()->cart->get_shipping_total() + WC()->cart->get_cart_contents_total());
        }else{
            $total = WC()->cart->get_cart_contents_total();
        }
        
        


        $variationId        = WC()->cart->get_cart()[array_key_first(WC()->cart->get_cart())]['variation_id'];
        $variation          = new WC_Product_Variation($variationId);
        $variationName      = implode(" / ", $variation->get_variation_attributes());
        $quantityInCart     = WC()->cart->get_cart()[array_key_first(WC()->cart->get_cart())]['quantity'];



        
        $response = array(
            'steps' => 2,
            'tester' => WC()->cart->customer,
            'success'       => true,
            'validated'     => true,
            'checkoutData'  => $customerInfo_preview,
            'cartTotal'     =>  $total ,
            'Shipping'      =>  $shipping_price,
            'cartSubtotal'  => WC()->cart->get_cart_subtotal(),
            'productQuantity' => $quantityInCart >= 10? $quantityInCart : "0$quantityInCart", 
            'variationId'=> $variationName,
            'checkoutNote' => $checkoutNote[0]
        );

         wp_send_json($response);


    }else{

        $error_message = array(
            'success'=>false,
            'message'=>__('Cannot add item to cart','cod-express-checkout')
        );

         wp_send_json($error_message);

    }    
   }


   
   /**
    * checkout method ( copied from woocommerce class WC_checkout::create_order)
    * see https://woocommerce.github.io/code-reference/classes/WC-Checkout.html#method_create_order
    * @return void
    */
   public function checkout($data){
   
        
			$order = new wc_order();

			$fields_prefix = array(
				'shipping' => true,
				'billing'  => true
			);

			$shipping_fields = array(
				'shipping_method' => true,
				'shipping_total'  => true,
				'shipping_tax'    => true
			);
			foreach ( $data as $key => $value ) {
				if ( is_callable( array( $order, "set_{$key}" ) ) ) {
					$order->{"set_{$key}"}( $value );
					// Store custom fields prefixed with wither shipping_ or billing_. This is for backwards compatibility with 2.6.x.
				} 
			}

			$order->hold_applied_coupons( $data['billing_email'] );
			$order->set_created_via( 'rest-api' );
			$order->set_cart_hash( $cart_hash );
			$order->set_customer_id( apply_filters( 'woocommerce_checkout_customer_id', get_current_user_id() ) );
			$order->set_currency( get_woocommerce_currency() );
			$order->set_prices_include_tax( 'yes' === get_option( 'woocommerce_prices_include_tax' ) );
			$order->set_customer_ip_address( WC_Geolocation::get_ip_address() );
			$order->set_customer_user_agent( wc_get_user_agent() );
			$order->set_customer_note( isset( $data['order_comments'] ) ? $data['order_comments'] : '' );
			$order->set_payment_method( isset( $available_gateways[ $data['payment_method'] ] ) ? $available_gateways[ $data['payment_method'] ] : $data['payment_method'] );
			
            wc()->checkout->set_data_from_cart( $order );


            $order->set_status( 'wc-processing', 'Order in processing' );
			// Save the order.
            // Get a new instance of the WC_Order_Item_Shipping Object
            $item = new WC_Order_Item_Shipping();
            $item->set_total(WC()->cart->get_shipping_total());
            $order->add_item( $item );

			$order->calculate_totals();
          
                // try{
                //     codexp()->Gsheet->insert($order);
                // }catch(Exception $e){}
            // do_action( 'woocommerce_new_order', $order->get_id());
           
           
            do_action('woodokan_new_order',$order->get_id());
            

            
			return $order;
		
   }



   public function direct_checkout()
   {
   
    $expcod_firstName       = $_POST['field_type_1'] ;
    $expcod_lastName        = $_POST['field_type_2'] ;
    $expcod_addr1           = $_POST['field_type_3'] ;
    $expcod_city            = $_POST['field_type_4'] ;
    $expcod_state           = $_POST['field_type_5'] ;
    $expcod_email           = $_POST['field_type_6'] ;
    $expcod_phone           = $_POST['field_type_7'] ;
    $expcod_country         = $_POST['field_type_8'] ;
    $expcod_customerNote    = $_POST['field_type_9'] ;
    $expcod_zipCode         = $_POST['field_type_10'] ;
    $expcod_company         = $_POST['field_type_11'] ;
    $expcod_shippingPrice         = $_POST['expcod_shipping_price'] ;
   

    $customerSession = array(
        'billing' => array(),
        'preview' => array()
    );
    WC()->cart->empty_cart();
    WC()->session->set('expcod_customer' , null);

    // First Name
    if(!codexp()->validate->is_empty($expcod_firstName)){

        $firstName = sanitize_text_field($expcod_firstName);
        $labelText = codexp()->settings->get_field_label('field_type_1');
        $customerSession['billing']['billing_first_name'] = $firstName;
        array_push($customerSession['preview'] , array($labelText,$firstName));
        
       
    }
    // Last Name
    if(!codexp()->validate->is_empty($expcod_lastName)){
       
        $lastName = sanitize_text_field($expcod_lastName);
        $labelText = codexp()->settings->get_field_label('field_type_2');
        $customerSession['billing']['billing_last_name'] =  $lastName ;
        array_push($customerSession['preview'] , array($labelText,$lastName));

    }
    // Company
    if(!codexp()->validate->is_empty($expcod_company)){
       
        $company = sanitize_text_field($expcod_company);
        $labelText = codexp()->settings->get_field_label('field_type_11');
        $customerSession['billing']['billing_company'] = $company;
        array_push($customerSession['preview'] , array($labelText,$company));

    }

    // adress 1 and 2 are considered as same adress
    if(!codexp()->validate->is_empty($expcod_addr1)){
       
        $adress = sanitize_text_field($expcod_addr1);
        $labelText = codexp()->settings->get_field_label('field_type_3');
        $customerSession['billing']['billing_address_1'] =  $adress;
        array_push($customerSession['preview'] , array($labelText,$adress));
    }
    // City
    if(!codexp()->validate->is_empty($expcod_city)){
        
        $city = sanitize_text_field($expcod_city);
        $labelText = codexp()->settings->get_field_label('field_type_4');
        $customerSession['billing']['billing_city'] = $city;
        array_push($customerSession['preview'] , array($labelText,$city));

    }
    // State
    if(!codexp()->validate->is_empty($expcod_state)){

        $state = sanitize_text_field($expcod_state);
        $labelText = codexp()->settings->get_field_label('field_type_5');
        $customerSession['billing']['billing_state'] = $state;
        array_push($customerSession['preview'] , array($labelText,$state));
    }
    //Postal code
    if(!codexp()->validate->is_empty($expcod_zipCode)){
        
        $postCode = sanitize_text_field($expcod_zipCode);
        $labelText = codexp()->settings->get_field_label('field_type_10');
        $customerSession['billing']['billing_postcode'] = $postCode;
        array_push($customerSession['preview'] , array($labelText,$postCode));

    }
    // Country
    if(!codexp()->validate->is_empty($expcod_country)){
        
        $country = sanitize_text_field($expcod_country);
        $labelText = codexp()->settings->get_field_label('field_type_8');
        $customerSession['billing']['billing_country'] = $country;
        array_push($customerSession['preview'] , array($labelText,$country));

    }
    // Phone
    if(!codexp()->validate->is_empty($expcod_phone)){

        $phone = sanitize_text_field($expcod_phone);
        $labelText = codexp()->settings->get_field_label('field_type_7');
        $customerSession['billing']['billing_phone'] = $phone;
        array_push($customerSession['preview'] , array($labelText,$phone));

    }
    // Email
    if(!codexp()->validate->is_empty($expcod_email)){

        $email = sanitize_text_field($expcod_email);
        $labelText = codexp()->settings->get_field_label('field_type_6');
        $customerSession['billing']['billing_email'] = $email;
        array_push($customerSession['preview'] , array($labelText,$email));

    }


    WC()->session->set('expcod_customer' , $customerSession);  
    
    if($_POST['product_type'] == "variable"): 
        $added = WC()->cart->add_to_cart( $_POST['product_id'], $_POST['quantity'], $_POST['variation_id'] );
        else:
        $added = WC()->cart->add_to_cart( $_POST['product_id'], $_POST['quantity']);
    endif;
    WC()->cart->set_shipping_total($expcod_shippingPrice);

    if($added != false){

        $customerDetails =  WC()->session->get('expcod_customer');   
        $order = $this->checkout($customerDetails['billing']);


        if($order->get_id()){

           wc()->cart->empty_cart();
           $response = array(
               'steps' => 1,
               'success'=> true,
               'message' =>__( 'order placed successfully!','cod-express-checkout'),
               'redirect'=> $this->get_thank_you_page($order)
           );

           wp_send_json($response);
           
        }else{
           $response = array(
            'steps' => 1,
               'success'=>false,
               'message' => __('Sorry we can not process this order now , please try later','cod-express-checkout') 
           );

           wp_send_json($response);
        }





        
        $response = array(
           'type'=> 1
        );

         wp_send_json($response);


    }else{

        $response = array(
            'type'=> 1
         );
 
          wp_send_json($response);

    }    
   }
   
   /**
    * get_thank_you_page
    *
    * @param  mixed $order
    * @return string Thank you page link
    */
   public function get_thank_you_page($order){

        $redirectSetting =  codexp()->settings->get('redirections');
        if($redirectSetting->method == 'wc-order-received'){
        $order_received_url = wc_get_endpoint_url( 'order-received', $order->get_id(), wc_get_checkout_url() );
        $order_received_url = add_query_arg( 'key', $order->get_order_key(), $order_received_url );
        $order_received_url  = apply_filters( 'woocommerce_get_checkout_order_received_url', $order_received_url, $order );

        }else{
            $order_received_url =$redirectSetting->url;  
        }

    return $order_received_url;

   }
}