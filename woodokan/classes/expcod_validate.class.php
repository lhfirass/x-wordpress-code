<?php 
/*
** Validate data comming from front end 
** This class is used to check if form inputs that are required are empty
** escaping and sanitization are applied in the creating order process after passing validation
** validate_chekout_form return array of errors to front end appear under form inputs
*/

Class Expcod_Validate{
    
    /**
     * fields_validation
     *
     * @var array
     */
    public $fields_validation = array();
    
    /**
     * chekout_form
     *
     * @param  array $posted_data
     * @return array of validation result
     */
    public function chekout_form($posted_data){
        // Get customer info fields
        $fields_array = array();

        foreach($posted_data as $key => $value){  

            if(str_starts_with($key,'field')){
               $fields_array[$key] = $value;
            }
        }
        /*
        **  $fields_array is now filled with posted fields
        **
        */
    
       $fields_settings = codexp()->settings->get('fields');
        // Get active fields
       $array_active_fields = array();
       foreach($fields_settings as $field){
    
            if($field->filedActive){
                array_push($array_active_fields,$field);
            }
       }
    
    
    

    $this->fields_validation['validity'] = 1;
        foreach($array_active_fields as $active_field){
    
           $this->fields_validation['fields'][$active_field->fieldType]['valid'] = 1;
         
            // check if required 
            if($active_field->isRequired == 1){    
                /*
                ** Check if empty
                ** If input is Empty Return error message
                */
                $value = str_replace(' ','',$fields_array[$active_field->fieldType]);
    
                if(!strlen($value)>0){
    
                    $this->fields_validation['fields'][$active_field->fieldType]['valid'] = 0;
                    $this->fields_validation['fields'][$active_field->fieldType]['message'] =  __('This field is required','cod-express-checkout'); 
                    $this->fields_validation['validity'] = 0;
                    $this->fields_validation['success'] = false;
    
                }else{
                    // passed required validation ? yes ? so lets see if you are a phone or email :)
                    /*
                    ** Validate Email Input
                    ** If input is not email return error message
                    */
                    if($active_field->fieldType == 'field_type_6'){

                        $this->validate_email($value,$active_field->fieldType);
                    }
                    /*
                    ** Validate Phone Number Input
                    ** If input is not phone Number return error message
                    */
                    if($active_field->fieldType == 'field_type_7'){
    
                        $this->validate_phone($value,$active_field->fieldType);
                    }
                    /*
                    ** Validate shipping option  Input
                    ** If input is not phone Number return error message
                    */
                    if($active_field->fieldType == 'field_type_5'){
    
                        $this->validate_shippingOption($value,$active_field->fieldType);
                    }
                }
    
               
            }else{
                //not required
            }
        }
    
        if($this->fields_validation['validity'] == 1){
            return true;
        }else{
            return $this->fields_validation;
        }
    }

    /**
     * validate_phone
     * @param  mixed $value
     * @param  mixed $field
     * @return void
    */
    public function validate_phone($value,$field){

        $phone = str_replace("-","",$value);
        $phone = str_replace("+","",$phone);
        $pattern = '/^[0-9]+$/s';

        if (!preg_match($pattern, $phone)) {
            $this->fields_validation['fields'][$field]['valid'] = 0;
            $this->fields_validation['fields'][$field]['message'] =  __('Invalid phone','cod-express-checkout');
            $this->fields_validation['validity'] = 0;
            $this->fields_validation['success'] = false;
          }
        if (strlen($phone) < 10) {
            $this->fields_validation['fields'][$field]['valid'] = 0;
            $this->fields_validation['fields'][$field]['message'] = __('Phone is less than 10','cod-express-checkout');
            $this->fields_validation['validity'] = 0;
            $this->fields_validation['success'] = false;
          }
    }


    public function validate_email($value , $field){
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->fields_validation['fields'][$field]['valid'] = 0;
            $this->fields_validation['fields'][$field]['message'] =  __('Invalid email','cod-express-checkout');
            $this->fields_validation['validity'] = 0;
            $this->fields_validation['success'] = false;
          }
    }
    
    
    /**
     * is_empty
     *
     * @param  mixed $variable
     * @return bool
     */
    public function is_empty($variable){
        
        if(!isset($variable)){
            return true;
        }else{
            $variable = str_replace(" ","",$variable);
            if(!strlen($variable)>0){
                return true;
            }else{
                return false;
            }
        }  
    }
    
    /**
     * verify_nonce
     *
     * @param  mixed $name
     * @param  mixed $nonce
     * @return void
     */
    public function verify_nonce($name,$nonce){

        if(!wp_verify_nonce($nonce,$name)){
            wp_send_json('Your session is expired' , 403);
        }
    }


    public function validate_shippingOption($value,$field){
        if($value == "none"){
            $this->fields_validation['fields'][$field]['valid'] = 0;
        $this->fields_validation['fields'][$field]['message'] =  __('This field is required','cod-express-checkout');
        $this->fields_validation['validity'] = 0;
        $this->fields_validation['success'] = false;
        }
    }
}