<p>Se ha ingresado un nuevo comentario en el formulario de contacto de ChileAtiende</p>

<h3>Datos de contacto</h3>
<ul>
    <li>Nombres: <?=$contacto->nombre?></li>
    <li>Apellido Paterno: <?=$contacto->a_paterno?></li>
    <li>Apellido Materno: <?=$contacto->a_materno?></li>
    <li>Correo Electronico: <?=$contacto->email?></li>
</ul>

<h3><?=$contacto->asunto?></h3>

<p><?=nl2br($contacto->comentario)?></p>