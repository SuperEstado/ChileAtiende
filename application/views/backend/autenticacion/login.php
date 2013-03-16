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

            <?php echo validation_errors(); ?>

            <form method="post" action="<?= site_url('backend/autenticacion/login') ?>" style="border: 4px solid #ccc; width: 340px; padding: 20px;  margin: 20px auto;">
                <table class="formTable">
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" value="<?php echo set_value('email'); ?>" size="30" /></td>
                    </tr>
                    <tr>
                        <td>Contrase&ntilde;a</td>
                        <td><input type="password" name="password" size="30" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;"><a href="<?= site_url('backend/autenticacion/forgot_password') ?>">Olvidé mi contraseña</a></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;"><button type="submit" class="login">Ingresar</button></td>
                    </tr>
                </table>
            </form>

        </div>

    </body>
</html>