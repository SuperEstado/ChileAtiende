// perform JavaScript after the document is scriptable.
$(function() {
    var TextSize = '14';
    var tmpSize = '14';
    $('.text-size-max').click(function(e){
        e.preventDefault();
        if(TextSize == tmpSize && tmpSize < 20) {
            TextSize = parseInt(tmpSize) + 2;
            tmpSize = TextSize;
        }
        $('#content').attr('style','font-size:'+TextSize+'px');
    });
    $('.text-size-min').click(function(e){
        e.preventDefault();
        if(TextSize == tmpSize && tmpSize > 14) {
            TextSize = parseInt(tmpSize) - 2;
            tmpSize = TextSize;
        }
        $('#content').attr('style','font-size:'+TextSize+'px');
    });

    $("input[placeholder]").placeholder({
        blankSubmit: true
    });
  
    if(!$.cookie('overlayModuloAtencion')){
        $("#moduloatencion").overlay({
            mask: {
                color: '#000',
                loadSpeed: 200,
                opacity: 0.5
            },
            load: true,
            closeOnClick: false,
            closeOnEsc: false
        });
    } 
    $('#setModulo').on('click', function(e){
        if(!$.cookie('overlayModuloAtencion') && $('#id_modulo').val() ){
            $.cookie('overlayModuloAtencion', $('#id_modulo').val(), {
                expires: 10950,//10950 equivale a 30 anios
                path: '/',
                domain: '.chileatiende.cl'
            });
        } else {
            $('.msgerror').html('<p class="error">Debes seleccionar un módulo</p>');
            return e.preventDefault();
        }
    });
    if($.cookie('overlayModuloAtencion')) {
        var NombreModulo = $.cookie('overlayModuloAtencion');
        $('.moduloatencion').html('Nro Módulo Atención: '+ NombreModulo +' - <a href="'+site_url+'portada/modulo/" id="killthecookiemonster">Salir</a>');
    }
    
    $('#killthecookiemonster').on('click', function(){
        $.cookie('overlayModuloAtencion', null, {
            path: '/', 
            domain: '.chileatiende.cl'
        }); 
    });


    /* Acciono los botones de filtro */
    $('#dynamic li input[type=radio]').live('change',function(event){
        $(this).closest("li").siblings().removeClass("current");
        $(this).closest("li").addClass("current");
    });

    /* El presionar en boton buscar*/
    $('a#ver_resultado').live('click',function(event){
        temas = Array()
        site_url = $("form#temas_form").attr('action')
        label_principal = $(".tema-principal span").html()
        id_principal = $(".tema-principal").attr('id').substring(4)
        if(id_principal) temas.push(id_principal);
        edad = $('#minifilter input').serialize();
        genero = $('#minifilter select').serialize();
        window.location.href = site_url+"/?tema="+id_principal+"&"+edad+"&"+genero;
        return false;
    });

    /* Accionar sobre los botones de orden */
    $("#static li input[type=radio]").live('click',function(event){
        if($(this).closest("li").hasClass("current")||$(this).closest("li").hasClass("current2")){
            if($(this).closest("li").hasClass("current")){
                $(this).closest("li").removeClass("current");
                $(this).closest("li").addClass("current2");
            }
            else if($(this).closest("li").hasClass("current2")){
                $(this).closest("li").removeClass("current2");
                $(this).closest("li").addClass("current");
            }

            if($("input[name=order_type]").attr("value") == "desc"){
                $("input[name=order_type]").attr("value","asc")
            }
            else if($("input[name=order_type]").attr("value") == "asc"){
                $("input[name=order_type]").attr("value","desc")
            }

        }else{
            //Cambio la clase
            $(this).closest("li").siblings().removeClass("current");
            $(this).closest("li").siblings().removeClass("current2");
            $("input[name=order_type]").attr("value","desc")
            $(this).closest("li").addClass("current");
        }
    });

    // setup ul.tabs to work as tabs for each div directly under div.panes
    $("ul.nav").tabs("div.panes > div");
    $("ul.nav2").tabs("div.panes2 > div");
    
    //Antispam formulario de contacto
    $("form#contactoForm").append("<input type='hidden' name='greh5bhyj54' value='1' />");
    
    //cambia vista listado instituciones
    $('.lista a').on('click', function(e){
        e.preventDefault();
        $('#instituciones ul li').attr('style','display:block; width:520px');
    });
    $('.grupo a').on('click', function(e){
        e.preventDefault();
        $('#instituciones ul li').attr('style','display:inline-block; width:292px');
    });

});




function loadRating(container, fichaId){
    $(container).html('¿Te parece útil esta información?: <span class="rating'+fichaId+'"></span> <span class="nevaluaciones"></span>');

    $.getJSON(site_url+"fichas/ajax_get_evaluaciones_stats/"+fichaId+"?timestamp="+new Date().getTime(), function(response){
        $(container).find(".nevaluaciones").text("("+response.nevaluaciones+")");

        $(container).find(".rating"+fichaId).raty({
            path: "assets/js/jquery.raty/img",
            half: true,
            hintList: ['sin utilidad', 'poco útil', 'regular', 'útil', 'muy útil'],
            start: response.promedio,
            readOnly: !response.canEvaluar,
            click: function(score, event){
                $(container).empty();
                $.post(site_url+"evaluaciones/evaluar/"+fichaId,"rating="+score,function(){
                    loadRating(container, fichaId);
                });
            }
        });
    });
}

// Iguala alturas entre contenedor y sidebar
function getOff(){
    x = document.getElementById('content');
    return x.offsetHeight;
}

/*tree mapa sitio*/
$(document).ready(function() {
    $("#root ul").each(function() {
        $(this).css("display", "none");
    });
    $("#root .category").click(function(e) {
        e.preventDefault();
        var childid = "#" + $(this).attr("rel");
        //alert(childid);
        if ($(childid).css("display") == "none") {
            $(childid).css("display", "block");
        }
        else {
            $(childid).css("display", "none");
        }
        if ($(this).hasClass("cat_close")) {
            $(this).removeClass("cat_close").addClass("cat_open");
        }
        else{
            $(this).removeClass("cat_open").addClass("cat_close");
        }
    });
});






(function($){
    $.fn.extend({

        customStyle : function(options) {
            if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
                return this.each(function() {

                    var currentSelected = $(this).find(':selected');
                    $(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({
                        position:'absolute',
                        opacity:0,
                        fontSize:$(this).next().css('font-size')
                    });
                    var selectBoxSpan = $(this).next();
                    var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
                    var selectBoxSpanInner = selectBoxSpan.find(':first-child');
                    selectBoxSpan.css({
                        display:'inline-block'
                    });
                    selectBoxSpanInner.css({
                        width:selectBoxWidth,
                        display:'inline-block'
                    });
                    var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
                    $(this).height(selectBoxHeight).change(function(){
                        // selectBoxSpanInner.text($(this).val()).parent().addClass('changed');   This was not ideal
                        selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
                    // Thanks to Juarez Filho & PaddyMurphy
                    });

                });
            }
        }
    });
})(jQuery);

/*IGUALA TAMAÑOS CAJAS BAJO BANNER HOME*/
$(document).ready(function(){
    var ch = $("div#contenido_hot").innerHeight();
    var dest = $("div#destacados").innerHeight();
    var gral = $("div#general").innerHeight();
    var v = [ch,dest,gral];
    var elQueManda = Math.max.apply(0,v);
    
    $("div#contenido_hot").attr('style','height:'+elQueManda+'px');
    $("div#destacados").attr('style','height:'+elQueManda+'px');
    $("div#general").attr('style','height:'+elQueManda+'px');
    
});
