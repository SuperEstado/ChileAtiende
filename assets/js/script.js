$(document).ready(function(){
    $(".overlay").overlay({
        mask: "#000"
    });
    
    $(".ajaxForm").submit(function(){
        if(typeof tinyMCE !== 'undefined')
            tinyMCE.triggerSave();
        var form=this;
        $.ajax({
            url: form.action,
            data: $(form).serialize(),
            type: form.method,
            dataType: "json",
            success: function(response){

                if(response.validacion){
                    window.location=response.redirect;
                }
                else{
                    $(".validacion").html(response.errores);
                    $('html, body').animate({
                        scrollTop: $(".validacion").offset().top-10
                    })
                }
            },
            error: function(response){
                $(".validacion").html("<p class='error'>Hubo un error al procesar la peticion: <br/> "+response.errores+" </p>");
                $('html, body').animate({
                    scrollTop: $(".validacion").offset().top-10
                })
            }
        });
        return false;
    });
        
    if($("#tag-temas").length){
        $("#topics").css('height','0px');
        $("#topics").css('overflow','hidden');
        $("#secondarycontent").css('position','absolute');
        
        $("#secondarycontent").css('z-index','5');
        $("#secondarycontent").css('top','150px');
        var h_secondarycontent = $("#secondarycontent").height();
        
        $("#drop-primero").css('display','none');

        $("#temas-wrapper").click(function(){
            $("#categorypane #temas-wrapper h2.temas_title").html('Seleccione su principal tema de interés');
            $("#categorypane #temas-wrapper p.temas_tagline").html('Puede seleccionar de las etiquetas a continuación.');
                  
            $("#secondarycontent").animate({
                top: '280px'
            },500);

            $("#temas-wrapper").unbind('click');
        });
 
 
    }


    $(".reparticiones").scrollable().navigator();

}); // Fin $(document).ready
