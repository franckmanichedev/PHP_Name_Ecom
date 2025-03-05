<?php
    
    include_once("../functions/myfunctions.php");

    if(isset($_SESSION["auth"])){
        if($_SESSION['role'] == 0){
            redirect("../../index.php", "Vous n'etes pas autorise a avoir acces a cette page");
        }
    }else{
        redirect("../login.php", "Connectez-vous pour continuer");
    }

?>