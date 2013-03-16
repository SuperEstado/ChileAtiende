$(document).ready(function() {
    //llamadas para que funcione el widget etapas
    loadHechos(4);
    $("#my-list li:nth-child(4)").addClass('on');
    
    /*
    $("#etapas .paso1 input").click(function(){
            $("#etapas .paso1 li").removeClass('on');
            $(this).parent().parent().addClass('on');
            loadHechos(this.value);
        });
    */
        
    /* Acciono los botones de filtro */
    $('#my-list li label').click(function(event){
        $(this).closest("li").siblings().removeClass("on");
        $(this).closest("li").addClass("on");
        $(this).find('input').attr('checked','checked');
        //console.log( $("#my-list li label input:radio:checked").val() );
        loadHechos( $("#my-list li label input:radio:checked").val() );
    });

    //$("#etapas .paso2 input").live("change",function(){
    //        $("#etapas .paso2 label").removeClass('on');
    //        $(this).parent().addClass('on');
    //    });

});

function loadHechos(etapaId){



        $.getJSON(site_url+'hechos/ajax_get_hechos', "etapa_id="+etapaId, function(response){
            
            response=response.HechosVida;
            var html="";
            for(var i in response){
                if( response[i].nombre != undefined ) {
                    html+="<li>";
                    html+="<label for='hecho-"+response[i].id+"'>";
                    html+="<a href='buscar/fichas/?etapa="+etapaId+"&hecho="+response[i].id+"&button=Buscar'>";
                    html+=response[i].nombre;
                    html+="</a></label>";
                    html+="</li>";
                }
            }
            $("#etapas .paso2").find("ul").html(html)
        });
    }
