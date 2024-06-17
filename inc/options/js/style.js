jQuery(document).ready(function() {

    /*=================================================
        Ativa a Primeira Tab
    ===================================================*/
    jQuery('.nav-link')[0].click();


    /*=================================================
        Habilita a funcionalidade da biblioteca aos botões
    ===================================================*/ 
    function mediaUploader(selector, inputName, imageViewSelector, resetButtonId) {

        /*=================================================
        Adiciona o texto no botão
        ===================================================*/    
        jQuery(selector).text('Adicionar Imagem');


        /*=================================================
        Caso o input já tenha a url preenchida, ele recupera o valor e cria a imagem 
        ===================================================*/ 
        let imgTab = jQuery(`input[name=${inputName}]`).val();
        if ( imgTab != '' ){
            let imgElement = document.createElement("img");
            jQuery(imgElement).attr('class', 'img-cover');
            jQuery(imgElement).attr('src', imgTab);
            jQuery(imageViewSelector).append(imgElement);
            jQuery(selector).text('Editar');

        }
    
        /*=================================================
        Ao clicar no botão de adicionar ele abre a biblioteca do WordPress
        ===================================================*/ 
        jQuery(document).on("click", selector, function(e) {
            e.preventDefault();

            var uploader = wp.media({
                title: "Selecione uma imagem",
                button: {
                    text: "Usar esta imagem"
                },
                multiple: false
            });

            uploader.on("select", function() {
                
                var attachment = uploader.state().get("selection").first().toJSON();
                
                let imgElement = document.createElement("img");
                imgElement.setAttribute('id', inputName);
                imgElement.setAttribute('class', 'img-cover');
                imgElement.setAttribute('alt', attachment.filename);
                imgElement.setAttribute('src', attachment.url);
                jQuery(imageViewSelector).append(imgElement);

                jQuery(`input[name=${inputName}]`).val(attachment.url);
                jQuery(imageViewSelector).find('img').attr('alt', attachment.filename);
                jQuery(imageViewSelector).find('img').attr('src', attachment.url);

                jQuery(selector).text('Editar');
            });

            uploader.open();

        });


        /*=================================================
        Reseta o campo do input e troca o nome para Adicionar
        ===================================================*/ 
        jQuery(document).on("click", resetButtonId, function() {
            jQuery(`input[name=${inputName}]`).val('');
            jQuery(selector).text('Adicionar Imagem');
            jQuery(imageViewSelector).find('img').remove();
        });

    }

    jQuery(document).ready(function() {

        /*=================================================
        Rodar a Função
        ===================================================*/ 
        mediaUploader("#logo_header-media", "options_logo_header", "#logo_header", "#reset_logo_header");
        mediaUploader("#logo_preload-media", "options_logo_preload", "#logo_preload", "#reset_logo_preload");
        mediaUploader("#menubar-media", "options_menubar", "#menubar", "#reset_menubar");
        mediaUploader("#footerlogo-media", "options_logo_footer", "#imgFooter", "#reset_footerlogo");
        mediaUploader("#imgpopup-media", "options_img_pop", "#imgPopup", "#reset_imgpopup");
        
    });
    
});