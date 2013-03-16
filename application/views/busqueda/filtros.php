<div id="sidebar" class="left clearfix">
    
    <script type="text/javascript">
        $(document).ready(function(){
            
            var temas = (<?=($hidden_filter_temas)?1:0;?> || <?= (count($temas) < 15)?1:0 ?>);
            var servicios = (<?=($hidden_filter_servicios)?1:0;?> || <?= (count($instituciones) < 15)?1:0 ?>);
           
            if(temas) toggle("#f_temas","#temas_filtro");
            if(servicios) toggle("#f_instituciones","#instituciones_filtro");
            
            $("#f_temas").click(function(){toggle(this,"#temas_filtro");});
            $("#f_instituciones").click(function(){toggle(this,"#instituciones_filtro");});
            
        });
        
        function toggle(thiselement,element){
            $(element).toggleClass('blink','fast').toggle("fast").toggleClass('blink','slow');
            $(thiselement).toggleClass('on');
            
            $("#sidebar").attr('style', 'height:auto;');
        }
        
    </script>
    
    <h2>Filtrar resultados por <img src="assets/images/bullet_busqueda.png" alt="ico" /></h2>
    <p class="instruccion">Obtenga resultados más específicos, seleccione temas relacionados o si conoce la institución que lo realiza. </p>
    <form method="post" action="">
        <input type="hidden" name="hecho" value="<?= (isset($hidden_hecho)) ? $hidden_hecho : ""; ?>" />
        <input type="hidden" name="buscar" value="<?= (isset($hidden_string)) ? $hidden_string : ""; ?>" />
        <input type="hidden" name="genero" value="<?= (isset($genero)) ? $genero : ""; ?>" />
        <input type="hidden" name="edad" value="<?= (isset($edad)) ? $edad : ""; ?>" />
        
        <?php
        $uri_conf = "";
        
        if(isset($hidden_hecho)){
            $uri_conf .= "&amp;hecho=".$hidden_hecho;
        }
        if(isset($hidden_string)){
            $uri_conf .= "&amp;buscar=".$hidden_string;
        }
        if(isset($genero)){
            $uri_conf .= "&amp;genero=".$genero;
        }
        if(isset($edad)){
            $uri_conf .= "&amp;edad=".$edad;
        }
        
        ?>

        <p id="f_temas" class="toggle filter_title lightblue-text"><!--<img src="assets/images/bullet_new_big.png" alt="Temas" />-->Temas</p>
        <?php 
        
        echo '<ul id="temas_filtro" class="text-small toggable">';
        if (isset($temas) && count($temas) > 0) {
            
            $finst = "";
            if($hidden_filter_servicios)
                $finst = "instituciones=".implode(",",$hidden_filter_servicios)."&amp;";            
            
            foreach ($temas as $tema) {
                $aux = $hidden_filter_temas;
                $class = 'on';
                if(!in_array($tema->id,$hidden_filter_temas)){
                    $class = '';
                    $aux[] = $tema->id;
                }else{
                    unset($aux[array_search($tema->id, $aux)]);
                }
                echo "<li class=' $class'>";
                echo "" . anchor("buscar/fichas/?".$finst."temas=".implode(",",$aux).$uri_conf,$tema->nombre,array('class'=>$class)) ;
                echo "&nbsp; (<span>" . $tema->numero_fichas . "</span>)";
                echo "</li>";
            }
        }else{
            echo "<li><span class='small-text'>Las fichas en el resultado no poseen temas asociados</span></li>";
        }
        echo "</ul>";
        ?>

        <?php if (isset($instituciones) && count($instituciones) > 0) { ?>
            <p id="f_instituciones" class="toggle filter_title lightblue-text"><!--<img src="assets/images/bullet_new_big.png" alt="Institución" />-->Institución</p>
            <?php
            echo "<ul id='instituciones_filtro' class='text-small toggable'>";
            
            $ftemas = "";
            if($hidden_filter_temas)
                $ftemas = "temas=".implode(",",$hidden_filter_temas)."&amp;";
            
            foreach ($instituciones as $institucion) {
                $aux = $hidden_filter_servicios;
                $class = 'on';
                if(!in_array($institucion->codigo,$hidden_filter_servicios)){
                    $class = '';
                    $aux[] = $institucion->codigo;
                }else{
                    unset($aux[array_search($institucion->codigo, $aux)]);
                }
                echo "<li class='long $class'>";
                echo  "" . anchor("buscar/fichas/?".$ftemas."instituciones=".implode(",",$aux).$uri_conf,$institucion->nombre.( ($institucion->sigla) ? ' ('.$institucion->sigla.')' : '' )   ,array('class'=>$class));
                echo "&nbsp; (<span>" . $institucion->numero_fichas . "</span>)";
                
                echo "</li>";
            }
            echo "</ul>";
        }
        ?>

        <!--<input type="submit" class="bt_buscar2" name="filtrar_busqueda" value="Filtrar Búsqueda">-->
    </form>
</div>