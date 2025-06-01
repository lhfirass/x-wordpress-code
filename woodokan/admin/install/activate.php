<?php

 // add fields option settings 
 $expcod_fields_option = '[{\"position\":1,\"fieldType\":\"field_type_2\",\"placeholderText\":\"الإسم الكامل\",\"filedActive\":true,\"isRequired\":\"0\",\"fullSizing\":\"1\"},{\"position\":2,\"fieldType\":\"field_type_3\",\"placeholderText\":\"العنوان\",\"filedActive\":true,\"isRequired\":\"1\",\"fullSizing\":\"1\"},{\"position\":3,\"fieldType\":\"field_type_7\",\"placeholderText\":\"رقم الهاتف\",\"filedActive\":true,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":4,\"fieldType\":\"field_type_1\",\"placeholderText\":\"First Name\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"1\"},{\"position\":5,\"fieldType\":\"field_type_4\",\"placeholderText\":\"City\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":6,\"fieldType\":\"field_type_6\",\"placeholderText\":\"Email Adress\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":7,\"fieldType\":\"field_type_5\",\"placeholderText\":\"الولاية\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"1\"},{\"position\":8,\"fieldType\":\"field_type_9\",\"placeholderText\":\"Customer note\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":9,\"fieldType\":\"field_type_8\",\"placeholderText\":\"Country\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":10,\"fieldType\":\"field_type_10\",\"placeholderText\":\"Zip code\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"},{\"position\":11,\"fieldType\":\"field_type_11\",\"placeholderText\":\"Country\",\"filedActive\":false,\"isRequired\":\"1\",\"fullSizing\":\"0\"}]';
 update_option('expcod_fields',$expcod_fields_option);
 
 // add fields option stylings 
 $expcod_stylings = '{\"button_text\":\"أطلب الآن\",\"form_title\":\"أدخل معلوماتك للطلب\",\"quantity_input\":\"block\",\"sticky_button\":\"flex\",\"order_summary\":\"none\",\"order_summary_default_state\":\"none\",\"input_border_color\":\"#dddddd\",\"input_border_color_onfocus\":\"#018c77\",\"input_text_color\":\"#000000\",\"input_background_color\":\"#ffffff\",\"input_height\":\"50\",\"input_border_width\":\"1\",\"input_border_radius\":\"5\",\"input_placeholder_text_size\":\"14\",\"input_border_width_onfocus\":\"1\",\"button_text_color\":\"#ffffff\",\"button_text_color_onhover\":\"#ffffff\",\"button_background_color\":\"#018c77\",\"button_background_color_onhover\":\"#017265\",\"button_border_color\":\"#000000\",\"button_height\":\"47\",\"button_text_size\":\"14\",\"button_border_width\":\"0\",\"label_text_color\":\"#018c77\",\"label_text_size\":\"16\",\"label_text_weight\":\"normal\",\"label_margin_bottom\":\"0\",\"label_margin_top\":\"0\",\"label_visibility\":\"none\",\"form_border_color\":\"#018c77\",\"form_border_width\":\"2\",\"form_border_type\":\"solid\",\"form_border_radius\":\"5\",\"form_margin_top\":\"15\",\"form_margin_bottom\":\"17\",\"form_padding\":\"20\",\"form_max_width\":\"601\",\"form_bg_color\":\"#fcfcfc\"}';
 update_option('expcod_stylings',$expcod_stylings);
 
 // add fields option redirections 
 $expcod_default_url = get_site_url();
 $expcod_redirection = '{\"url\":\"'. $expcod_default_url.'",\"method\":\"wc-order-received\",\"steps\":\"1\",\"form_display\":\"0\"}';
 update_option('expcod_redirections',$expcod_redirection);

 // add fields option redirections 
 $expcod_shipping = '[{\"position\":1,\"element_name\":\"منطقة الشحن 01\",\"element_value\":\"\"},{\"position\":2,\"element_name\":\"منطقة الشحن 02\",\"element_value\":\"10\"},{\"position\":3,\"element_name\":\"منطقة الشحن 03\",\"element_value\":\"\"}]';
 update_option('expcod_shipping',$expcod_shipping);

 // add fields option sheets 
 $expcod_sheets = '{\"data\":[{\"position\":1,\"dataType\":\"order_id\",\"filedActive\":true},{\"position\":2,\"dataType\":\"order_date\",\"filedActive\":true},{\"position\":3,\"dataType\":\"client_first_name\",\"filedActive\":true},{\"position\":4,\"dataType\":\"client_last_name\",\"filedActive\":true},{\"position\":5,\"dataType\":\"client_add\",\"filedActive\":true},{\"position\":6,\"dataType\":\"client_phone\",\"filedActive\":false},{\"position\":7,\"dataType\":\"order_product\",\"filedActive\":false},{\"position\":8,\"dataType\":\"order_quantity\",\"filedActive\":false},{\"position\":9,\"dataType\":\"order_total\",\"filedActive\":false}],\"editor\":\"2\",\"spreadsheet\":\"https://docs.google.com/spreadsheets/d/1lXD2nMKXS1KzgVigH3NgpJhvmjju1rYu1HIorLnfVB8/edit#gid=0\",\"page\":\"Feuille 1\"}';
 update_option('expcod_sheets', $expcod_sheets);
 update_option( "woodokan_general_settings_platforms", array('googlesheets'=>true) );
 
 global  $wpdb ;
 $collate = '';
 
 if ( $wpdb->has_cap( 'collation' ) ) {
     if ( !empty($wpdb->charset) ) {
         $collate .= "DEFAULT CHARACTER SET {$wpdb->charset}";
     }
     if ( !empty($wpdb->collate) ) {
         $collate .= " COLLATE {$wpdb->collate}";
     }
 }
 
 $table_schema = array( "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woodokan_integration` (\n                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n                    `title` text NOT NULL,\n                    `form_provider` varchar(255) NOT NULL,\n                    `form_id` varchar(255) NOT NULL,\n                    `form_name` varchar(255) DEFAULT NULL,\n                    `action_provider` varchar(255) NOT NULL,\n                    `task` varchar(255) NOT NULL,\n                    `data` longtext DEFAULT NULL,\n                    `extra_data` longtext DEFAULT NULL,\n                    `status` int(1) NOT NULL,\n                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n                    KEY `id` (`id`)\n                ) {$collate};", "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}woodokan_log` (\n                    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n                    `response_code` int(3) DEFAULT NULL,\n                    `response_message` varchar(255) DEFAULT NULL,\n                    `integration_id` bigint(20) DEFAULT NULL,\n                    `request_data` longtext DEFAULT NULL,\n                    `response_data` longtext DEFAULT NULL,\n                    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n                    KEY `id` (`id`)\n                ) {$collate};" );
 require_once ABSPATH . 'wp-admin/includes/upgrade.php';
 foreach ( $table_schema as $table ) {
     dbDelta( $table );
 }