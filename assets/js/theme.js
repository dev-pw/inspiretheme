jQuery(document).ready(function ($) {

    /*=================================================
    CONFIGURACAO HEADER STICKY
    =================================================*/
    $(window).scroll(function () {
        if ($(window).scrollTop() > 150) {
            $('.l-header-site').addClass('l-header-site__sticky');
        }
        else {
            $('.l-header-site').removeClass('l-header-site__sticky');
        }
    });


   /*=================================================
   CONFIGURACAO NAV MENU
   =================================================*/
   $("#js-navigation-menu .menu-item-has-children > a").click(function (e) {
      $("#js-navigation-menu ul ul").slideUp(), $(this).next().is(":visible") || $(this).next().slideDown(),
      e.stopPropagation();
   });

   /*=================================================
   Preload Do Site
   ===================================================*/

   document.onreadystatechange = function () {
      if (document.readyState == "complete") {

      $('#preload').css('opacity', '0');
      $('#preload').css('visibility', 'hidden');
      $('body').css('overflow-y', 'auto');

      setTimeout(()=>{
            $('#preload').remove();
      }, 1000);
      clearTimeout;

      }
   }

   /*=================================================
   Inserindo Lighbox na Galeria do WordPress
   =================================================*/

   $('.entry-content-post').attr('id', 'thumbnails-gallery');

   lightGallery(document.getElementById('thumbnails-gallery'), {
      selector: 'figure > a',
      thumbnail: true,
   });

    /*=================================================
    CONFIGURAÇÃO JQUERY MASK
    =================================================*/
    var SPMaskBehavior = function (val) {
       return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
       onKeyPress: function (val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
       }
    };
    $('.tel_mask').mask(SPMaskBehavior, spOptions);

    $('.cpf_mask').mask('000.000.000-00', { reverse: true });
    $(".rg_mask").mask("00.000.000-A");
    $(".cep_mask").mask("00000-000");
    $(".data_mask").mask("00/00/0000");
    $(".cartao_mask").mask("0000 0000 0000 0000");
    $(".cvv_mask").mask("000");


    /*================================================
    INPUT SENHA -> BOTÃO VER
    =================================================*/
    $(".campo-senha__ver").on("click", function () {
       if ($(this).siblings('.form-floating').find('input').attr('type') == 'password') {
          $(this).siblings('.form-floating').find('input').attr('type', 'text');
          $(this).html('<span class="icon-eye-blocked fs-6"></span>');
       } else {
          $(this).siblings('.form-floating').find('input').attr('type', 'password');
          $(this).html('<span class="icon-eye fs-6"></span>');
       }
    });


    /*================================================
    PREENCHIMENTO DE ENDEREÇO AUTOMÁTICO
    =================================================*/
    // PREENCHER ENDEREÇO COM O CEP
    $(".cep_mask").blur(function () {
       getEndereco(
          $(this),
          $(".preencher_auto_rua"),
          $(".preencher_auto_bairro"),
          $(".preencher_auto_cidade"),
          $(".preencher_auto_estado"),
          $(".preencher_auto_numero"),
       );
    });

    function getEndereco(cep, endereco, bairro, cidade, estado, numero) {
       // Se o campo CEP não estiver vazio
       if (cep.val() != "") {
          cep = cep.val();

          $.getJSON("https://viacep.com.br/ws/" + cep + "/json/", function (result) {

             if (result.logradouro != '' && result.logradouro !== undefined) {
                endereco.val(unescape(result.logradouro));
                bairro.val(unescape(result.bairro));
                cidade.val(unescape(result.localidade));
                estado.val(unescape(result.uf));
                numero.focus();
             }
          });
       }
    }
    /*================================================
    PREENCHIMENTO DE ENDEREÇO AUTOMÁTICO
    =================================================*/

var body = $('body');
});
