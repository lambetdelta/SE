function salir(){
  window.location="includes/logout.php";  
}
function espacion_block(e){ //bloquear espacio
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==32) return false; 
}
function buscar(dato){
    $.post('ajax_adm/buscar.php',{dato:dato})
            .fail()
            .done(function(data){
                $('#div-resultados').show();
                $('#div-resultados').attr('z-index','1');
                $('#div-resultados').html(data);
            });
}
