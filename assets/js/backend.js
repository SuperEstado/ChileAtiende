function createUploader(){
    var uploader = new qq.FileUploader({
        element: document.getElementById('uploads'),
        action: site_url+'backend/uploads/subirArchivo',
        multiple: true,    
        template: '<div class="qq-uploader">' + 
        '<div class="qq-upload-drop-area"><span>Arrastre sus archivos aquí</span></div>' +
        '<div class="qq-upload-button">Cargar sus archivos</div>' +
        '<ul class="qq-upload-list"></ul>' + 
        '</div>',
        fileTemplate: '<li>' +
        '<span class="qq-upload-file"></span>' +
        '<span class="qq-upload-spinner"></span>' +
        '<span class="qq-upload-size"></span>' +
        '<a class="qq-upload-cancel" href="#">Cancelar</a>' +
        '<span class="qq-upload-failed-text">Falló</span>' +
        '</li>'
    });
    
}

$(document).ready(function(){
    //habilita/deshabilita la posibilidad de llenar datos extendidos para fichas personas
    $('#personas').click(function(){
        $('#clasificacion-personas').attr('style','display:block');
    });
    $('#ambos').click(function(){
        $('#clasificacion-personas').attr('style','display:block');
    });
    $('#empresas').click(function(){
        $('#clasificacion-personas').attr('style','display:none');
    });
    
    //$("ul li a[title]").tooltip();
    //hermosea los select list
    $(".chzn-select").chosen(); 
    
    $("#vista").click(function(){ 
        $("#secondary").attr('id','secondary-icon').toggle( 'blind', options, 500 );
    });

    $("#crear").click(function(){
        $("#password").attr('value','');
        $("#confirm_password").attr('value','');
        $(".crear").attr('style', 'display:block');
        $(".generar").attr('style', 'display:none');
    });
    
    $("#generar").click(function(){
        $("#generated_pw").attr('value','');
        $(".crear").attr('style', 'display:none');
        $(".generar").attr('style', 'display:block');
    });
    
    //efecto acordeon menu izquierdo sistema
    $( "#secondary h2" ).click(function(){
        if($(this).next(".content").css("display") == "block"){
            $(this).next(".content").animate({
                opacity:0, 
                height: 0
            },500,function(){
                $(this).css('display','none');
            });
        }else{
            $(".content").animate({
                opacity:0, 
                height: 0
            },100,function(){
                $(this).css('display','none');
            });
            $(this).next(".content").animate({
                opacity:0,
                opacity:1, 
                height: '100%'
            },200,function(){
                $(this).css('display','block');
            });
        }

    });
    
    //despliega/oculta acceso rápido de la portada
    var cnt = 1;
    $(".graph").click( function(){
        var options = {};
        $( ".stats" ).toggle( 'blind', options, 500 );
        if(cnt) {
            $('.graph').html('Gráficos (+)');
            cnt=0;
        } else {
            $('.graph').html('Gráficos (-)');
            cnt=1;
        }
    });
    
    //carga editor wyswyg tinimce
    
    tinyMCE.init({
        // General options
        mode : "exact",
        theme : "advanced",
        elements : "editorA,editorB,editorC,editorD,editorE,editorF,editorG,editorH,editorI,editorJ,editorK,editorL,editorM,editorN,editorO,editorP,editorQ,editorR,editorS,editorT,editorU,editorV,editorW,editorX,editorY,editorZ",
        //plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        //language : "es",
        //gecko_spellcheck : true,
        //valid_elements: "a,strong/b,br,ul,li,ol,p,table,tr,td,iframe",
        //spellchecker_languages : "+Spanish=es,English=en",
        //extended_valid_elements : "a[href|target=_blank],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder]",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,|,cut,copy,paste,pasteword,|,bullist,numlist,|,undo,redo,|,removeformat,|,outdent,indent,blockquote,|,link,unlink,|,search,replace,|,code,preview",
        theme_advanced_buttons2 : "tablecontrols,spellchecker,media",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        
        handle_event_callback : function(event,editor){
            if(event.type == 'keypress' || event.keyCode == '8' || event.keyCode == '46'){
                //Esto permite que aparezca el boton comentar en los campos tinyMCE
                $("#"+editor.id).next().next().find('span').show('fast')
            }
        }
    });
    
    $(".tagitTags").tagit({
        source: site_url+"backend/tags/ajax_get_tags",
        forceSelect: false,
        name: "tags"
    });


    $(".selectEntidades").change(function(){
        if(this.value==0){
            $(".selectServicios").empty();
            var html="<option value='0'>Todos</option>";
            $(".selectServicios").html(html);
            $(".selectServicios").trigger("liszt:updated");
        }
        else{
            $.getJSON(site_url+'backend/backend/ajax_get_servicios/'+this.value,null,function(response){
                $(".selectServicios").empty();
                var html="<option value='0'>Todos</option>";

                $.each(response,function(index,value){
                    html+="<option value='"+value.codigo+"'>"+value.nombre+"</option>";
                });
                $(".selectServicios").html(html);
                $(".selectServicios").trigger("liszt:updated");
            });
        }
        
        
    });

    //Parte del formulario que te permite ingresar varios items de un select en una tabla.
    $(".widgetSelectTable .agregar").click(function(){
        var id=$(".widgetSelectTable select option:selected").val(); 
        //console.log(id);
        if(id!='') {
            var nombre=$(".widgetSelectTable select option:selected").attr('otro');
            var colorTmp=$("#tablaHV tr:last").attr('style');
            if(colorTmp)
                var color = colorTmp.split(':');
            else
                var color = ' #ededed';

            color = ((color==' #ededed')||(color[1].toLowerCase()==' #ededed')||(color[1]==' rgb(237, 237, 237);')) ? '#FFF' : '#EDEDED';

            $(".widgetSelectTable table tbody").append("<tr style='background-color: "+color+"'><td><span style='font-weight: bold;'>"+nombre+"</span><input type='hidden' name='hechosvida[]' value='"+id+"' /></td><td><a href='#' class='eliminar'>Eliminar</a></td></tr>");
        }
        return false;
    });
    $(".widgetSelectTable .eliminar").live("click",function(){
        $(this).parent().parent().remove();
        
        return false;
    });
    
    $("a.popup").click(function(){
        var url=this.href;
        newwindow=window.open(url,'window'+Math.random(),'height=880,width=760,scrollbars=yes,location=no,toolbar=no,resizable=yes');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }); 
    
    $("a.popupcompara").click(function(){
        var url=this.href;
        newwindow=window.open(url,'window'+Math.random(),'height=768,width=1024,scrollbars=yes,location=no,toolbar=no,resizable=yes');
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }); 
    
    $(".dragProyecto").draggable({
        revert: "invalid",
        helper: "clone"
    });

    $(".dropProyecto").droppable({
        accept: ".dragProyecto",
        //activeClass: 'dropProyectoActive',
        hoverClass: 'dropProyectoActive',
        drop: function(ev, ui) {
            var dropProyecto=$(this);
            var proyectosList=$(dropProyecto).find("ul.proyectosList");
            var compareButton=$(dropProyecto).find("a.compareButton");
            var cleanButton=$(dropProyecto).find("a.clear");
            $(".dropProyecto").addClass("dropProyectoActive");
            if($(proyectosList).find("li").size()>=2){
                alert("Solo se pueden comparar 2 revisiones a la vez.");
            }
            else{
                $(ui.draggable).addClass("dropProyectoActive");
                var id=$(ui.draggable).find(".idItem").text();
                $(proyectosList).append("<li>Revisión <span class='idProyecto'>"+id+"</span></li>");
                if ($(proyectosList).find("li").size()==2){
                    var a=$(proyectosList).find("li:first .idProyecto").text();
                    var b=$(proyectosList).find("li:last .idProyecto").text();
                    $(compareButton).attr("href",site_url+"backend/fichas/ajax_ficha_comparar/"+a+"/"+b);
                    $(compareButton).show();
                    $(cleanButton).show();

                    $(".dropProyectoActive").addClass("dropProyectoComplete");
                    $(".dropProyectoActive").removeClass("dropProyectoActive");
                }
            }
        }
    });

    $(".dropProyecto .clear").click(function(){
        var dropProyecto=$(".dropProyecto");
        var proyectosList=$(dropProyecto).find("ul.proyectosList");
        var compareButton=$(dropProyecto).find("a.compareButton");
        var cleanButton=$(dropProyecto).find("a.clear");
        $(".dropProyectoComplete").removeClass("dropProyectoComplete");
        $(proyectosList).find("li").remove();
        $(compareButton).hide();
        $(cleanButton).hide();


        return false;
    });
    
    $('.ajaxOverlay').overlay({
        mask: {
            color: '#000000',
            loadSpeed: 200,
            opacity: 0.8
        },
        onBeforeLoad: function() {
            var url=this.getTrigger().attr("href");
            var wrapper=this.getOverlay().find(".wrapper");
            var loading=this.getOverlay().find(".loading");
            loading.show();
            wrapper.empty();
            wrapper.load(url, function(){
                loading.hide();
            });
        }
    });
    
    /*Funciones para la pantalla editar de ficha*/

    $('.comentario').click(function(){
        $(this).next('.comentario_texto').toggle('slow');
    });

    $('.ajaxForm input,.ajaxForm textarea').keyup(function(e){
        $(this).next('.comentario_wrap').find('.comentario').show("fast");
    });

    //Para generar el preview del codigo del proyecto
    //se comprueba que exista el selector de instituciones, de no encontrarse, se
    //parametriza para obtener el código de la institucion desde un input oculto
    $("select[name=servicio_codigo]").change( codigoPreview );

    if($("#uploads").length) {
        createUploader();
    }
});

function suggestPassword(passwd_form) {
    // restrict the password to just letters and numbers to avoid problems:
    // "editors and viewers regard the password as multiple words and
    // things like double click no longer work"
    var pwchars = "abcdefhjmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWYXZ#!$%()=";
    var passwordlength = 8;    // do we want that to be dynamic?  no, keep it simple :)
    var passwd = passwd_form.generated_pw;
    passwd.value = '';

    for ( i = 0; i < passwordlength; i++ ) {
        passwd.value += pwchars.charAt( Math.floor( Math.random() * pwchars.length ) )
    }
    passwd_form.password.value = passwd.value;
    passwd_form.confirm_password.value = passwd.value;
    //passwd_form.text_pma_pw2.value = passwd.value;
    return true;
}


//Para generar el preview del codigo del proyecto
function codigoPreview(){ 
    var servicio=$("select[name=servicio_codigo]").val();
    
    $("input.codigo_preview").val(servicio);
}

function generarCodigo(){
    var servicio_dueno=$(".codigo_preview").val();
    $.get(site_url+"backend/fichas/ajax_generar_codigo/"+servicio_dueno,null,function(data){
        $("input[name=correlativo]").val(data);
    });

    return false;
}