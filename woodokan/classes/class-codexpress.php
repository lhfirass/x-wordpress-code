<?php

Class CodExpressCheckout{
	/**
	 * The single instance of the class.
	 *
	 * @var CodExpressCheckout
	 */
	protected static $_instance = null;

    public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    

  
    public function __get($name)
    {
        /*
        ** methods like codexp()->settings  are built here
        */
        $method = "create_".$name."_property";
        $this->{$name} = $this->{$method}();
        return $this->{$name};
    }

    public function create_settings_property(){
        return new Expcod_Settings;
    }

    public function create_validate_property(){
        return new Expcod_Validate();
    }
    public function create_order_property(){
        return new Expcod_Order();
    }
    public function create_Gsheet_property(){
        return new Expcod_Gsheet();
    }
}