$(document).ready(function(){
    $("div#howto_tramite div").hide();
    $("ul.nav li:first a").addClass("current").show();
    $("div#howto_tramite div:first").show();

    $("ul.nav li a").click(function(){
        $("ul.nav li a").removeClass("current");
        $(this).addClass("current");
        $("div#howto_tramite div").hide();

        var activeTab = $(this).attr("href");
        $(activeTab).fadeIn();
        return false;
    });
    /*
    $("a.fancybox").fancybox({
        'transitionIn':	'fade',
        'transitionOut':'fade',
        'speedIn':600,
        'speedOut':200,
        'overlayShow':true
    });
    function getOff(){
        x = document.getElementById('content');
        return x.offsetHeight;
    }
    function changeOff(amount){
        amount = getOff();
        a = document.getElementById('maincontent');
        a.style.height = amount + 'px';
    }
    changeOff();
    */

});
