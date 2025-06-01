<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



spl_autoload_register(function ($name) {
    $name = strtolower($name);
    if(str_starts_with($name,'expcod')){
        require($name.'.class.php');
    }
   
});
