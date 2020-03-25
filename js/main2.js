
(function ($) {
    "use strict";


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('fa-eye');
            $(this).find('i').addClass('fa-eye-slash');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').removeClass('fa-eye-slash');
            $(this).find('i').addClass('fa-eye');
            showPass = 0;
        }
        
    });
    
    $('.FormularioAjax').submit(function(e){
        e.preventDefault();
    
        var form=$(this);
    
        var tipo=form.attr('data-form');
        var accion=form.attr('action');
        var metodo=form.attr('method');
        var respuesta=form.children('.RespuestaAjax');
    
        var msjError="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
        var formdata = new FormData(this);
    
    
        var textoAlerta;
        if(tipo==="save"){
            textoAlerta="Los datos que enviaras quedaran almacenados en el sistema";
        }else if(tipo==="delete"){
            textoAlerta="Los datos serán eliminados completamente del sistema";
        }else if(tipo==="update"){
            textoAlerta="Los datos del sistema serán actualizados";
        }else{
            textoAlerta="Quieres realizar la operación solicitada";
        }
    
    
        swal({
            title: "¿Estás seguro?",   
            text: textoAlerta,   
            type: "question",   
            showCancelButton: true,     
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar"
        }).then(function () {
            $.ajax({
                type: metodo,
                url: accion,
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                      if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        if(percentComplete<100){
                            respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
                          }else{
                              respuesta.html('<p class="text-center"></p>');
                          }
                      }
                    }, false);
                    return xhr;
                },
                success: function (data) {
                    respuesta.html(data);
                },
                error: function() {
                    respuesta.html(msjError);
                }
            });
            return false;
        });
    });

})(jQuery);