$(document).ready(function() {
    // Creating hoverscroll with fixed arrows
    $('#my-list').hoverscroll({
        fixedArrows: false,
        rtl: true,
        vertical: true,
        width: 170,
        height: 300
    });
    // Starting the movement automatically at loading
    // @param direction: right/bottom = 1, left/top = -1
    // @param speed: Speed of the animation (scrollPosition += direction * speed)
    var direction = -1,
    speed = 2;
    $("#my-list")[0].startMoving(direction, speed);

    /* Acciono los botones de filtro */
    $('#my-list li label').click(function(event){
        $(this).closest("li").siblings().removeClass("on");
        $(this).closest("li").addClass("on");
        $(this).find('input').attr('checked','checked');
    });

    //MODIFICAR ESTAS LINEAAS PARA AGREGAR VALIDACION DE TEMAS

    $("#button").click(function(){

        edad = $("input#edad").val()
        if(edad != ""){
            if(isNumber(edad)){
                if(edad < 0){
                    alert("La edad debe ser un número positivo")
                    return false;
                }

            }else{
                alert("La edad debe ser un número positivo")
                return false;
            }
        }
        return true;
        
    });

});

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}


$(document).ready(function(){
    $('#genero').customStyle();
});