<script type="text/javascript">
$(document).ready(function() {
    $(".primary-nav").tabs(".secondary-nav > div",{initialIndex: <?=(isset($listar_on))?"1":"0"?>});
});
</script>


<?php
$this->load->view('funcionarios/busqueda_menu');
$this->load->view('funcionarios/listar_menu');
?>
