<?php

session_start();


if(isset($_GET['id_torneo']))

{
    $_SESSION['torneo_id']=$_GET['id_torneo'];
    require("db/connection.php");

    $torneos="SELECT * FROM torneos WHERE id_torneo='".$_SESSION['torneo_id']."'";
    $result_torneos = $conn->query($torneos);
    $num_torneos= $result_torneos->num_rows;
}

    require_once('define.php');

 
 
    require_once 'vendor/autoload.php';
    $client = new Google_Client();
    $client->setClientId(GOOGLE_APP_ID);
    $client->setClientSecret(GOOGLE_APP_SECRET);
    $client->setRedirectUri(GOOGLE_APP_CALLBACK_URL);
    $client->addScope("email");
    $client->addScope("profile");
   
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        //print_r($token);
        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        $foto =  $google_account_info->picture;
        $_SESSION['usuario']=$email;
        $_SESSION['nombre']=$name;
        $_SESSION['foto']=$foto;
        //print_r($google_account_info);
       
        $conn = new mysqli("node139606-quiniela.hidora.com", "root", "YAVzey33982", "worldcup_db");
        $check = "SELECT * FROM `usuario` WHERE `email`='".$email."'";
        $result = mysqli_query($conn,$check);
        $rowcount=mysqli_num_rows($result);
        if($rowcount>0){
          
          $url="quiniela.php?mensaje=bienvenido";
          header("Location: ".$url);
        }
        else {
           
          $sql_insert="insert into usuario (nombre,email,foto,usuario) values ('".$name."','".$email."','".$foto."','".$email."')";
          mysqli_query($conn , $sql_insert);
          
          $url="quiniela.php?mensaje=datos_guardados";
          header("Location: ".$url);

        }
       
    } 
      
    else {
 

 

 require("db/connection.php");
 
 
$torneo_detalle="SELECT torneo_nombre_corto,evento_inicio, evento_logo, evento_descripcion, torneo_creador, torneo_codigo, torneo_status , torneo_inscripcion, COUNT(*) AS inscritos FROM torneos,eventos,torneo_inscripciones WHERE torneos.evento_id=eventos.id_evento AND torneos.id_torneo=torneo_inscripciones.id_torneo and torneos.id_torneo='".$_GET['id_torneo']."'  GROUP BY torneo_nombre_corto,evento_inicio, evento_logo, evento_descripcion, torneo_creador, torneo_codigo, torneo_status , torneo_inscripcion ";

$lista_participantes="
SELECT torneo_inscripciones.id_torneo, usuario.nombre, foto,email, perfect_points,total_puntos  FROM torneo_inscripciones  
LEFT JOIN puntos_totales
ON torneo_inscripciones.usuario=puntos_totales.id_usuario AND torneo_inscripciones.id_torneo=puntos_totales.id_torneo 
LEFT JOIN usuario
ON torneo_inscripciones.usuario=usuario.email
WHERE torneo_inscripciones.id_torneo='".$_GET['id_torneo']."'
ORDER BY total_puntos DESC";

$result_torneo_detalle = $conn->query($torneo_detalle);
$result_torneo_participantes = $conn->query($lista_participantes);

 
$num_partricipantes= $result_torneo_participantes->num_rows;


 

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>La quiniela de los Panas</title>

    <link rel="shortcut icon" href="assets/images/fav.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/plugin/nice-select.css">
    <link rel="stylesheet" href="assets/css/plugin/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugin/slick.css">
    <link rel="stylesheet" href="assets/css/arafat-font.css">
    <link rel="stylesheet" href="assets/css/plugin/animate.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- start preloader -->
    <div class="preloader" id="preloader"></div>
    <!-- end preloader -->

    <!-- Scroll To Top Start-->
    <a href="javascript:void(0)" class="scrollToTop"><i class="fas fa-angle-double-up"></i></a>
    <!-- Scroll To Top End -->

    <!-- header-section start -->
    <header class="header-section">
        <div class="overlay">
            <div class="container">
                <div class="row d-flex header-area">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/logo.png" class="logo" alt="logo">
                        </a>
                        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar-content">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbar-content">
                             
                            <div class="right-area header-action d-flex align-items-center max-un">
                                <button type="button" class="cmn-btn reg"  data-bs-target="#loginMod">
                                <a href='<?php  echo $client->createAuthUrl();?>'><img src="https://cdn-icons-png.flaticon.com/512/270/270014.png" style="width :50px !important">Empieza Ya!</a>
                                </button>
                                
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Login Registration end -->

    <!-- Banner Section start -->
    <section class="banner-section inner-banner tournaments">
        <div class="overlay">
            <div class="shape-area">
                <img src="assets/images/tournaments-illus.png" class="tournaments-illu" alt="image">
            </div>
            <div class="banner-content">
                <div class="container">
                    <div class="content-shape">
                        <img src="assets/images/sell-hero-illus.png" class="obj-8" alt="image">
                    </div>
                
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section end -->

    <!-- Tournaments section start -->
    <section class="how-works-tournaments tournaments-section">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-item">
                            <div class="left-item">
                                <div class="logo-item">
                                    <img src="assets/images/icon/tournaments-logo-1.png" alt="icon">
                                </div>
<?php 
                                while($row = $result_torneo_detalle->fetch_assoc()) { ?>
                                <div class="mid-area">
                                    <h3><?php echo $row['torneo_nombre_corto'];?></h3>
                                    <ul>
                                        
                                    <li>
                                            <span><i class="far fa-calendar-alt"></i></span>
                                            <?php echo $row['torneo_inscripcion'];?> USD
                                        </li>
                                        <li>
                                            <span><i class="far fa-calendar-alt"></i></span>
                                            <?php echo $row['evento_inicio'];?>
                                        </li>
                                        <li>
                                            <span><i class="fas fa-users"></i></span>
                                            <?php echo $row['inscritos'];?> PARTICIPANTES
                                        </li>
                                    </ul>
                                    <p>Los tres mejores jugadores, se llevaran los premios de esta quiniela</p>
                                </div>
                            </div>
                            <div class="last-item">
                                <h6>Premio Acumulado</h6>
                                <h4> USD <?php echo $row['inscritos']*$row['torneo_inscripcion']; $premio= $row['inscritos']*$row['torneo_inscripcion'];?></h4>
                                <span class="btn-border">
                                <button type="button" class="cmn-btn reg"  data-bs-target="#loginMod"  >
                                    <a href='<?php  echo $client->createAuthUrl();?>'><img src="https://cdn-icons-png.flaticon.com/512/270/270014.png" style="width :50px !important">Únete a este Torneo (<?php echo $_SESSION['torneo_id'];?>)</a>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
   }

 
?>
                <div class="row cus-mar">
                    <div class="col-lg-12">
                        <div class="table-responsive mt-60">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Posición</th>
                                        <th scope="col"></th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Aciertos Perfectos</th>
                                        <th scope="col">Puntos</th>
                                        <th scope="col">Premio</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php 
                                $i=1;
                                while($row2 = $result_torneo_participantes->fetch_assoc()) { ?>
                                    <tr>
                                        <th scope="row">
                                            <?php if ($i==1) { ?><img src="assets/images/icon/first-trophy.png" alt="icon"><?php   $premio_a[1]=$premio*.6;} ?>
                                            <?php if ($i==2) { ?><img src="assets/images/icon/second-trophy.png" alt="icon"><?php  $premio_a[2]=$premio*.25;} ?>
                                            <?php if ($i==3) { ?><img src="assets/images/icon/third-trophy.png" alt="icon"><?php  $premio_a[3]=$premio*.15;} ?>
                                            <?php if ($i>3) { ?> <?php echo $i;?> <?php } ?>
                                        </th>
                                       <td><img src="<?php echo $row2['foto'];?>" style="display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 50%;

  object-fit: cover;">
                                           
                                        <td> 
                                            <?php if ($row2['nombre']==null) {echo $row2['usuario'];} else  {echo $row2['nombre'];}?> <span style="font-size: xx-small !important"> <?php if ($row2['pagado']==0) {echo "<br> Inscripcion no pagada";} ?></span></td>
                                        <td><?php echo $row2['perfect_points']+0;?></td>
                                        <td><?php echo $row2['total_puntos']+0;?></td>


                                        <td class="prize"><?php echo $premio_a[$i]+0;?> USD</td>
                                    </tr>

                                    <?php 
                                $i=$i+1;
                                } ?>
                                  
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-60">
                            <div class="col-lg-12 d-flex justify-content-center">
                                <nav aria-label="Page navigation" class="d-flex justify-content-center">
                                   
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tournaments section end -->

    <!-- Footer Area Start -->
    <footer class="footer-section">
        <div class="container pt-120">
         
            <div class="footer-bottom-area pt-120">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="menu-item">
                            <a href="index.html" class="logo">
                                <img src="assets/images/logo.png" alt="logo">
                            </a>
                            <ul class="footer-link">
                                <li><a href="contact.html">Contact</a></li>
                                <li><a href="terms-conditions.html">Terms of Services</a></li>
                                <li><a href="privacy-policy.html">Privacy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="copyright">
                            <div class="copy-area">
                                <p> Copyright © <a href="index.html">Quinielazo</a> | Developed By Vlad
                                    
                                </p>
                            </div>
                            <div class="social-link d-flex align-items-center">
                                
                                <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                               
                                <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->

    <!--==================================================================-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/fontawesome.js"></script>
    <script src="assets/js/plugin/slick.js"></script>
    <script src="assets/js/plugin/jquery.nice-select.min.js"></script>
    <script src="assets/js/plugin/jquery.downCount.js"></script>
    <script src="assets/js/plugin/counter.js"></script>
    <script src="assets/js/plugin/waypoint.min.js"></script>
    <script src="assets/js/plugin/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugin/wow.min.js"></script>
    <script src="assets/js/plugin/plugin.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>


<?php 

    }
    ?>