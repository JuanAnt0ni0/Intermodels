$(document).ready(function() {
    
    $(".datos tr").mouseover(function(){$(this).addClass("zover");}).mouseout(function(){$(this).removeClass("zover");});
    $(".datos tr:even").addClass("zebra");
    
    // Detalle Modelo - Lista de Fotos
    $('#listaFotos').each(function (){
       $("a[rel='fotos']").colorbox({slideshow:false});
    });

    //Formulario Modelo_Form_Modelo
    $('#FormModelo').each(function (){
        switch ($("input[name='sexo']:checked").val()) {
            case undefined:
            case 'Hombre' :
                hombre();
                break;
            case 'Mujer' :
                mujer();
                break;
          }

        $('input:radio[name=sexo]').change(function(){
            if ($("input[name='sexo']:checked").val() == 'Hombre'){
                hombre();
            } else {
                mujer();
            }
        });

        function hombre()
        {
            $("#sexo-Hombre").attr('checked', true);
            $('#pecho-label').hide();
            $('#pecho').hide();
            $('#cintura-label').hide();
            $('#cintura').hide();
            $('#cadera-label').hide();
            $('#cadera').hide();
            $('#torax-label').show();
            $('#torax').show();
        }

        function mujer()
        {
            $("#sexo-Mujer").attr('checked', true);
            $('#pecho-label').show();
            $('#pecho').show();
            $('#cintura-label').show();
            $('#cintura').show();
            $('#cadera-label').show();
            $('#cadera').show();
            $('#torax-label').hide();
            $('#torax').hide();
        }
    });

});