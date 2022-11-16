<?php

session_start();


if(isset($_GET['torneo_id']))

{
    $_SESSION['torneo_id']=$_GET['torneo_id'];
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

    ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quinielazo</title>

    <link rel="shortcut icon" href="assets/images/fav.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
    <!-- header-section end -->

 

    <!-- Banner Section start -->
    <section class="banner-section">
        <div class="overlay">
            <div class="shape-area">
                <img src="assets/images/coin-2.png" class="obj-1" alt="image">
                <img src="assets/images/winner-cup.png" class="obj-2" alt="image">
            </div>
            <div class="banner-content">
                <div class="container">
                    <div class="content-shape">
                        <img src="assets/images/coin-1.png" class="obj-1" alt="image">
                        <img src="assets/images/coin-3.png" class="obj-2" alt="image">
                        <img src="assets/images/coin-3.png" class="obj-3" alt="image">
                        <img src="assets/images/coin-4.png" class="obj-4" alt="image">
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-10">
                            <div class="main-content">
                                <div class="top-area section-text">
                                    <h4 class="sub-title">Quiniela para los cuates!</h4>
                                    <h1 class="title">Competencia entre amig@s!</h1>
                                    <p class="xlr">Juego gratis, de ver quien es mejor haciendo pronósticos</p>
                                </div>
                                <div class="bottom-area">
                                    <span class="btn-border">
                                  
                                    <button type="button" class="cmn-btn reg"  data-bs-target="#loginMod"  >
                                    <a href='<?php  echo $client->createAuthUrl();?>'><img src="https://cdn-icons-png.flaticon.com/512/270/270014.png" style="width :50px !important"><?php 
 if(isset($_GET['torneo_id']))

    {
        if ($result_torneos != null && $num_torneos>0) 
            {
                while($row = $result_torneos->fetch_assoc()) {
    
                                                                echo "Registrate en quiniela ". $row['torneo_nombre_corto'];
                                                            }
    } 
    else {

    echo "Empieza ya! (quiniela no existe)";}
}

else {
echo "Empieza ya!";}

?> </a>
                                    </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
    </section>
    <!-- Banner Section end -->

 
 

 
    <!-- Affilliate end -->

    <!-- Footer Area Start -->
    <footer class="footer-section">
        <div class="container pt-120">
        
            <div class="footer-bottom-area pt-120">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="menu-item">
                            <a href="index.php" class="logo">
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
                                <p> Copyright<a href="index.php">Quinielazo</a> | Developed by
                                    VLAD
                                </p>
                            </div>
                            <div class="social-link d-flex align-items-center">
                                <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                <a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a>
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