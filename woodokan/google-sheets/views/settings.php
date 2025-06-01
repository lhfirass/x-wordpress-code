<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h1><?php esc_attr_e( "Woodokan Google sheets integration", "advanced-form-integration" ); ?></h1>

    <?php
    $current_tab = $_REQUEST['tab'] ;
    ?>
    <h2 class="nav-tab-wrapper">
        
            <a class="nav-tab <?php echo ( $current_tab == 'googlesheets' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=woodokan-sheets-integration&tab=' ) . 'googlesheets'; ?>">Google sheets configuration</a>
            <a class="nav-tab <?php echo ( $current_tab == 'integrations' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=woodokan-sheets-integration&tab=' ) . 'integrations'; ?>">Integrations</a>
            <a class="nav-tab <?php echo ( $current_tab == 'integrationlog' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=woodokan-sheets-integration&tab=' ) . 'integrationlog'; ?>">Logs</a>
       
    </h2>

    <?php
    if( $current_tab == 'general' ) {

    }

    do_action( 'woodokan_settings_view', $current_tab );
    ?>
   
</div> <!-- .wrap -->