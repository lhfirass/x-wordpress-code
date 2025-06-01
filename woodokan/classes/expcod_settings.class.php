<?php

class Expcod_Settings{

  /**
   * fields option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $redirections = null;
  /**
   * fields option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $fields = null;
  /**
   * stylings option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $stylings = null;
  
  /**
   * stylings option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $sheets = null;
  /**
   * stylings option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $pixels = null;
  
  /**
   * stylings option comming from DB 
   * will be stored here
   * @var array
   */  
  protected static $shipping = null;
  
  /**
   * response array
   *
   * @var array
   */
  protected $response = array(

    'success' => true,
    'updated' => false,
    'message' => null
  );
  
  /**
   * wd_keys update option restrict to these keys
   *
   * @var array
   */
  protected $wd_keys = array(

    'expcod_stylings',
    'expcod_redirections',
    'expcod_fields',
    'expcod_sheets',
    'expcod_pixels',
    'expcod_shipping',
    'expcod_sheets',


  );
  
  /**
   * get : if option is exit as property return it .if not use get_option()
   * this method prevents calling get_option()  twise in the same script load
   * @param  string $option option key
   * @return array value of option key passed through param (json_decoded) 
   */
  public function get($option , $decode = true){

   
    if(!is_null(self::$$option)){
      
      return self::$$option;

    }else{
      
      $result = get_option("expcod_{$option}");
      $result = str_replace('\\' , '' ,$result);
 if($decode == true){
  $result = json_decode($result);
 }
      
      

      self::$$option = $result;
      return  self::$$option;

    }
   

  }

  
  /**
   * update
   *
   * @param  mixed $data posted settings data
   * @param  mixed $key key of update_option() function
   * @param  mixed $nonce
   * @param  mixed $nonceName
   * @return void
   */
  public function update($data,$key,$nonce,$nonceName){

    $nonce      = sanitize_text_field($nonce);
    $nonceName  = sanitize_text_field($nonceName);
    $key        = sanitize_text_field($key);
    $data       = sanitize_text_field($data);

    if($this->verify_nonce($nonce,$nonceName)){
       
       
          if(!in_array($key,$this->wd_keys) ){
           
            $this->response['success'] = false;
            $this->response['message'] = __('You are not allowed to update this option','cod-express-checkout');
            return;

        }else{
           
            if(update_option($key, $data)){

                $this->response['updated'] = true;
                $this->response['message'] = __('Fields updated successfully !','cod-express-checkout');
                return;

            }else{
                
                $this->response['updated'] = false;
                $this->response['message'] = __('Fields are already updated!','cod-express-checkout');
                return;
               
            }
        }
   

    }else{

        $this->response['success'] = false;
        $this->response['message'] = __('You are not allowed to update this due to security reasons','cod-express-checkout');
        return;
    }

  }

  
  /**
   * get_response
   *
   * @return array response array
   */
  public function get_response(){

    return $this->response;

  }

    public function verify_nonce($nonce,$name){

        if( wp_verify_nonce($nonce,$name)){

            return true;

        }else{

            return false;

        }

    }
    
    /**
     * get_field_label
     *
     * @param  string $field_type 
     * @return string label text of passed field type
     */
    public function get_field_label($field_type){

      $fields = $this->get('fields');

      foreach($fields as $field){
        if($field->fieldType == $field_type){
          if( $field->labelText){
            return $field->labelText;
          }else{
            return ' ';
          }
        }
      }
    }


}