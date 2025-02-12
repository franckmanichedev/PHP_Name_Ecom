<?php

    session_start();
    include("includes/header.php");
    include_once("functions/usersfunctions.php");

    if(isset($_GET['product'])){

        $product_slug = $_GET['product'];
        $product_data = getSlugActive("products", $product_slug);
        $product = mysqli_fetch_assoc($product_data);

        if($product){
            ?>
                <div class="py-3 bg-primary">
                    <div class="container">
                        <h6 class="text-white">
                            <a href="index.php" class="text-white redirection-link">
                                Home /
                            </a>
                            <a href="categories.php" class="text-white redirection-link">
                                Collections / 
                            </a>
                                <?= $product['name']?>
                        </h6>
                    </div>
                </div>

                <div class="bg-light py-4">
                    <div class="py-3">
                        <div class="container mt-3">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="shadow-dark shadow">
                                        <img src="uploads/<?= $product['image']?>" alt="<?= $product['image']?>" class="w-100">
                                    </div>
                                </div>
                                <div class="col-md-8 container">
                                    <h4 class="fw-bold">
                                        <?= $product['name']?>
                                        <span class="float-end text-danger">
                                            <?php if($product['trending']){ 
                                                echo "Trending"; 
                                            }?>
                                        </span>
                                    </h4>
                                    <hr>
                                    <p><?= $product['small_description']?></p>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <h5><span class="text-success fw-bold"> <?= $product['selling_price']?> </span> FCFA</h5>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <h5><s class="text-danger"> <?= $product['original_price']?> </s> FCFA</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3 product-data" style="width: 125px;">
                                                <button class="input-group-text decrement-btn">-</button>
                                                <input type="text" class="form-control text-center input-qte" value="1" disabled>
                                                <button class="input-group-text increment-btn">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary addToCartBtn" value="<?= $product['id'] ;?>"><i class="bi bi-cart-fill me-2"></i>Ajouter au panier</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-danger"><i class="bi bi-heart-fill me-2"></i>Ajouter a la liste</button>
                                        </div>
                                    </div>
                                    <hr>

                                    <h6>Description du produit</h6>
                                    <p><?= $product['description']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        } else {
            echo "Produit non trouve !";
        }

    } else {
        echo "Quelque chose c'est tres mal passe !";
    }

    include("includes/footer.php") 

?>