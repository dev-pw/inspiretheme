<?php

/**
 * Template Name: Cadastro
 * Template Post Type: post, page
 * @package WordPress
 * @subpackage inspiretheme
 *
 */
get_header();


include(dirname(__FILE__) . "/../form_action/util/funcoes_uteis.php");
$estados = retorna_estados();

?>

<main role="main">

    <header class="c-page-header">
        <div class="container">
            <h1 class="text-white"><?php the_title(); ?> </h1>
        </div>
    </header>

    <div class="container mt-3">
        <?php get_template_part("template-parts/breadcrumbs"); ?>
    </div>

    <div class="pt-5 u-pb-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 offset-lg-2">

                    <!-- FORM ASSOCIAÇÃO -->
                    <form class="shadow border bg-light-subtle p-4 pt-3 rounded-2 form_cadastro_simples" data-action-caminho="<?php echo get_template_directory_uri() ?>" data-action="associado/cadastro" method="post">

                        <div class="d-flex justify-content-center mb-2">
                            <span class="icon-user-circle-o display-4 text-primary"></span>
                        </div>

                        <p class="text-center fw-bold mb-4 fs-6">Preencha com seus dados de cadastro</p>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary campo-obrigatorio" name="nome_completo" id="nome_completo" placeholder="Nome completo" value="">
                                    <label for="nome" class="fw-bold small text-primary form-label">Nome completo <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_nome" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control border-primary campo-obrigatorio text-lowercase" name="email" id="email" placeholder="E-mail" value="">
                                    <label for="email" class="fw-bold small text-primary form-label">E-mail <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_email" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control cpf_mask border-primary campo-obrigatorio" name="cpf" id="cpf" placeholder="CPF" value="">
                                    <label for="cpf" class="fw-bold small text-primary form-label">CPF <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_cpf" style="display:none"> </span></label>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control tel_mask border-primary campo-obrigatorio" name="tel" id="tel" placeholder="Telefone" value="">
                                    <label for="tel" class="fw-bold small text-primary form-label">Telefone <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_tel" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control crm_mask border-primary campo-obrigatorio" name="crm" id="crm" placeholder="CRM" value="">
                                    <label for="crm" class="fw-bold small text-primary form-label">CRM <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_crm" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select border-primary campo-obrigatorio" id="floatingSelect" name="crm_uf" aria-label="UF">
                                        <option disabled value="" selected>Selecione</option>
                                        <?php foreach ($estados as $uf => $name) {
                                            echo '<option value="' . $uf . '"> ' . $uf . ' - ' . $name . '</option>';
                                        } ?>
                                    </select>
                                    <label for="floatingSelect" class="fw-bold small text-primary form-label"> CRM UF <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_uf" style="display:none"> </span> </label>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-4">
                                <h5 class="bg-primary text-white p-3 mb-4">
                                    <strong>Endereço </strong>
                                </h5>
                            </div>

                            <div class="col-lg-4">
                                <!-- CEP -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary cep_mask campo-obrigatorio" name="cep" id="cep" placeholder="CEP">
                                    <label for="cep" class="fw-bold small text-primary form-label">CEP <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_cep" style="display:none"> </span></label>
                                </div>
                            </div>



                            <div class="col-lg-4">
                                <!-- RUA -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary preencher_auto_rua campo-obrigatorio" name="endereco" id="endereco" placeholder="Endereco">
                                    <label for="rua" class="fw-bold small text-primary form-label">Endereco <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_rua" style="display:none"> </span></label>
                                </div>
                            </div>



                            <div class="col-lg-2">
                                <!-- NÚMERO -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary preencher_auto_numero campo-obrigatorio" name="num" id="num" placeholder="Número">
                                    <label for="numero" class="fw-bold small text-primary form-label">Número <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_numero" style="display:none"> </span></label>
                                </div>
                            </div>



                            <div class="col-lg-2">
                                <!-- COMPLEMENTO -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary" name="compl" id="compl" placeholder="compl">
                                    <label for="complemento" class="fw-bold small text-primary form-label">Compl.<span class="aviso_label text-danger px-2" id="aviso_label_complemento" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- BAIRRO -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary preencher_auto_bairro campo-obrigatorio" name="bairro" id="bairro" placeholder="Bairro">
                                    <label for="bairro" class="fw-bold small text-primary form-label">Bairro <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_bairro" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <!-- CIDADE -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control border-primary preencher_auto_cidade campo-obrigatorio" name="cidade" id="cidade" placeholder="Cidade">
                                    <label for="cidade" class="fw-bold small text-primary form-label">Cidade <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_cidade" style="display:none"> </span></label>
                                </div>
                            </div>

                            <div class="col-lg-4">

                                <!-- ESTADO -->
                                <div class="form-floating mb-3">
                                    <select class="form-select border-primary preencher_auto_estado campo-obrigatorio" name="estado" id="estado" aria-label="Estado">
                                        <option value="" selected disabled>Selecione</option>
                                        <?php foreach ($estados as $uf => $name) {
                                            echo '<option value="' . $uf . '"> ' . $uf . '</option>';
                                        } ?>
                                    </select>
                                    <label for="estado" class="fw-bold small text-primary form-label opacity-100">Estado <span class="text-danger">*</span> <span class="aviso_label text-danger px-2" id="aviso_label_estado" style="display:none"> </span></label>
                                </div>

                            </div>

                            <div class="col-lg-12 mt-4">
                                <h5 class="bg-primary text-white p-3 mb-4">
                                    <strong>Senha de acesso </strong>
                                </h5>
                            </div>

                            <!-- SENHA -->
                            <div class="col-md-12">
                                <div class="campo-senha">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control border-primary campo-obrigatorio" name="senha" id="senha" placeholder="Senha">
                                        <label for="senha" class="fw-bold small text-primary form-label">Senha <span class="text-danger">*</span>
                                            <span class="aviso_label text-danger px-2" id="aviso_label_senha" style="display:none"> </span>
                                        </label>
                                    </div>
                                    <span class="campo-senha__ver" style="color: #105075;"> <span class="icon-eye fs-5"></span> </span>
                                </div>
                            </div>
                        </div>



                        <div class="row my-4">
                            <div class="col-md-12">
                                <small>
                                    <p class="mb-2 text-primary">
                                        <strong> Requisitos para senha válida: </strong>
                                    </p>
                                    <p class="mb-0 text-primary">
                                        Mínimo de 8 caracteres, um caractere especial e um número
                                    </p>
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center justify-content-md-end">
                                <button type="submit" name="button" class="btn btn-primary w-100">
                                    ENVIAR

                                    <!-- SPINNER -->
                                    <span class="spinner" style="display: none">
                                        <div class="spinner-border spinner-border-sm ml-2" role="status">
                                            <span class="sr-only"></span>
                                        </div>
                                    </span>
                                    <!-- SPINNER -->
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</main>


<?php get_footer(); ?>