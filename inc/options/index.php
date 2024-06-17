<?php
/*
    Source Name: Options Tabs 
    Description: Options Tab Painel Theme
    Author: Lucas Brandão
    Version: 2.0
*/

/*====================================================================
CRIAÇÃO DA ABA NO PAINEL
====================================================================*/

// Adiciona uma aba no menu principal do WordPress
add_action('admin_menu', 'opcoes_site');

function opcoes_site() {
    add_menu_page(
        'Opções do Site', // Title Page
        'Opções do Site', // Title Menu
        'manage_options', // Capacidade de Acesso
        'site_options', // Slug Menu 
        'render_content', // Function que faz a renderização do conteúdo dentro da Page
        '', // Icon Menu
        2 // Position Menu
    );

}


// Renderizar conteúdo
function render_content() {

    $version = '2.0';

    // Menu Exibido na Renderização
    $args = array(

        // Como preencher os campos do array ( 'Nome da Aba' => array('id do settings section', 'class do icon de exibição'))
        'Header' => array( 'header', 'dashicons dashicons-table-row-before'),
        'Footer' => array( 'footer', 'dashicons dashicons-table-row-after'),
        'Popup' => array( 'popup', 'dashicons dashicons-external'),
        'Redes Sociais' => array( 'rs', 'dashicons dashicons-admin-links'),
        'Contato' => array( 'info', 'dashicons dashicons-clipboard'),

    );

    require_once 'opcoes-site.php';
}


/*====================================================================
CRIAÇÃO DOS CAMPOS PARA CADA TAB
====================================================================*/

// Adiciona configurações e campos de opções
add_action('admin_init', 'options_theme');

function options_theme() {

    // Como preencher os campos do array ( 'Titulo <hr>' => array('ID da Section', 'CallBack Session', 'Page the field belongs to') ); 
    $add_settings_section = array(
        'Header <hr>' => array('header', '', 'header'),
        'Footer <hr>' => array('footer', '', 'footer'),
        'Popup <hr>' => array('popup', '', 'popup'),
        'Redes Sociais <hr>' => array('rs', '', 'rs'),
        'Informações de Contato <hr>' => array('info', '', 'info'),
    );
    
    // Como preencher os campos do array ( 'Titulo' => array('ID Fields', 'Function Render CallBack', 'Page the field belongs to', 'Section to which the field belongs') ); 
    $add_settings_field = array(
        'Logo Header' => array('options_logo_header', 'cp_logo_header', 'header', 'header'),
        'Logo Preload' => array('options_logo_preload', 'cp_logo_preload', 'header', 'header'),
        'Logo da Barra de Menu' => array('options_menubar', 'cp_menubar', 'header', 'header'),
        'Logo' => array('options_logo_footer', 'cp_logo_footer', 'footer', 'footer'),
        'Ativar Popup' => array('options_ativar_pop', 'cp_ativar_pop', 'popup', 'popup'),
        'Imagem Popup' => array('options_img_pop', 'cp_img_pop', 'popup', 'popup'),
        'Descrição' => array('options_desc', 'cp_desc', 'footer', 'footer'),
        'CopyRight Text' => array('options_copy', 'cp_copy', 'footer', 'footer'),
        'Facebook' => array('options_rs_1', 'cp_rs_1', 'rs', 'rs'),
        'Instagram' => array('options_rs_2', 'cp_rs_2', 'rs', 'rs'),
        'Youtube' => array('options_rs_3', 'cp_rs_3', 'rs', 'rs'),
        'Linkedin' => array('options_rs_4', 'cp_rs_4', 'rs', 'rs'),
        'WhatsApp' => array('options_rs_5', 'cp_rs_5', 'rs', 'rs'),
        'Email' => array('options_info_1', 'cp_info_1', 'info', 'info'),
        'Endereço' => array('options_info_2', 'cp_info_2', 'info', 'info'),
        'Telefone' => array('options_info_3', 'cp_info_3', 'info', 'info'),
        'Link Google' => array('options_info_4', 'cp_info_4', 'info', 'info'),
        'Rota Maps' => array('options_info_5', 'cp_info_5', 'info', 'info'),
        'Rota Waze' => array('options_info_6', 'cp_info_6', 'info', 'info'),
    );

    // Header
    foreach ($add_settings_section as $key => $value) {
        add_settings_section(
            ''.$value[0].'', // ID Fields
            ''.$key.'', // Title Session
            '', // CallBack Section
            ''.$value[2].'' // Page the field belongs to
        );
    }

    foreach ($add_settings_field as $key => $value) {
        add_settings_field(
            ''.$value[0].'', // ID Field
            ''.$key.'', // Title Field
            ''.$value[1].'', // CallBack Field
            ''.$value[2].'', // Page the field belongs to
            ''.$value[3].'' // Section to which the field belongs
        );

        // Como preencher os campos do array ('ID Section', 'ID Field'); 
        register_setting(''.$value[3].'', ''.$value[0].'');
    }


}


//CallBack de Header -----------------------------------------------------------------------------------

function cp_menubar() {
    $name = 'options_menubar';
    echo '
    <input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'">
    <div id="menubar" class="my-3">
    </div>
    <div class="upload_button_div">
        <span class="page-title-action media_upload_button" id="menubar-media"></span>
        <span class="page-title-action remove-image" id="reset_menubar" rel="menubar"> Remover </span> 
    </div>
    ';
}

function cp_logo_header() {
    $name = 'options_logo_header';
    echo '
    <input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'">
    <div id="logo_header" class="my-3">
    </div>
    <div class="upload_button_div">
        <span class="page-title-action media_upload_button" id="logo_header-media"></span>
        <span class="page-title-action remove-image" id="reset_logo_header" rel="logo_header"> Remover </span> 
    </div>
    ';
}

function cp_logo_preload() {
    $name = 'options_logo_preload';
    echo '
    <input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'">
    <div id="logo_preload" class="my-3">
    </div>
    <div class="upload_button_div">
        <span class="page-title-action media_upload_button" id="logo_preload-media"></span>
        <span class="page-title-action remove-image" id="reset_logo_preload" rel="logo_preload"> Remover </span> 
    </div>
    ';
}


//CallBack de Footer -----------------------------------------------------------------------------------

function cp_logo_footer() {
    $name = 'options_logo_footer';
    echo '
    <input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'">
    <div id="imgFooter" class="my-3">
    </div>
    <div class="upload_button_div">
        <span class="page-title-action media_upload_button" id="footerlogo-media"></span>
        <span class="page-title-action remove-image" id="reset_footerlogo" rel="footerlogo"> Remover </span> 
    </div>
    ';
}

function cp_desc() {
    $name = 'options_desc';
    echo '<textarea name="'.$name.'" id="desc" rows="10">'.esc_attr( get_option( $name ) ).'</textarea>';
}

function cp_copy() {
    $name = 'options_copy';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="&copy; Copyright '.date('Y').'. BrandsDev WordPress Theme">';
}

//CallBack de Popup -----------------------------------------------------------------------------------

function cp_ativar_pop() {
    $name = 'options_ativar_pop';
    if( get_option( $name ) == 'Sim' ){
        $check_s = 'checked';
    } else {
        $check_s = '';
    }

    if( get_option( $name ) == 'Nao' ){
        $check_n = 'checked';
    } else {
        $check_n = '';
    }
    echo '<input type="radio" name="'.$name.'" id="ativar1" value="Sim" '.$check_s.'> Sim </input>';
    echo '<input type="radio" name="'.$name.'" id="ativar2" value="Nao" '.$check_n.'> Não </input>';
}

function cp_img_pop() {
    $name = 'options_img_pop';
    echo '
    <input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'">
    <div id="imgPopup" class="my-3">
    </div>
    <div class="upload_button_div">
        <span class="page-title-action media_upload_button" id="imgpopup-media"></span>
        <span class="page-title-action remove-image" id="reset_imgpopup" rel="imgpopup"> Remover </span> 
    </div>
    ';
}


// CallBack de Redes Sociais ---------------------------------------------------------------------------

function cp_rs_1() {
    $name = 'options_rs_1';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://facebook.com/username">';
}

function cp_rs_2() {
    $name = 'options_rs_2';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://instagram.com/username">';
}

function cp_rs_3() {
    $name = 'options_rs_3';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://youtube.com/username">';
}

function cp_rs_4() {
    $name = 'options_rs_4';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://linkedin.com/username">';
}

function cp_rs_5() {
    $name = 'options_rs_5';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: +55 (11) 9 4002-8922">';
}

// CallBack de Contato ---------------------------------------------------------------------------

function cp_info_1() {
    $name = 'options_info_1';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: support@seudominio.com">';
}

function cp_info_2() {
    $name = 'options_info_2';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: Rua do Brasil 123 - Jardim Brasil - SP - CEP 12345-678">';
}

function cp_info_3() {
    $name = 'options_info_3';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: (11) 4002-8922">';
}

function cp_info_4() {
    $name = 'options_info_4';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://maps.app.goo.gl/kqTLb5qrZ13FEeKZ6">';
}

function cp_info_5() {
    $name = 'options_info_5';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://www.google.com/maps/dir//Google+-+Av.+Brig.+Faria+Lima,+3477+-+18%C2%BA+Andar+-+Itaim+Bibi,+S%C3%A3o+Paulo+-+SP,+04538-133/@-23.5868031,-46.8345872,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x94ce5744e0ebff5b:0x769bf4a32f914782!2m2!1d-46.6821519!2d-23.5868031?hl=pt-BR&entry=ttu">';
}

function cp_info_6() {
    $name = 'options_info_6';
    echo '<input type="text" name="'.$name.'" value="'.esc_attr( get_option( $name ) ).'" placeholder="Exemplo: https://www.waze.com/pt-PT/live-map/directions/google-brasil-av.-brigadeiro-faria-lima-3477-sao-paulo?to=place.w.205325852.2053389593.3483233">';
}


/*--------------------------------------------------------------
HABILITA OS SCRIPTS DA BIBLIOTECA DE MÍDIA DO WORDPRESS
--------------------------------------------------------------*/

function include_media_library() {
    wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'include_media_library');