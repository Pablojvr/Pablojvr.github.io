<?php

@session_start();
  
  if(!isset($_SESSION["usuario_EMP"])){
    require_once 'login.php';
    exit();
  }

  require_once '../controladores/mensajeControlador.php';
  $resp= new mensajeControlador();
  require_once '../modelos/mensajeModelo.php';
  $Mm= new mensajeModelo();
     
  $numM=$Mm->numeroMensajesModelo($_SESSION["nombre_EMP"])->rowCount();
  $Mm= new mensajeModelo();
  $numC=$Mm->numeroConversacionesModelo($_SESSION["nombre_EMP"])->rowCount();

?>


<!doctype html>
<html lang="en">

  <head>
  <title>EMP4THY - Let Us Read You</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">
 
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/sweetalert2.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="../css/aos.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/sweetalert2.min.js"></script>
  </head>

  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    
    <div class="site-wrap" id="home-section">

      <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>



      <header class="site-navbar site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">

            <div class="col-3 ">
              <div class="site-logo">
                <a href="http://localhost/empathy/EMP4THY/" class="font-weight-bold"><?php  echo $_SESSION["usuario_EMP"] . ":)"  ?></a>
              </div>
            </div>

            <div class="col-9  text-right">
              

              <span class="d-inline-block d-lg-none"><a href="#" class="text-primary site-menu-toggle js-menu-toggle py-5"><span class="icon-menu h3 text-primary"></span></a></span>

              

              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li ><a href="../index.php" class="nav-link">Inicio</a></li>
                  <li  class="active"><a href="contact.php" class="nav-link">Empezar</a></li>
                  <li ><a href="about.php" class="nav-link">¿Como Funciona?</a></li>
                  <?php if(isset($_SESSION["usuario_EMP"])){ echo '<li ><a href="'.$_SESSION["token_EMP"].'" class="btn-exit-system"  class="nav-link logout" style=" color:red;">Cerrar Sesion</a></li>'; } ?>
                  <?php if($numC>=1){ echo '<li ><a href="reply.php"  style=" color:green;" class="nav-link">Nueva notificacion</a></li>'; } ?>
                </ul>
              </nav>
            </div>

            
          </div>
        </div>

      </header>
      <?php
 
 echo $resp->recibirMensajeControlador();
    
    ?>


<?php if($numM>=1){ echo ''; }else{ echo ''; } ?>

    <div class="ftco-blocks-cover-1">
      <div class="site-section-cover half-bg">
        <div class="container">
          <div class="row align-items-center justify-content-center">
             <div class="col-lg-8">
              <h2 class="mb-5 text-primary font-weight-bold"  data-aos="fade-up"><?php if($numM>=1){ echo 'Lo sentimos tienes un mensaje pendiente de respuesta, tienes que responder antes de realizar otra publicacion :('; }else{ echo 'Recuerda, tus palabras son anonimas, por ello evita dar tu informacion personal.'; } ?></h2>
              <p data-aos="fade-up" data-aos-delay="100"><a  <?php if($numM>=1){ echo 'href="answer.php"'; }else{ echo 'href="#form"'; } ?> class="more-29291"><?php if($numM>=1){ echo 'Responder'; }else{ echo 'Empezar'; } ?></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div id="form" class="site-section bg-left-half">
      <div  class="container "> 
      <div class="col-lg-8">
              <h2 class="mb-5 text-primary font-weight-bold"  data-aos="fade-up"><?php if($numM>=1){ echo 'Lo sentimos :('; }else{ echo 'Cuentanos'; } ?></h2>
            </div> 
        <div class="row">
       
          <div class="col-lg-12 mb-5" >
            <form class="FormularioAjax" data-form="insertar" action="http://localhost/empathy/EMP4THY/ajax/AjaxMensaje.php" method="post">      
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="mensaje" <?php if($numM>=1){ echo ' disabled  placeholder="El area de texto se encuentra deshabilitada :(" '; }else{ echo ' placeholder="¿Tienes algo que decir?" '; } ?> id="" class="form-control" placeholder="¿Tienes algo que decir?" cols="30" rows="10"></textarea>
                </div>
              </div>
              <div class="form-group row">
                
                <div class="col-md-3 mr-auto">
                  <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" <?php if($numM>=1){ echo 'disabled value=":("'; }else{ echo 'value="Enviar mensaje"'; } ?> >
                </div>
              </div>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>  
      </div>
    </div> <!-- END .site-section -->

    

    <div class="site-section">
      <div class="container">
        <div class="row mb-4 text-center">
          <div class="col">
            <a href="#"><span class="m-2 icon-facebook"></span></a>
            <a href="#"><span class="m-2 icon-twitter"></span></a>
            <a href="#"><span class="m-2 icon-linkedin"></span></a>
            <a href="#"><span class="m-2 icon-instagram"></span></a>
            <a href="#"><span class="m-2 icon-skype"></span></a>
          </div>
        </div>
        <div class="row mt-5 justify-content-center">
          <div class="col-md-7 text-center">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </div>

    

    </div>
 
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-migrate-3.0.0.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.sticky.js"></script>
    <script src="../js/jquery.waypoints.min.js"></script>
    <script src="../js/jquery.animateNumber.min.js"></script>
    <script src="../js/jquery.fancybox.min.js"></script>
    <script src="../js/jquery.stellar.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/aos.js"></script>
  

    <script src="../js/typed.js"></script>
            <script>
            var typed = new Typed('.typed-words', {
            strings: ["Business"," Startups"," Organization", " Company"],
            typeSpeed: 80,
            backSpeed: 80,
            backDelay: 4000,
            startDelay: 1000,
            loop: true,
            showCursor: true
            });
            </script>


    <script src="../js/main.js"></script>
   

  </body>

</html>

