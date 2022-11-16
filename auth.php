<?php

session_start();


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
        print_r($token);
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
       
        $conn = new mysqli("node139606-quiniela.hidora.com", "root", "p1skT1CFNB", "worldcup_db");
        $check = "SELECT * FROM `usuario` WHERE `email`='".$email."'";
        $result = mysqli_query($conn,$check);
        $rowcount=mysqli_num_rows($result);


        

        if($rowcount>0){
          
         
          
          if(isset($_SESSION['torneo_id']))
                  {
                    $check2 = "SELECT * FROM `torneo_inscripciones` WHERE usuario='".$email."' AND id_torneo='".$_SESSION['torneo_id']."'";
                    $result2 = mysqli_query($conn,$check2);
                    $rowcount2=mysqli_num_rows($result2);

                            if($rowcount2>0)

                            {

                             // echo "ya tiene quiniela";
                              $url="quiniela.php?mensaje=bienvenido&";
                            }

                            else
                              {
                              $sql_insert_torneo="INSERT INTO `torneo_inscripciones` (id_torneo,usuario) VALUES ('".$_SESSION['torneo_id']."','".$email."')";
                              mysqli_query($conn , $sql_insert_torneo);
                              }

                              $url="quiniela.php?mensaje=bienvenido&torneo_id=".$_SESSION['torneo_id'];
                  }
                  else { $url="quiniela.php?mensaje=guardadox";}
                 
                  header("Location: ".$url);
                 
        }
        else{
      
          $sql_insert="insert into usuario (nombre,email,foto,usuario) values ('".$name."','".$email."','".$foto."','".$email."')";
          mysqli_query($conn , $sql_insert);

          if(isset($_SESSION['torneo_id']))
          {
            $check2 = "SELECT * FROM `torneo_inscripciones` WHERE usuario='".$email."' AND id_torneo='".$_SESSION['torneo_id']."'";
            $result2 = mysqli_query($conn,$check2);
            $rowcount2=mysqli_num_rows($result2);

                    if($rowcount2>0)

                    {

                     // echo "ya tiene quiniela";
                      $url="quiniela.php?mensaje=guardado";
                    }

                    else
                      {
                      $sql_insert_torneo="INSERT INTO `torneo_inscripciones` (id_torneo,usuario) VALUES ('".$_SESSION['torneo_id']."','".$email."')";
                      mysqli_query($conn , $sql_insert_torneo);
                      }

                      $url="quiniela.php?mensaje=guardado&torneo_id=".$_SESSION['torneo_id'];
          }

          else { $url="quiniela.php?mensaje=guardado";}
          
      
          header("Location: ".$url);

        }
       
    } else {
        /**
         * IF YOU DON'T LOGIN GOOGLE
         * YOU CAN SEEN AGAIN GOOGLE_APP_ID, GOOGLE_APP_SECRET, GOOGLE_APP_CALLBACK_URL
         */
        echo "<a href='".$client->createAuthUrl()."'>Inicia Sesión</a>";
    }

       
        