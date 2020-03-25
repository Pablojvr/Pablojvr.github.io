<script>
$(document).ready(function(){
    $('.btn-exit-system').on('click', function(e){
        e.preventDefault();
        alert("llego hasta logout script");
        var Token = $(this).attr('href');

        swal({
            title: 'Estas seguro?',
            text: "La sesión actual será cerrada",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#03A9F4',
            cancelButtonColor: '#F44336',
            confirmButtonText: '<i class="zmdi zmdi-run"></i> Yes, cerrar sesión!',
            cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> No, Cancelar!'
        }).then(function(){
            $.ajax({
                url:'http://localhost/empathy/EMP4THY/ajax/AjaxLogin.php?Token='+Token,
                success: function(data){
                    if(data){
                        window.location.href = "http://localhost/empathy/EMP4THY/";
                    } else {
                        swal({
                            title: 'Ocurrio un error',
                            text: data,
                            type: 'error' 
                        });
                    }
                }


            });
        });
    });
});
</script>
