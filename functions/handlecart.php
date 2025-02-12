<?php

    session_start();
    include "../config/dbconfig.php";

    if(isset($_SESSION['auth'])){

        if(isset($_POST['scope'])){
            $scope = $_POST['scope'];
        
            switch($scope){
                case "add":
                    $prod_id = $_POST['prod_id'];
                    $prod_qte = $_POST['prod_qte'];

                    $user_id = $_SESSION['auth_user']['user_id'];

                    $check_product_cart_stmt = $con->prepare("SELECT * FROM carts WHERE product_id = ? AND user_id = ?");
                    $check_product_cart_stmt->bind_param("ii", $prod_id, $user_id);
                    $check_product_cart_stmt->execute();
                    $check_product_cart_result = $check_product_cart_stmt->get_result();

                    if(($check_product_cart_result->num_rows) > 0){
                        echo "existing";
                    } else {

                        $insert_query = $con->prepare("INSERT INTO carts(user_id, product_id, product_qte) VALUE (?, ?, ?)");
                        $insert_query->bind_param("iii", $user_id, $prod_id, $prod_qte);
    
                        if($insert_query->execute()){
                            echo 201;
                        } else {
                            echo 500;
                        }

                    }
                    break;

                case "update":
                    $prod_id = $_POST['prod_id'];
                    $prod_qte = $_POST['prod_qte'];

                    $user_id = $_SESSION['auth_user']['user_id'];

                    $check_product_cart_stmt = $con->prepare("SELECT * FROM carts WHERE product_id = ? AND user_id = ?");
                    $check_product_cart_stmt->bind_param("ii", $prod_id, $user_id);
                    $check_product_cart_stmt->execute();
                    $check_product_cart_result = $check_product_cart_stmt->get_result();

                    if(($check_product_cart_result->num_rows) > 0){
                        $update_stmt = $con->prepare("UPDATE carts SET product_qte = ? WHERE product_id = ? AND user_id = ?");
                        $update_stmt->bind_param("iii", $prod_qte, $prod_id, $user_id);
                        $update_stmt->execute();
                        if($update_stmt){
                            echo 200;
                        } else {
                            echo 500;
                        }
                    } else {

                        echo "Quelque chose c'est mal passe !";

                    }
                    break;

                case "delete":
                    $card_id = $_POST['card_id'];

                    $user_id = $_SESSION['auth_user']['user_id'];

                    $check_product_cart_stmt = $con->prepare("SELECT * FROM carts WHERE id = ? AND user_id = ?");
                    $check_product_cart_stmt->bind_param("ii", $card_id, $user_id);
                    $check_product_cart_stmt->execute();
                    $check_product_cart_result = $check_product_cart_stmt->get_result();

                    if(($check_product_cart_result->num_rows) > 0){
                        $delete_stmt = $con->prepare("DELETE FROM carts WHERE id = ? AND user_id = ?");
                        $delete_stmt->bind_param("ii", $card_id, $user_id);
                        $delete_stmt->execute();
                        if($delete_stmt){
                            echo 200;
                        } else {
                            echo 500;
                        }
                    } else {
                        echo "Quelque chose c'est mal passe !";
                    }
                    break;

                default:
                    echo 500;
            }
        } else {
            echo 400; // Mauvaise requette
        }
    } else {
        echo 401; // Non autorise
    }

?>