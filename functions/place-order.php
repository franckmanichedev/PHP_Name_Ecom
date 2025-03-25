<?php
    session_start();
    include "../config/dbconfig.php";

    if(isset($_SESSION['auth'])){
        if(isset($_POST['place_order_btn'])){
            // Récupérer les informations de l'utilisateur et de la commande
            $name = $con->real_escape_string($_POST['name']);
            $email = $con->real_escape_string($_POST['email']);
            $phone = $con->real_escape_string($_POST['phone']);
            $pincode = $con->real_escape_string($_POST['pincode']);
            $address = $con->real_escape_string($_POST['address']);
            $payment_mode = ($_POST['payment_mode']);
            // $payment_id = ($_POST['payment_id']);

            // Verifier si tout les champ sont remplis
            if($name == "" || $email == "" || $phone == "" || $pincode == "" || $address == ""){
                $_SESSION['message'] = "Remplissez tout les champs !";
                header('Location: ../checkout.php');
                exit(0);
            }

            $user_id = $_SESSION['auth_user']['user_id'];
            $query = $con->prepare("SELECT c.id as cid, c.product_id, c.product_qte, p.id as pid, p.name, p.image, p.selling_price 
                        FROM carts c, products p WHERE c.product_id=p.id AND c.user_id='$user_id' ORDER BY c.id DESC");
            $query->execute();
            $cartItems = $query->get_result();

            $total_price = 0;
            foreach($cartItems as $item){
                $total_price += $item['selling_price'] * $item[
                    'product_qte'
                ];
            }

            $tracking_no = "skillsform".rand(1111,9999).substr($phone, 2);

            // Insérer les informations de la commande dans la table `orders`
            $query = $con->prepare("INSERT INTO others (tracking_no, user_id, `name`, email, phone, `address`, pincode, total_price, payment_mode, payment_id) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param("sisssssiss", $tracking_no, $user_id, $name, $email, $phone, $address, $pincode, $total_price, $payment_mode, $payment_id);
            $query->execute();

            if($query){
                $ordre_id = $query->insert_id; // Obtenir l'ID de la commande insérée

                // Parcourir les articles du panier et les insérer dans la table `orders_items`
                foreach($cartItems as $item){

                    $product_id = $item['product_id'];
                    $product_qte = $item['product_qte'];
                    $price = $item['selling_price'];

                    $insert_item_query = $con->prepare("INSERT INTO others_items (other_id, product_id, qte, price) VALUE (?, ?, ?, ?)");
                    $insert_item_query->bind_param("iiii", $ordre_id, $product_id, $product_qte, $price);
                    $insert_item_query->execute();

                    // Récupérer la quantité actuelle du produit
                    $product_query = $con->prepare("SELECT * FROM products WHERE id = ? LIMIT 1 ");
                    $product_query->bind_param("i", $product_id);
                    $product_query->execute();
                    $result = $product_query->get_result();
                    $products = $result->fetch_assoc();
                    $current_qte = $products['qte'];

                    // Calculer la nouvelle quantité
                    $new_qte = $current_qte - $product_qte;

                    // Mettre à jour la quantité du produit dans la BD
                    $update_qte_query = $con->prepare("UPDATE products SET qte = ? WHERE id = ? ");
                    $update_qte_query->bind_param("ii", $new_qte, $product_id);
                    $update_qte_query->execute();

                }

                // Supprimer les articles du panier de l'utilisateur
                $deleteCartQuery = "DELETE FROM carts WHERE user_id = '$user_id' ";
                $deleteCartQuery_run = mysqli_query($con, $deleteCartQuery);

                if($payment_mode == "cod"){
                    // Rediriger l'utilisateur avec un message de succès
                    $_SESSION['message'] = "Commande passe avec succes";
                    header('Location: ../my-order.php');
                    die();
                } else {
                    $_SESSION['message'] = "Commande passe avec succes";
                    header('Location: "../payment.php?tracking_no='.$tracking_no.'"');
                    echo 200;
                }
            }
        }
    } else {
        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas authentifié
        redirect('login.php', "Connextez-vous pour continuer");
    }

?>