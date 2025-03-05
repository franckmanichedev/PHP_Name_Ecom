<?php

    session_start();
    include("../config/dbconfig.php");
    include("../functions/myfunctions.php");

    // Categories part
    if (isset($_POST['add_category_btn'])){
        $name = $con->real_escape_string(($_POST["name"]));
        $slug = $con->real_escape_string(($_POST["slug"]));
        $description = $con->real_escape_string(($_POST["description"]));
        $meta_title = $con->real_escape_string(($_POST["meta_title"]));
        $meta_description = $con->real_escape_string(($_POST["meta_description"]));
        $meta_keywords = $con->real_escape_string(($_POST["meta_keyword"]));

        // Si le checkbox est coché on insere 1 sinon 0
        $statut = isset($_POST["statut"]) ? "1":"0";
        $popular = isset($_POST["popular"]) ? "1":"0";

        $image = $_FILES['image']['name'];
        $path = "../uploads";
        
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $filename = time().".".$image_ext;

        // Préparez la requête pour insérer une nouvelle catégorie
        $category_query = $con->prepare("INSERT INTO category 
        (`name`, slug, `description`, `meta_title`, `meta_description`, `meta_keyword`,statut, popular, `image`)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $category_query->bind_param("sssssssss", $name, $slug, $description, $meta_title, $meta_description, $meta_keywords, $statut, $popular, $filename);
        
        // Vérifiez si l'insertion dans la base de données a réussi
        if($category_query->execute()){
            // Verifier si le fichier est charge avec success
            if(move_uploaded_file($_FILES['image']['tmp_name'], $path ."/". $filename)){
                redirect("add-category.php", "Categorie ajoute avec succes !");
            } else {
                // Affichez des erreurs détaillées
                $error_message = "Erreur lors du telechargement du fichier !";
                switch ($_FILES['image']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        $error_message .= " Le fichier téléchargé est trop lourd 2Mo maximum";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $error_message .= " Le fichier téléchargé dépasse la directive (2Mo maximum)";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error_message .= " Le fichier n'a été que partiellement téléchargé.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $error_message .= " Aucun fichier n'a été téléchargé.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $error_message .= " Il manque un dossier temporaire.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $error_message .= " Échec de l'écriture du fichier sur le disque.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $error_message .= " Une extension PHP a arrêté le téléchargement du fichier.";
                        break;
                    default:
                        $error_message .= " Erreur inconnue.";
                        break;
                }
                redirect("add-category.php",$error_message);
            }
        } else {
            redirect("add-category.php", "Erreur d'ajout d ela categorie !" . $category_query->error);
        }
        $category_query->close();
    } else if(isset($_POST['update_category_btn'])){
        $category_id = $_POST['category_id'];
        $name = $con->real_escape_string(($_POST["name"]));
        $slug = $con->real_escape_string(($_POST["slug"]));
        $description = $con->real_escape_string(($_POST["description"]));
        $meta_title = $con->real_escape_string(($_POST["meta_title"]));
        $meta_description = $con->real_escape_string(($_POST["meta_description"]));
        $meta_keywords = $con->real_escape_string(($_POST["meta_keyword"]));
        $statut = isset($_POST["statut"]) ? "1":"0";
        $popular = isset($_POST["popular"]) ? "1":"0";

        $new_image = $_FILES['image']['name'];
        $old_image = $_POST['old_image'];

        if($new_image != ""){
            $update_filename = time() . "." . strtolower(pathinfo($new_image, PATHINFO_EXTENSION));
        } else {
            $update_filename = $old_image;
        }

        $path = "../uploads";

        $update_query = $con->prepare("UPDATE category SET `name`=?, slug=?, `description`=?, `meta_title`=?, `meta_description`=?, `meta_keyword`=?,statut=?, popular=?, `image`=? WHERE id=?");
        $update_query->bind_param("sssssssssi", $name, $slug, $description, $meta_title, $meta_description, $meta_keywords, $statut, $popular, $update_filename, $category_id);
        if($update_query->execute()){
            if ($new_image != "") {
                if(move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $update_filename)){
                    if(file_exists('../uploads/'.$old_image)){
                        unlink('../uploads/'.$old_image);
                    }
                } else {
                    redirect("edit-category.php?id=$category_id", "Erreur lors du chargement du fichier !");
                    exit();
                }
            }
            redirect("edit-category.php?id=$category_id", "Categorie mise a jour avec succes !");
        } else {
            redirect("edit-category.php?id=$category_id", "Erreur de mise a jour de la categorie !" . $update_query->error);
        }
        $update_query->close();
    } else if(isset($_POST['delete_category_btn'])){
        $category_id = $_POST['category_id'];

        $category_query = $con->prepare("SELECT * FROM category WHERE id=?");
        $category_query->bind_param("i", $category_id);
        $category_query->execute();
        $result = $category_query->get_result();
        $category_result = $result->fetch_assoc();

        $image = $category_result['image'];

        $delete_query = $con->prepare("DELETE FROM category WHERE id=?");
        $delete_query->bind_param("i", $category_id);
        $delete_query->execute();

        if($delete_query->affected_rows > 0){
            if(file_exists('../uploads/'.$image)){
                unlink('../uploads/'.$image);
            }
            redirect("category.php", "Category supprimer avec success !");
            // echo 200;
        } else {
            redirect("category.php", "Erreur lors du chargement du fichier !");
            // echo 500;
        }
    } 
    
    // Product part
    else if(isset($_POST['add_product_btn'])){
        $category_id = ($_POST['category_id']) ;
        $name = $con->real_escape_string(($_POST["name"]));
        $slug = $con->real_escape_string(($_POST["slug"]));
        $small_description = $con->real_escape_string(($_POST["small_description"]));
        $description = $con->real_escape_string(($_POST["description"]));
        $original_price = $con->real_escape_string(($_POST["original_price"]));
        $selling_price = $con->real_escape_string(($_POST["selling_price"]));
        $qte = $con->real_escape_string(($_POST["qte"]));
        $meta_title = $con->real_escape_string(($_POST["meta_title"]));
        $meta_description = $con->real_escape_string(($_POST["meta_description"]));
        $meta_keywords = $con->real_escape_string(($_POST["meta_keyword"]));

        // Si le checkbox est coché on insere 1 sinon 0
        $statut = isset($_POST["statut"]) ? "1":"0";
        $trending = isset($_POST["trending"]) ? "0":"1";

        $image = $_FILES['image']['name'];
        $path = "../uploads";
        
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $filename = time().".".$image_ext;

        if($name != "" && $slug != "" && $description != ""){
            // Préparez la requête pour insérer une nouvelle catégorie
            $products_query = $con->prepare("INSERT INTO products 
            (category_id, `name`, slug, small_description,`description`, original_price, selling_price, qte, `meta_title`, `meta_description`, `meta_keywords`, statut, trending, `image`)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $products_query->bind_param("issssddissssss", $category_id, $name, $slug, $small_description, $description, $original_price, $selling_price, $qte, $meta_title, $meta_description, $meta_keywords, $statut, $trending, $filename);
            
            // Vérifiez si l'insertion dans la base de données a réussi
            if($products_query->execute()){
                // Verifier si le fichier est charge avec success
                if(move_uploaded_file($_FILES['image']['tmp_name'], $path ."/". $filename)){
                    redirect("add-category.php", "Produit ajoute avec succes !");
                } else {
                    // Affichez des erreurs détaillées
                    $error_message = "Erreur lors du telechargement du fichier !";
                    switch ($_FILES['image']['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            $error_message .= " Le fichier téléchargé est trop lourd 2Mo maximum";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $error_message .= " Le fichier téléchargé dépasse la directive (2Mo maximum)";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $error_message .= " Le fichier n'a été que partiellement téléchargé.";
                            break;
                        case UPLOAD_ERR_NO_FILE:
                            $error_message .= " Aucun fichier n'a été téléchargé.";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $error_message .= " Il manque un dossier temporaire.";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $error_message .= " Échec de l'écriture du fichier sur le disque.";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $error_message .= " Une extension PHP a arrêté le téléchargement du fichier.";
                            break;
                        default:
                            $error_message .= " Erreur inconnue.";
                            break;
                    }
                    redirect("add-product.php",$error_message);
                }
            } else {
                redirect("add-product.php", "Erreur d'ajout du produit !" . $products_query->error);
            }
            $products_query->close();
        } else {
            redirect("add-product.php", "Veuillez renseigner tout les champs !");
        }
    } else if(isset($_POST['update_product_btn'])){
        $product_id = ($_POST['product_id']);
        $category_id = ($_POST['category_id']) ;

        $name = $con->real_escape_string(($_POST["name"]));
        $slug = $con->real_escape_string(($_POST["slug"]));
        $small_description = $con->real_escape_string(($_POST["small_description"]));
        $description = $con->real_escape_string(($_POST["description"]));
        $original_price = $con->real_escape_string(($_POST["original_price"]));
        $selling_price = $con->real_escape_string(($_POST["selling_price"]));
        $qte = $con->real_escape_string(($_POST["qte"]));
        $meta_title = $con->real_escape_string(($_POST["meta_title"]));
        $meta_description = $con->real_escape_string(($_POST["meta_description"]));
        $meta_keywords = $con->real_escape_string(($_POST["meta_keyword"]));

        // Si le checkbox est coché on insere 1 sinon 0
        $statut = isset($_POST["statut"]) ? "1":"0";
        $trending = isset($_POST["trending"]) ? "0":"1";

        $path = "../uploads";
        
        $new_image = $_FILES['image']['name'];
        $old_image = $_POST['old_image'];

        // Si new_image n'est pas nul alors on insere la nouvelle image choisit par update_image, 
        // Sinon on garde l'ancienne dans update_image
        if($new_image != ""){
            $update_filename = time() . "." . strtolower(pathinfo($new_image, PATHINFO_EXTENSION));
        } else {
            $update_filename = $old_image;
        }

        $update_query = $con->prepare("UPDATE products SET category_id=?, `name`=?, slug=?, small_description=?,`description`=?, original_price=?, selling_price=?, qte=?, `meta_title`=?, `meta_description`=?, `meta_keywords`=?, statut=?, trending=?, `image`=? WHERE id=?");
        $update_query->bind_param("issssddissssssi", $category_id, $name, $slug, $small_description, $description, $original_price, $selling_price, $qte, $meta_title, $meta_description, $meta_keywords, $statut, $trending, $update_filename, $product_id);
        if($update_query->execute()){
            if ($new_image != "") {
                if(move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $update_filename)){
                    if(file_exists('../uploads/'.$old_image)){
                        unlink('../uploads/'.$old_image);
                    }
                } else {
                    redirect("edit-product.php?id=$product_id", "Erreur lors du chargement du fichier !");
                    exit();
                }
            }
            redirect("edit-product.php?id=$product_id", "Categorie mise a jour avec succes !");
        } else {
            redirect("edit-product.php?id=$product_id", "Erreur de mise a jour de la categorie !" . $update_query->error);
        }
    } else if(isset($_POST['delete_product_btn'])){
        $product_id = $con->real_escape_string(($_POST['product_id']));

        $product_query = $con->prepare("SELECT * FROM products WHERE id=?");
        $product_query->bind_param("i", $product_id);
        $product_query->execute();
        $result = $product_query->get_result();
        $product_result = $result->fetch_assoc();

        $image = $product_result['image'];

        $delete_query = $con->prepare("DELETE FROM products WHERE id=?");
        $delete_query->bind_param("i", $product_id);
        $delete_query->execute();

        if($delete_query->affected_rows > 0){
            if(file_exists('../uploads/'.$image)){
                unlink('../uploads/'.$image);
            }
            redirect("product.php", "Produit supprimer avec success !");
            // echo 200;
        } else {
            redirect("product.php", "Erreur lors du chargement du fichier !");
            // echo 500;
        }
    } else if(isset($_POST['update_order_btn'])){
        $tracking_no = $_POST['tracking_no'];
        $order_statut = $_POST['order_statut'];

        $order_query = $con->prepare("UPDATE others SET `status` = ? WHERE tracking_no = ?");
        $order_query->bind_param("is", $order_statut, $tracking_no);
        $order_query->execute();
        
        redirect("view-order.php?t=$tracking_no", "Status Commande mis a jour avec succes !");

    } else {
        header("Location: index.php");
    }
?>