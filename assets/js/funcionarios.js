$(document).ready(function() {

    $("p.abstract").hide();
    $("section.result").hover(function(){
        $(this).addClass("focused");
    },
    function(){
        $(this).removeClass("focused");
    });

    $(".modalInput").overlay({
            // some mask tweaks suitable for modal dialogs
            mask: {
                    color: '#ebecff',
                    loadSpeed: 200,
                    opacity: 0.9
            }
    });

    $(".printbutton").bind("click",function() {
        id = $(this).attr('id');
        loadiFrame(base_url+"fichas/ver/"+id)
        $("#myiframe").load(function() {
            window.frames['myname'].focus();
            window.frames['myname'].print();
        });
        return false;
    });

    $("a.resultado_more_info").toggle(function(){
        $(".focused h2 a").css("background-position","-138px -430px");
        $(".focused p.abstract").slideDown('fast');
        return false;
    },
    function(){
        $(".focused h2 a").css("background-position","-138px -162px");
        $(".focused p.abstract").slideUp('fast');
        return false;
    });	
    $(".scrollable").scrollable().autoscroll();

    $(".star").click(function(){
        $.post(base_url+"funcionarios/favoritos/click/"+$(this).attr('id'),function(response){
            //console.log(response);
            });
        if($(this).html() == "Quitar Favorito"){
            $(this).html("Agregar Favorito");
            $(this).addClass('off');
        }else{
            $(this).html("Quitar Favorito");
            $(this).removeClass('off');
        }

    });

});

function loadiFrame(src){
    $(".iframe").html("<iframe id='myiframe' name='myname' src='" + src + "' />");
}
