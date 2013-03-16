<p>
    Hola<br />
    tu amigo <?=$contacto->nombres?> quiere compartir la siguiente información contigo.
    <a href="<?=$this->input->server('HTTP_REFERER');?>"><?=$this->input->server('HTTP_REFERER');?></a>
</p>

<p>
    Comentario agregado por tu amigo:
    <?=nl2br($contacto->comentarios)?>
</p>

