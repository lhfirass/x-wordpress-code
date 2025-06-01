<?php

    Class Expcod_Ajax{

        public function __construct()
        {
            
            add_action( 'wp_ajax_nopriv_expcod_place_order', array($this , 'place_order') );
            add_action( 'wp_ajax_expcod_place_order', array($this , 'place_order') );
            add_action( 'wp_ajax_nopriv_new_expcod_order', array($this , 'init_order') );
            add_action( 'wp_ajax_new_expcod_order', array($this , 'init_order') );
            add_action( 'wp_ajax_expcod_settings', array($this , 'ajax_update_settings') );
            add_action( 'wp_ajax_uplaod_json_woodokan', array($this , 'my_back_fun') );
           

           
        }

        
        /**
         * init_order
         *
         * @return void
         */
        public function init_order()
        {
            if (!is_plugin_active('litespeed-cache/litespeed-cache.php')) {
                codexp()->validate->verify_nonce('codexp_nonce',$_POST['codexp_nonce']);
            } 
           
            $validation = codexp()->validate->chekout_form($_POST);
            
           if($validation === true){
                codexp()->order->direct_checkout();
           }else{  
                 wp_send_json($validation);
           }
            wp_die();
        }

        public function my_back_fun(){
            /*
            - Store Google console auth key
            - it is uploaded through woocommerce > woodokan > apps > google sheets > google sheets configuration.
            - Once the file is uploaded it will be stored in classes/sheets/key.json directory
            - if the file is successfully uploaded and stored it will return service access account from json
            **/
            $path = EXPCOD_PATH . 'classes/sheets/';
            $img = $_FILES['json_key']['name'];
            $tmp = $_FILES['json_key']['tmp_name'];
            
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            $final_image = 'key.json';
            $path = $path.strtolower($final_image); 

            if(move_uploaded_file($tmp,$path)) 
            {
                $jsn = file_get_contents(EXPCOD_PATH . 'classes/sheets/key.json');
                $jsn = json_decode($jsn);
                $jsn = $jsn->client_email;
                wp_send_json(['success'=>true,'acc'=>$jsn]);
            }
        }


        /**
         * place_order
         *
         * @return void
         */
        public function place_order()
        {
            
            codexp()->order->create_order();          
        }
  

        public function ajax_update_settings()
        {
            /*
            - Handle update settings ajax request
            - FormData : 
            */


                $data       =   $_POST["formDta"];
                $optionKey  =   $_POST["settings"];
                $nonce      =   $_POST['security'];
            
                codexp()->settings->update($data,$optionKey,$nonce,'wd_nonce');
                $response = codexp()->settings->get_response();
                wp_send_json($response);
       
     
           

           
         }

    }

