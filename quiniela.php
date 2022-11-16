<?php
 session_start();

 
 if(isset($_SESSION['usuario']) && $_SESSION['usuario'] != "") {  
    
   $loged=1;
  }
  else
  
  {  
    
   header("Location: index.php?error=1");
   
  } 


 

 require("db/connection.php");

 
 ///////torneos


$torneos="SELECT * FROM torneo_inscripciones,torneos where usuario='".$_SESSION['usuario']."' and torneos.id_torneo=torneo_inscripciones.id_torneo";
$result_torneos = $conn->query($torneos);
$num_torneos= $result_torneos->num_rows;


// torneo actual


$el_torneo="SELECT * FROM torneo_inscripciones,torneos where usuario='".$_SESSION['usuario']."' and torneos.id_torneo=torneo_inscripciones.id_torneo and torneos.id_torneo='".$_GET['torneo_id']."'";
$result_el_torneo = $conn->query($el_torneo);
 
 // partidos y pronosticos
 
$partidos="SELECT * FROM partido LEFT JOIN pronosticos_updated ON partido.id=pronosticos_updated.id_juego AND id_usuario='".$_SESSION['usuario']."' AND pronosticos_updated.id_torneo='".$_GET['torneo_id']."' ORDER BY partido.id";

$result_partidos = $conn->query($partidos);
$num_partidos= $result_partidos->num_rows;
$result_partidos2 = $conn->query($partidos);
 




 

?>

<!doctype html>
<html lang="es">



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
    <header class="header-section user-dashboard">
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
                            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="torneos.php">Ver Torneos</a>
                                </li>
                                <li class="nav-item dropdown main-navbar">
                                    <a class="nav-link dropdown-toggle active" href="javascript:void(0)"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside">Dashboard</a>
                                    <ul class="dropdown-menu main-menu shadow">
                                        <li><a class="nav-link" href="dashboard.html">Dashboard</a></li>
                                        
                                    </ul>
                                </li>
                                
                            
                                <li class="nav-item dropdown main-navbar">
                                    <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside">Nosotros</a>
                                    <ul class="dropdown-menu main-menu shadow">
                                        <li class="dropend sub-navbar">
                                            <a href="javascript:void(0)" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown"
                                              data-bs-auto-close="outside">Torneos</a>
                                            <ul class="dropdown-menu sub-menu shadow">
                                                <li><a class="nav-link" href="torneos.php">Tournaments</a></li>
                                                <li><a class="nav-link" href="torneo_detalles.php">Tournaments Details</a></li>
                                            </ul>
                                        </li>
                                       
                                   
                                        <li><a class="nav-link" href="faqs.html">Faqs</a></li>
                                        <li><a class="nav-link" href="privacy-policy.html">Privacy Policy</a></li>
                                        <li><a class="nav-link" href="terms-conditions.html">Terms Conditions</a></li>
                                       
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contact</a>
                                </li>
                            </ul>
                            <div class="right-area header-action d-flex align-items-center max-un">
                              
                                <div class="single-item notifications-area">
                                    <div class="notifications-btn active-dot">
                                        <img src="assets/images/icon/notifications.png" alt="icon">
                                        <span class="items">3</span>
                                    </div>
                                    <div class="main-area notifications-content">
                                        <div class="head-area d-flex justify-content-between">
                                            <div class="left d-flex align-items-center">
                                                <h5>Notifications</h5>
                                                <span class="mdr">03</span>
                                            </div>
                                            <button class="clear-all">
                                                <img src="assets/images/icon/cancel-btn.png" alt="icon">
                                            </button>
                                        </div>
                                        <ul>
                                            <li class="border-area">
                                                <a href="javascript:void(0)">
                                                    <div class="img-area">
                                                        <img src="assets/images/latest-tips-1.png" alt="image">
                                                    </div>
                                                    <div class="text-area">
                                                        <h6>Della Parker</h6>
                                                        <p class="mdr">+2736 Profit on Horse Racing</p>
                                                        <p class="mdr time-area">04:20 PM</p>
                                                    </div>
                                                </a>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                                <div class="single-item user-area">
                                    <div class="user-btn d-flex align-items-center">
                                        <span class="user-profile">
                                            <img src="<?php echo $_SESSION['foto']; ?>" alt="icon" style="width: 50% !important">
                                        </span>
                                        <span class="name-area"><?php echo $_SESSION['nombre']; ?></span>
                                        <i class="icon-c-down-arrow"></i>
                                    </div>
                                    <div class="main-area user-content">
                                        <div class="head-area d-flex">
                                            <div class="img-area">
                                                <img src="<?php echo $_SESSION['foto']; ?>" alt="icon">
                                            </div>
                                            <div class="text-area">
                                                <h5><?php echo $_SESSION['nombre']; ?></h5>
                                                <div class="d-flex align-items-center">
                                                   
                                                    <span>Usuario VIP</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul>
                                            <li class="border-area">
                                                <a href="javascript:void(0)" class="active">
                                                    <img src="assets/images/icon/dashboard-icon.png" alt="icon">
                                                    <p class="mdr">Mi Cuenta</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <img src="assets/images/icon/subscriptions-icon.png" alt="icon">
                                                    <p class="mdr">Mis Torneos</p>
                                                </a>
                                            </li>
                                           
                                          
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- header-section end -->

    <!-- Login Registration start -->
    <div class="log-reg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="modal fade" id="loginMod">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <ul class="nav log-reg-btn justify-content-around">
                                    <li class="bottom-area" role="presentation">
                                        <button class="nav-link" id="regArea-tab" data-bs-toggle="tab"
                                            data-bs-target="#regArea" type="button" role="tab" aria-controls="regArea"
                                            aria-selected="false">
                                            SIGN UP
                                        </button>
                                    </li>
                                    <li class="bottom-area" role="presentation">
                                        <button class="nav-link active" id="loginArea-tab" data-bs-toggle="tab"
                                            data-bs-target="#loginArea" type="button" role="tab"
                                            aria-controls="loginArea" aria-selected="true">
                                            LOGIN
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="loginArea" role="tabpanel"
                                        aria-labelledby="loginArea-tab">
                                        <div class="login-reg-content">
                                            <div class="modal-body">
                                                <div class="head-area">
                                                    <h6 class="title">Login Direetly With</h6>
                                                    <div class="social-link d-flex align-items-center">
                                                        <a href="javascript:void(0)" class="active"><i
                                                                class="fab fa-facebook-f"></i></a>
                                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                                        <a href="javascript:void(0)"><i
                                                                class="fab fa-linkedin-in"></i></a>
                                                        <a href="javascript:void(0)"><i
                                                                class="fab fa-instagram"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-area">
                                                    <form action="#">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="single-input">
                                                                    <label for="logemail">Email</label>
                                                                    <input type="text" id="logemail"
                                                                        placeholder="Email Address">
                                                                </div>
                                                                <div class="single-input">
                                                                    <label for="logpassword">Password</label>
                                                                    <input type="text" id="logpassword"
                                                                        placeholder="Email Password">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="remember-me">
                                                                    <label
                                                                        class="checkbox-single d-flex align-items-center">
                                                                        <span class="left-area">
                                                                            <span class="checkbox-area d-flex">
                                                                                <input type="checkbox"
                                                                                    checked="checked">
                                                                                <span class="checkmark"></span>
                                                                            </span>
                                                                            <span
                                                                                class="item-title d-flex align-items-center">
                                                                                <span>Remember Me</span>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                    <a href="javascript:void(0)">Forgot Password</a>
                                                                </div>
                                                            </div>
                                                            <span class="btn-border w-100">
                                                                <button class="cmn-btn w-100">LOGIN</button>
                                                            </span>
                                                        </div>
                                                    </form>
                                                    <div class="bottom-area text-center">
                                                        <p>Not a member ? <a href="javascript:void(0)" class="reg-btn">Register</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="regArea" role="tabpanel"
                                        aria-labelledby="regArea-tab">
                                        <div class="login-reg-content regMode">
                                            <div class="modal-body">
                                                <div class="head-area">
                                                    <h6 class="title">Register On Quinielazo</h6>
                                                    <div class="social-link d-flex align-items-center">
                                                        <a href="javascript:void(0)" class="active"><i
                                                                class="fab fa-facebook-f"></i></a>
                                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                                        <a href="javascript:void(0)"><i
                                                                class="fab fa-linkedin-in"></i></a>
                                                        <a href="javascript:void(0)"><i
                                                                class="fab fa-instagram"></i></a>
                                                    </div>
                                                </div>
                                                <div class="form-area">
                                                    <form action="#">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="single-input">
                                                                    <label for="regemail">Email</label>
                                                                    <input type="text" id="regemail"
                                                                        placeholder="Email Address">
                                                                </div>
                                                                <div class="single-input">
                                                                    <label for="regpassword">Password</label>
                                                                    <input type="text" id="regpassword"
                                                                        placeholder="Email Password">
                                                                </div>
                                                                <div class="single-input">
                                                                    <label>Country</label>
                                                                    <select>
                                                                        <option value="1">United States</option>
                                                                        <option value="2">United Kingdom</option>
                                                                        <option value="3">Canada</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="remember-me">
                                                                    <a href="javascript:void(0)">Have a referral
                                                                        code?</a>
                                                                </div>
                                                            </div>
                                                            <span class="btn-border w-100">
                                                                <button class="cmn-btn w-100">SIGN UP</button>
                                                            </span>
                                                        </div>
                                                    </form>
                                                    <div class="bottom-area text-center">
                                                        <p>Already have an member ? <a href="javascript:void(0)"
                                                                class="log-btn">Login</a></p>
                                                    </div>
                                                    <div class="counter-area">
                                                        <div class="single">
                                                            <div class="icon-area">
                                                                <img src="assets/images/icon/signup-counter-icon-1.png"
                                                                    alt="icon">
                                                            </div>
                                                            <div class="text-area">
                                                                <p>25,179k</p>
                                                                <p class="mdr">Bets</p>
                                                            </div>
                                                        </div>
                                                        <div class="single">
                                                            <div class="icon-area">
                                                                <img src="assets/images/icon/signup-counter-icon-2.png"
                                                                    alt="icon">
                                                            </div>
                                                            <div class="text-area">
                                                                <p>6.65 BTC</p>
                                                                <p class="mdr">Total Won</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Registration end -->

    <!-- Banner Section start -->
    <section class="banner-section inner-banner soccer-bets">
        <div class="overlay">
           
            <div class="banner-content">
                <div class="container">
             <?php 
                if ($result_partidos != null) {

while($row_torneoss = $result_el_torneo->fetch_assoc()) { ?>  
                    <div class="row">
                        <div class="col-lg-6 col-md-10">
                            <div class="main-content">
                            <?php if ($num_torneos>0) { ?><h5>Mundial Qatar 2022 - <?php echo $row_torneoss['torneo_nombre_corto']; ?> </h5>
                                <?php if (is_null($row_torneoss['link_de_pago']) || $row_torneoss['pago']==1) {echo "quiniela pagada!";} else { ?>    <h6><a class="nav-link" aria-current="page" href="<?php echo $row_torneoss['link_de_pago']; ?>">Paga tu quiniela aqui</a>   </h6> <?php } ?>
                                <a class="nav-link" aria-current="page" href="torneo_detalle.php?id_torneo=<?php echo $_GET['torneo_id'];?>">Ver tabla de clasificación</a> <?php }?>
                            </div>
                        </div>
                    </div>
<?php 
}}
?>
                
                    <div class="row">
                        <div class="col-lg-6 col-md-10">
                            <div class="main-content">
                          <br>
                          
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-10">
                            <div class="main-content">
                                <h5><?php if ($num_torneos==0)

                                {echo "No tienes quinielas. Has <a href='torneos.php'>click Aquí</a> para unirte a una";} 

                                else

                                {echo "Selecciona una quiniela para continuar";}
                                
                                
                                ?> <br></h5>
                          
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-10">
                            <div class="main-content">
                          <br>
                          
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                       
                    <ul class="nav" role="tablist">
                    <?php 
                    
                    if ($result_partidos != null) {

while($row_torneo = $result_torneos->fetch_assoc()) { ?>  
                    <li class="nav-item" role="presentation">
                            <button class="cmn-btn active" 
                                aria-selected="false"><a href="quiniela.php?torneo_id=<?php echo $row_torneo['id_torneo']?>"><?php echo $row_torneo['torneo_nombre_corto']?></a></button>
                        </li>
                      <?php 
}}

?>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section end -->
    <!-- All Soccer Bets start -->
    <section class="bet-this-game all-soccer-bets">
        <div class="overlay pb-120">
            <div class="container">
               
                <div class="row cus-mar">
                    <?php 


if ($result_partidos != null && $_GET['torneo_id']>0) {

    while($row = $result_partidos->fetch_assoc()) { ?>
                    <div class="col-lg-6">
                        <div class="single-area">
                            <div class="head-area d-flex align-items-center">
                                 
                              
                            </div>
                            <div class="main-content">
                                <div class="team-single">
                                    <span style="font-size: small; " ><?php echo $row['equipo1_id']?></span >
                                     
                                    <div class="img-area">
                                        <img src="<?php echo $row['bandera1']?>" alt="image" style="display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 50%;

  object-fit: cover;">
                                        <span ><?php if ($row['fecha_pronostico']!=null) {echo  $row['goles_a']+0;}?></span>
                                    </div>
                                </div>
                                <div class="mid-area text-center">
                                    <div class="countdown d-flex align-items-center justify-content-center">
                                    <span style="font-size: xx-small !important"><?php echo $row['fecha']; ?></span>
                                    </div>
                                    <h6><?php echo $row['fase']?></h6>
                                </div>
                                <div class="team-single">
                                <span style="font-size: small; " ><?php echo $row['equipo2_id']?></span >
                                   
                                    <div class="img-area">
                                        <img src="<?php echo $row['bandera2']?>" alt="image"  style="display: inline-block;
  width: 50px;
  height: 50px;
  border-radius: 50%;

  object-fit: cover;">
                                        <span ><?php if ($row['fecha_pronostico']!=null) {echo  $row['goles_b']+0;}?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom-item" style="font-size: 8px">
                               <div style="margin-left: 35%">
                                    <button type="button" class="cmn-btn  " data-bs-toggle="modal" data-bs-target="#betpop-up<?php echo $row['id']?>" <?php if ($row['fecha_pronostico']!=null) {   ?>style="background: white !important; color: black  !important"  > Pronóstico Listo! <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c6/Sign-check-icon.png/800px-Sign-check-icon.png" width="25px"><?php } else { ?> > Has tu Pronóstico <?php } ?> </button>
                               </div>
                            </div>
                        </div>
                    </div>
<?php
   }

}
?>
                </div>
  
            </div>
        </div>
    </section>
    <!-- All Soccer Bets end -->
    <?php 

 
if ($result_partidos2 != null) {

    while($row2 = $result_partidos2->fetch_assoc()) { ?>

  
    <!-- Betpop Up Modal start -->
    <div class="betpopmodal">
        <div class="modal fade" id="betpop-up<?php echo $row2['id']?>" tabindex="-1" aria-hidden="true"  >
            <div class="modal-dialog modal-dialog-centered">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-8 col-xl-9 col-lg-11">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="top-item">
                                        <a href="javascript:void(0)" class="cmn-btn firstTeam" id="equipoa"><?php echo $row2['equipo1_id']?> Gana</a>
                                        <a href="javascript:void(0)" class="cmn-btn draw"  id="empate">Empate</a>
                                        <a href="javascript:void(0)" class="cmn-btn lastTeam"  id="equipob"> <?php echo $row2['equipo2_id']?> Gana</a>
                                    </div>
                                  
                                    <div class="mid-area" style="justify-content:center !important">

                                     
                                         
                                        <div class="single-area quick-amounts">
                                            <div class="item-title d-flex align-items-center">
                                                <p>Goles de <?php echo $row2['equipo1_id']?></p>
                                            </div>
                                            <div class="input-item">
                                                <button id="q1" class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='0';golesa=0; $(this).css({'background-color': 'red','color': 'white' }); $('#q2, #q3,#q4, #q5,#q6, #q7,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado()" <?php if ($row2['goles_a']==0 && $row2['fecha_pronostico']!=null) {   ?>style="background: white !important; color: black" <?php }?>>0</button>
                                                <button id="q2"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='1';golesa=1; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q4, #q5,#q6, #q7,#q8').css('background','#382590'); id_juego=<?php echo $row2['id']?>; resultado()"<?php if ($row2['goles_a']==1) {   ?>style="background: white !important; color: black" <?php }?>>1</button>
                                                <button  id="q3"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='2';golesa=2; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q2,#q4, #q5,#q6, #q7,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>;  resultado()"<?php if ($row2['goles_a']==2) {   ?>style="background: white !important; color: black" <?php }?>>2</button>
                                                <button id="q4"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='3';golesa=3; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q2, #q5,#q6, #q7,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado() "<?php if ($row2['goles_a']==3) {   ?>style="background: white !important; color: black" <?php }?>>3</button>
                                                <button id="q5"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='4';golesa=4; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q4, #q2,#q6, #q7,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado() "<?php if ($row2['goles_a']==4) {   ?>style="background: white !important; color: black" <?php }?> >4</button>
                                                <button id="q6"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='5';golesa=5; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q4, #q5,#q2, #q7,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>;  resultado()"<?php if ($row2['goles_a']==5) {   ?>style="background: white !important; color: black" <?php }?> >5</button>
                                                <button id="q7"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='6';golesa=6; $(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q4, #q5,#q6, #q2,#q8').css('background','#382590');id_juego=<?php echo $row2['id']?>;  resultado()" <?php if ($row2['goles_a']==6) {   ?>style="background: white !important; color: black" <?php }?>>6</button>
                                                <button id="q8"class="quickIn" onclick="document.getElementById('goles1<?php echo $row2['id']?>').innerHTML='7'; golesa=7;$(this).css({'background-color': 'red','color': 'white' }); $('#q1, #q3,#q4, #q5,#q6, #q7,#q2').css('background','#382590');id_juego=<?php echo $row2['id']?>;  resultado()" <?php if ($row2['goles_a']==7) {   ?>style="background: white !important; color: black" <?php }?>>7</button>
                                            </div>
                                        </div>                                   
                                    </div>
                                    <div class="mid-area" style="justify-content:center !important">

                                     
                                         
                                        <div class="single-area quick-amounts">
                                            <div class="item-title d-flex align-items-center">
                                                <p>Goles de <?php echo $row2['equipo2_id']?></p>
                                            </div>
                                            <div class="input-item">
                                                <button id="q1x" class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='0'; golesb=0; $(this).css({'background-color': 'red','color': 'white' }); $('#q2x, #q3x,#q4x, #q5x,#q6x, #q7x,#q8x').css('background','#382590'); id_juego=<?php echo $row2['id']?>;resultado() " <?php if ($row2['goles_b']==0 && $row2['fecha_pronostico']!=null) {   ?>style="background: white !important; color: black" <?php }?>>0</button>
                                                <button id="q2x" class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='1';golesb=1; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q4x, #q5x,#q6x, #q7x,#q8x').css('background','#382590'); id_juego=<?php echo $row2['id']?>;resultado() "<?php if ($row2['goles_b']==1) {   ?>style="background: white !important; color: black" <?php }?>>1</button>
                                                <button  id="q3x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='2';golesb=2; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q2x,#q4x, #q5x,#q6x, #q7x,#q8x').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado() "<?php if ($row2['goles_b']==2) {   ?>style="background: white !important; color: black" <?php }?>>2</button>
                                                <button id="q4x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='3';golesb=3; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q2x, #q5x,#q6x, #q7x,#q8x').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado() "<?php if ($row2['goles_b']==3) {   ?>style="background: white !important; color: black" <?php }?>>3</button>
                                                <button id="q5x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='4';golesb=4; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q4x, #q2x,#q6x, #q7x,#q8x').css('background','#382590');id_juego=<?php echo $row2['id']?>; resultado() "<?php if ($row2['goles_b']==4) {   ?>style="background: white !important; color: black" <?php }?> >4</button>
                                                <button id="q6x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='5';golesb=5; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q4x, #q5x,#q2x, #q7x,#q8x').css('background','#382590'); id_juego=<?php echo $row2['id']?>; resultado()" <?php if ($row2['goles_b']==5) {   ?>style="background: white !important; color: black" <?php }?>>5</button>
                                                <button id="q7x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='6';golesb=6; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q4x, #q5x,#q6x, #q2x,#q8x').css('background','#382590'); id_juego=<?php echo $row2['id']?>;resultado() "<?php if ($row2['goles_b']==6) {   ?>style="background: white !important; color: black" <?php }?> >6</button>
                                                <button id="q8x"class="quickIn" onclick="document.getElementById('goles2<?php echo $row2['id']?>').innerHTML='7';golesb=7; $(this).css({'background-color': 'red','color': 'white' }); $('#q1x, #q3x,#q4x, #q5x,#q6x, #q7x,#q2x').css('background','#382590'); id_juego=<?php echo $row2['id']?>; resultado()"<?php if ($row2['goles_b']==7) {   ?>style="background: white !important; color: black" <?php }?> >7</button>
                                            </div>
                                        </div>
                                 
                                    </div>

                                    <div class="single-area smart-value">

                                   <div style="text-align: center !important">
                                        <span style="font-size: x-small;">Para guardar tus pronósticos debes seleccionar los dos goles, hasta que los dos marcadores se vean en rojo <br></span>
                                        </div>
                                            <div class="item-title d-flex align-items-center">
                                            
                                            <p class="mdr">Pronóstico</p>
                                            </div>
                                            <div class="contact-val d-flex align-items-center">
                                            <span><?php echo $row2['equipo1_id']?> </span> &nbsp; &nbsp; <span id="goles1<?php echo $row2['id']?>"><?php echo $row2['goles_a']; ?></span>&nbsp; &nbsp;  -  <span> &nbsp; &nbsp;<?php echo $row2['equipo2_id']?> &nbsp; &nbsp;</span> <span id="goles2<?php echo $row2['id']?>"><?php echo $row2['goles_b']; ?></span>
                                                
                                            </div>
                                        </div>
                                    <div class="bottom-area">
                                        <div class="fee-area">
                                            <p>Acertar Ganador: <span class="amount">Ganas 1</span> Punto</p>
                                            <p class="fee">Acertar Marcador: <span class="amount">Ganas 5</span>  <span> Puntos</span></p>
                                            
                                        </div>
                                        <div class="btn-area">
                                            
                                            <a href="#" id="guarda" class="guarda"><button id="btn_guarda"class="btn_guarda" style="visibility: hidden; background: white !important; color: black  !important">Guardar Pronóstico</button> </a>
                                        </div>
                                        <div class="bottom-right">
                                            <p>Cierre de Jugadas:</p>
                                            <p class="date-area"> <?php echo $row2['fecha']?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Betpop Up Modal end -->

    <script>
 



 </script> 
    <?php
   }

}
?>
     
 
 
    <!--==================================================================-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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

    <script >

 

function resultado ()

{

    console.log(golesb)
   if (golesb>=0 && golesa>=0)  { $('.btn_guarda').attr('style','visibility: visible; background: red !important; color: white  !important');}
   $('.guarda').attr('href', 'guarda.php?id_juego='+id_juego+'&goles_a='+golesa+'&goles_b='+golesb+'&torneo_id=<?php echo $_GET['torneo_id']?>');
 
if (golesa > golesb) { 
    console.log("gana a "+golesa+" vs "+golesb);
    $('#equipoa').attr('class', 'cmn-btn firstTeam active');
    $('#empate').attr('class', 'cmn-btn draw');
    $('#equipob').attr('class', 'cmn-btn lastTeam');
    

}
if (golesa < golesb) {
    console.log("gana b "+golesb+" vs "+golesa);
    $('#equipoa').attr('class', 'cmn-btn firstTeam ');
    $('#empate').attr('class', 'cmn-btn draw');
    $('#equipob').attr('class', 'cmn-btn lastTeam active');

}
if (golesa == golesb) {
    
    console.log("empate a "+golesa+" - "+golesb);
    $('#equipoa').attr('class', 'cmn-btn firstTeam ');
    $('#empate').attr('class', 'cmn-btn draw active');
    $('#equipob').attr('class', 'cmn-btn lastTeam');

}

}


 
 


 

    
    </script>
</body>



</html>