<?php

    include("config/dbconfig.php");

    if (!function_exists('getAllActive')){
        function getAllActive($table){
            global $con;
            $query = "SELECT * FROM $table WHERE statut='0'";
            $query_run = mysqli_query($con, $query);
            return $query_run;
        }
    }

    // Fonction pour recuper les trending dans une table produit ayant pour statut '1' visible
    if (!function_exists('getAllTrenfing')){
        function getAllTrenfing(){
            global $con;
            $query = "SELECT * FROM products WHERE trending = '1'";
            $query_run = mysqli_query($con, $query);
            return $query_run;
        }
    }

    // Fonction pour recuperer les slug dans une table ayant pour statut '0' visible
    if (!function_exists('getSlugActive')){
        function getSlugActive($table, $slug){
            global $con;
            $query = "SELECT * FROM $table WHERE slug = ? AND statut = '0' LIMIT 1 ";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
    }

    // Fonction pour recuperer les element ayant pour statut '0' visible
    if (!function_exists('getIdActive')){
        function getIdActive($table, $id){
            global $con;
            $query = "SELECT * FROM $table WHERE id = ? AND statut = '0' ";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
    } 

    // Fonction pour recuperer les produit par categorie
    if (!function_exists('getProductByCategory')){
        function getProductByCategory($category_id){
            global $con;
            $query = "SELECT * FROM products WHERE category_id = ? AND statut = '1'";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }
    } 

    if(!function_exists('getCartItems')){
        function getCartItems(){
            global $con;
            $user_id = $_SESSION['auth_user']['user_id'];
            $query = $con->prepare("SELECT c.id as cid, c.product_id, c.product_qte, p.id as pid, p.name, p.image, p.selling_price 
                        FROM carts c, products p WHERE c.product_id=p.id AND c.user_id='$user_id' ORDER BY c.id DESC");
            $query->execute();
            $result = $query->get_result();
            return $result;
        }
    }

    if(!function_exists('getOrders')){
        function getOrders(){
            global $con;
            $user_id = $_SESSION['auth_user']['user_id'];
            $query = $con->prepare("SELECT * FROM others WHERE user_id = ? ORDER BY id DESC");
            $query->bind_param('i', $user_id);
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
            $user_id = $_SESSION['auth_user']['user_id'];
            $query = $con->prepare("SELECT * FROM others WHERE tracking_no = ? AND user_id = ? ");
            $query->bind_param('si', $trackingno, $user_id);
            $query->execute();
            $result = $query->get_result();
            return $result;
        }
    }

?>