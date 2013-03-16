<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-cl" xml:lang="es-cl">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>Autentificación</title>
        <base href="<?= base_url() ?>"> </base>
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico"  />
        <link rel="stylesheet" type="text/css" href="assets/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/login.css" />
        <script type="text/javascript">
            var base_url="<?= base_url() ?>";
            var site_url="<?= site_url() ?>";
        </script>
    </head>

    <body>
        <div id="topbar"></div>
        <div id="wrapper">
            <div id="header">
                <h1 class="logo"><a>Gobierno de Chile</a></h1>
                <div id="tools">
                    <h1 class="sublogo">CMS</h1>
                    <h1 class="seccion">Acceso</h1>
                </div>
            </div>
            <?= $this->session->flashdata('message') ? '<div class="error">' . $this->session->flashdata('message') . '</div>' : '' ?>

            <form action="<?= current_url() ?>" method="post" style="border: 4px solid #ccc; width: 300px; padding: 20px;  margin: 20px auto;">
                <h2>¿Has olvidado tu contraseña?</h2>
                <p>Para restablecer la contraseña, escribe la dirección de correo electrónico completa que utilizas para acceder a tu cuenta.</p>
                <?php echo validation_errors('<p class="error">', '</p>'); ?>
                <table class="formTable">
                    <tr>
                        <td><label>E-Mail</label></td>
                        <td><input size="35" type="text" name="email" value="<?php echo set_value('email'); ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><input class="boton" type="submit" value="Enviar" /></td>
                    </tr>
                </table>
            </form>
            
            <div style="text-align: center;"><a href="<?= site_url('backend/autenticacion/login') ?>"><< Volver al Login</a></div>

        </div>

    </body>
</html>