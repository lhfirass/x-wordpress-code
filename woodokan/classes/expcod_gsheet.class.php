<?php


/**
 * Expcod_Gsheet
 */
class Expcod_Gsheet{


  
  /**
   * insert
   *
   * @param  mixed $order
   * @return void
   */
  public function insert($order){
     $sheets = codexp()->settings->get('sheets');
     

     $data = array();
     foreach($sheets->data as  $col){
        array_push($data,$this->{"$col->dataType"}($order));

     }
   
     $sheetUrl = $sheets->spreadsheet;
     $sheetId = explode('/',$sheetUrl);
     $sheetId =  $sheetId[5];
     
   


     $page = $sheets->page;
     if(empty($page)){
      return;
    }
     if(empty($sheetUrl)){
      return;
    }
   
     $serviceAccount = $sheets->editor;


     require EXPCOD_PATH . 'classes/sheets/vendor/autoload.php';
    // configure the Google Client
    $client = new \Google_Client();
    $client->setApplicationName('Google Sheets API');
    $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
    $client->setAccessType('offline');
    // credentials.json is the key file we downloaded while setting up our Google Sheets API
    $file = EXPCOD_PATH . 'classes/sheets/key.json';
    $path = file_get_contents($file);
   

   
    $client->setAuthConfig($path);

    $service = new \Google_Service_Sheets($client);
// print_r($data);
    $spreadsheetId =  $sheetId;
    $range = $page;
     $newRow = $data ;
    $rows = [$newRow];
    $valueRange = new \Google_Service_Sheets_ValueRange();
    $valueRange->setValues($rows);
  
    $options = ['valueInputOption' => 'USER_ENTERED'];
   
 
   
     $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options);
        
    
  }

    
  /**
   * get_billing_first_name
   *
   * @param  mixed $order
   * @return void
   */
  public function order_date($order){
    $order = new WC_Order($order->get_id());
    $order_date = $order->order_date;
    
     return $order_date;
  }

  
  /**
   * get_billing_last_name
   *
   * @param  mixed $order
   * @return void
   */
  public function client_last_name($order){
    
    return $order->get_billing_last_name();
  }

  
  /**
   * get_billing_company
   *
   * @param  mixed $order
   * @return void
   */
  public function client_first_name($order){
    
    return $order->get_billing_first_name();
  }

  
  /**
   * get_billing_adress
   *
   * @param  mixed $order
   * @return void
   */
  public function client_phone($order){
    return $order->get_billing_phone();
  }

  
  /**
   * get_billing_city
   *
   * @param  mixed $order
   * @return void
   */
  public function client_add($order){
    return $order->get_shipping_address_2();
  }

  
  /**
   * get_billing_state
   *
   * @param  mixed $order
   * @return void
   */
  // public function order_quantity($order){
  //   return $order->get_billing_state();
  // }

  
  /**
   * get_billing_country
   *
   * @param  mixed $order
   * @return void
   */
  // public function order_product($order){
  //   return $order->get_billing_country();
  // }

  
  /**
   * get_billing_email
   *
   * @param  mixed $order
   * @return void
   */
  // public function order_id($order){
  //   return $order->get_billing_email();
  // }

  
  /**
   * get_billing_phone
   *
   * @param  mixed $order
   * @return void
   */
  public function order_total($order){
    return $order->get_billing_phone();
  }

  
  /**
   * get_items_name
   *
   * @param  mixed $order
   * @return void
   */
  public function order_product($order){
    foreach($order->get_items() as $item) {
        $product_name = $item['name'];
    
    }
    
    return $product_name;
  }
  /**
   * get_items_name
   *
   * @param  mixed $order
   * @return void
   */
  public function order_quantity($order){
    foreach($order->get_items() as $item) {
        $product_name = $item['quantity'];
    
    }
    
    return $product_name;
  }

  
  /**
   * get_total
   *
   * @param  mixed $order
   * @return void
   */
  public function get_total($order){
    return $order->get_formatted_order_total();
  }

  
  /**
   * get_date_created
   *
   * @param  mixed $order
   * @return void
   */
  public function get_order_date($order){
    return $order->order_date;
  }

  
  /**
   * get_order_id
   *
   * @param  mixed $order
   * @return void
   */
  public function order_id($order){
    return $order->get_id();
  }

}