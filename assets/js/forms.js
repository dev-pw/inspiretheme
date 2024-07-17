jQuery(document).ready(function ($) {

  var timeoutHandle;

  /*=======================================================
    PEGANDO URL DO SITE
  =========================================================*/
  let url = document.querySelector("#getUrl").getAttribute('data-url');
  //ou
  // let url = window.origin;

  // ESCONDE MENSAGEM DE ERRO SE HÁ ALTERAÇÃO NO CAMPO
  // =================================================
  $(".campo-obrigatorio").change(function(){
    $(this).siblings('label').children(".aviso_label").hide();
    $(this).removeClass('border-danger');
    $(this).addClass('border-primary');
  });

  $(".campo-obrigatorio").keyup(function(e){

    if(e.which == 13 || e.which == '13') {
      return false;
    }

    if(e.which != 13 && e.which != '13') {
        $(this).siblings('label').children(".aviso_label").hide();
        $(this).removeClass('border-danger');
        $(this).addClass('border-primary');
    }
  });


  $(".campo-obrigatorio-senha").keyup(function(){
    $(this).parent().siblings('label').children(".aviso_label").hide();
  });

  /*=======================================================
    FORMULÁRIO DE CADASTRO
  =========================================================*/
  $('.form_cadastro_simples').submit(function (evt) {
    evt.preventDefault();

    // DETALHES DO FORMULÁRIO
    let configForm = {
      texto_botao: "Enviar",
      mostrar_mensagem: true,
      texto_sucesso: "Cadastro efetuado com sucesso",
      desc_sucesso: "Redirecionando",
      redirect: true,
      link_redirect_dinamico: false,
      link_redirect: url+'/login/',
      redirect_com_var: false,
      variaveis: null
    }

    // FUNÇÃO QUE FAZ A SUBMISSÃO
    submitForm($(this), configForm);
  });

    /*=======================================================
      FORMULÁRIO DE CONTATO
    =========================================================*/
    $('.form_contato').submit(function (evt) {
      evt.preventDefault();

      // DETALHES DO FORMULÁRIO
      let configForm = {
        texto_botao: "Enviar",
        mostrar_mensagem: true,
        texto_sucesso: "Mensagem enviada com sucesso",
        desc_sucesso: "Sua mensagem será analisada e entraremos em contato em breve!",
        redirect: false,
        link_redirect_dinamico: false,
        link_redirect: '',
        redirect_com_var: false,
        variaveis: null
      }

      // FUNÇÃO QUE FAZ A SUBMISSÃO
      submitForm($(this), configForm);
    });

    /*=======================================================
      FORMULÁRIO DE RECUPERAR SENHA
    =========================================================*/
    $('.form_rec_senha').submit(function (evt) {
      evt.preventDefault();

      // DETALHES DO FORMULÁRIO
      let configForm = {
        texto_botao: "Enviar",
        mostrar_mensagem: true,
        texto_sucesso: "Solicitação enviada",
        desc_sucesso: "Você receberá um e-mail em instantes com o procedimento",
        redirect: false,
        link_redirect_dinamico: false,
        link_redirect: '',
        redirect_com_var: false,
        variaveis: null
      }

      // FUNÇÃO QUE FAZ A SUBMISSÃO
      submitForm($(this), configForm);
    });

    /*=======================================================
      FORMULÁRIO DE REDEFINIR SENHA
    =========================================================*/
    $('.form_rec_senha_definir').submit(function (evt) {
      evt.preventDefault();

      // DETALHES DO FORMULÁRIO
      let configForm = {
        texto_botao: "Enviar",
        mostrar_mensagem: true,
        texto_sucesso: "Senha redefinida!",
        desc_sucesso: "Redirecionando...",
        redirect: true,
        link_redirect_dinamico: false,
        link_redirect: url+'/login/',
        redirect_com_var: false,
        variaveis: null
      }

      // FUNÇÃO QUE FAZ A SUBMISSÃO
      submitForm($(this), configForm);
    });

    /*=======================================================
    FORMULÁRIO DE CONTATO
  =========================================================*/
  $('.form_redef_senha').submit(function (evt) {
    evt.preventDefault();

    // DETALHES DO FORMULÁRIO
    let configForm = {
      texto_botao: "Enviar",
      mostrar_mensagem: true,
      texto_sucesso: "Senha redefinida!",
      desc_sucesso: "Redirecionando...",
      redirect: true,
      link_redirect_dinamico: false,
      link_redirect: '/painel/',
      redirect_com_var: false,
      variaveis: null
    }

    // FUNÇÃO QUE FAZ A SUBMISSÃO
    submitForm($(this), configForm);
  });


  /*=======================================================
    LOGIN FORM
  =========================================================*/
  $('.form_login').submit(function (evt) {
    evt.preventDefault();

    // DETALHES DO FORMULÁRIO
    let configForm = {
      texto_botao: "Log In",
      mostrar_mensagem: false,
      texto_sucesso: "",
      desc_sucesso: "",
      redirect: true,
      link_redirect_dinamico: false,
      link_redirect: '/painel/',
      redirect_com_var: false,
      variaveis: null
    }

    // FUNÇÃO QUE FAZ A SUBMISSÃO
    submitForm($(this), configForm);
  });

    /*=======================================================
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    !!!!!!!!!!!!!! NÃO ALTERAR DAQUI PARA BAIXO !!!!!!!!!!!!!
    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    =========================================================*/

    /*=======================================================
      FUNÇÃO GERAL PARA OS FORMULÁRIOS DO SITE (NÃO ALTERAR)
    =========================================================*/
    function submitForm(form, configForm){
      let formulario = form;
      let botao = form.find(':submit');
      let spinner = form.find(".spinner");
      let form_action = form.attr("data-action");
      let form_action_caminho = form.attr("data-action-caminho");
      var checaCampos = true;

      botao.addClass('btn-loading');

      // FOREACH PARA TODAS AS CLASSES COM O NOME ABAIXO
      formulario.find(".campo-obrigatorio").each(function() {
        if(!$(this).val()){
          // VOLTA PARA O CAMPO VAZIO
          // $(this).focus();

          $('html, body').animate({
              scrollTop: $(this).offset().top - 200
          }, 200);

          $(this).removeClass('border-primary');
          $(this).addClass('border-danger');
          checaCampos = false;
          return false;
        }
      });

      if(!checaCampos) return false;

      var formData = new FormData(form.get(0));

      // AJAX ================
      // =====================
      $.ajax({
        type : 'POST',
        url  : form_action_caminho+'/form_action/'+form_action+'.php',
        data : formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function()
        {
          spinner.show();
          botao.attr("disabled", true);
          botao.val("Loading...");
        },
        success :  function(response){
          console.log(response);

          if(response.status == "sucesso"){

            if(configForm.mostrar_mensagem == true){
              $("#btn_modal").trigger("click");
              $("#titulo_modal").removeClass("text-danger");
              $("#titulo_modal").addClass("text-primary");
              $("#titulo_modal strong").text(configForm.texto_sucesso);
              $("#modal_mensagem strong").text(configForm.desc_sucesso);
              botao.attr("disabled", false);
              botao.val(configForm.texto_botao);
              spinner.hide();
              formulario.trigger("reset");
            }

            if(configForm.redirect == true){

              if(configForm.redirect_com_var == true){
                // REDIRECIONAR
                let obj = configForm.variaveis;
                let valor_variavel = 'inicial';

                Object.entries(obj).forEach(([indice, valor]) => {

                  if(configForm.link_redirect.includes("?")){
                    for (const [key, value] of Object.entries(response)) {
                      if(key == valor){
                        valor_variavel = value;
                      }else{
                        continue;
                      }
                    }

                    configForm.link_redirect = configForm.link_redirect+"&"+indice+"="+valor_variavel;
                  }else{
                    for (const [key, value] of Object.entries(response)) {
                      if(key == valor){
                        valor_variavel = value;
                      }else{
                        continue;
                      }
                    }

                    configForm.link_redirect = configForm.link_redirect+"?"+indice+"="+valor_variavel;
                  }
                });

                setTimeout(function() {
                  window.location.href = configForm.link_redirect;
                }, 3000);
              }else{
                setTimeout(function() {

                  let link_redirect = "";
                  if(configForm.link_redirect_dinamico == true){
                    link_redirect = response.link_redirect;
                  }else{
                    link_redirect = configForm.link_redirect;
                  }

                  window.location.href = link_redirect;
                }, 3000);
              }

            }else{
              // FECHAR MODAL
              setTimeout(function() {
                $(".btn-close").trigger("click");
              }, 3000);
            }

          }else{
            // SE FOR UM ERRO ESPECÍFICO DE UM CAMPO
            if(typeof response.campo !== 'undefined') {
              $("#aviso_label_"+response.campo).text(response.erro);
              $("#aviso_label_"+response.campo).show();
              $("#aviso_label_"+response.campo).parent().siblings('input').focus();

              spinner.hide();
              botao.attr("disabled", false);
              botao.val(configForm.texto_botao);

              setTimeout(function(){
                $("#aviso_label_"+response.campo).hide();
              }, 5000);

              return false;
            }else{
              // SE FOR UM ERRO MAIS GENÉRICO
              $("#btn_modal").trigger("click");
              $("#titulo_modal").removeClass("text-primary");
              $("#titulo_modal").addClass("text-danger");
              $("#titulo_modal strong").text("Aviso");
              $("#modal_mensagem strong").text(response.erro);
              spinner.hide();
              botao.attr("disabled", false);
              botao.val(configForm.texto_botao);

              // save_log(response.erro);

            }
          }

        },

        error: function(response){
          console.log(response);
          // SE FOR UM ERRO MAIS GENÉRICO
          $("#btn_modal").trigger("click");
          $("#titulo_modal").removeClass("text-primary");
          $("#titulo_modal").addClass("text-danger");
          $("#titulo_modal strong").text("Aviso");
          $("#modal_mensagem strong").text('An unexpected error occurred');
          spinner.hide();
          botao.attr("disabled", false);
          botao.val(configForm.texto_botao);

          // save_log(response);
        }
      });

      // =========================
      // =========================
    }

    // FUNÇÃO PARA SALVAR O ERRO EM UM LOG
    // ===================================
    // function save_log(data){
    //
    //   $.ajax({
    //     url: url+'/wp-content/themes/isrs/form_action/util/save_log.php',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: JSON.stringify(data),
    //     success :  function(response){
    //       console.log('Log de erro registrado.');
    //       // console.log(response);
    //     },
    //
    //     error: function(response){
    //       console.log('Falha no registro de log do erro.');
    //       // console.log(response);
    //     }
    //   });
    //
    // }
    // FUNÇÃO PARA SALVAR O ERRO EM UM LOG
    // ===================================

    // ESCONDE MENSAGEM DE ERRO SE HÁ ALTERAÇÃO NO CAMPO
    // =================================================
    $(".campo-obrigatorio").change(function(){
      $(this).siblings('label').children(".aviso_label").hide();
      $(this).css('border-color', '#ced4da');
    });

    $(".campo-obrigatorio").keyup(function(e){

      if(e.which == 13 || e.which == '13') {
        return false;
      }

      $(this).siblings('label').children(".aviso_label").hide();
      $(this).css('border-color', '#ced4da');
    });

    // $(".campo-obrigatorio").onchange(function(){
    //   $(this).siblings('label').children(".aviso_label").hide();
    //   $(this).css('border-color', '#ced4da');
    // });

    $(".campo-obrigatorio-senha").keyup(function(){
      if(e.which == 13 || e.which == '13') {
        return false;
      }
      $(this).parent().siblings('label').children(".aviso_label").hide();
    });

    // ==========================

    var body = $('body');
  });
