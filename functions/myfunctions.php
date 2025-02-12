<?php

    include("../config/dbconfig.php");

    if (!function_exists('getAll')){
        function getAll($table){
            global $con;
            $query = "SELECT * FROM $table";
            $query_run = mysqli_query($con, $query);
            return $query_run;
        }
    }

    if (!function_exists('getById')){
        function getById($table, $id){
            global $con;
            $query = "SELECT * FROM $table WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
    }

    // Afficher les differentes commandes dans la BD
    if(!function_exists('getAllOrders')){
        function getAllOrders(){
            global $con;
            $query = $con->prepare("SELECT * FROM others WHERE `status` = '0' ORDER BY id DESC ");
            $query->execute();
            $result = $query->get_result();
            return $result;
        }
    }

    if (!function_exists('redirect')){
        function redirect($url, $message){
            $_SESSION['message'] = $message;
            header('Location: ' . $url);
            exit();
        }
    }

    if (!function_exists('checkTrackigNoValid')){
        function checkTrackigNoValid($trackingno){
            global $con;
            $query = $con->prepare("SELECT * FROM others WHERE tracking_no = ? ");
            $query->bind_param('s', $trackingno);
            $query->execute();
            $result = $query->get_result();
            return $result;
        }
    }

    // Afficher les differentes commandes dans la BD
    if(!function_exists('getAllOrdersHistory')){
        function getAllOrdersHistory(){
            global $con;
            $query = $con->prepare("SELECT * FROM others WHERE `status` != '0' ORDER BY id DESC ");
            $query->execute();
            $result = $query->get_result();
            return $result;
        }
    }    
?>