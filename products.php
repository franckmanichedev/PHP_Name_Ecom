<?php

    session_start();
    include("includes/header.php");
    include_once("functions/usersfunctions.php");

    if(isset($_GET['category'])){

        $category_slug = $_GET['category'];
        $category_data = getSlugActive("category", $category_slug);
        $category = mysqli_fetch_assoc($category_data);

        if($category){
            
            $cat_id = $category['id'];

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

                            <?= $category['name']?></h6>
                    </div>
                </div>
                <div class="py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                            <h2>Nos categorie</h2>
                            <hr>
                                <div class="row">
                                    <?php
                                        $product = getProductByCategory($cat_id);

                                        if(mysqli_num_rows($product) > 0){
                                            foreach($product as $item){
                                                ?>
                                                    <div class="col-lg-3 mb-2">
                                                        <a href="product-view.php?product=<?= $item['slug'];?>">
                                                            <div class="card shadow-dark shadow ">
                                                                <div class="card-header">
                                                                    <img src="uploads/<?= $item['image'];?>" alt="Product image" class="w-100" height="300px">
                                                                    <h4 class="text-center" ><?= $item['name'];?></h4>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php
                                            }
                                        } else {
                                            echo "Donne non disponible";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php 
            
        } else {
            echo "Quelque chose c'est tres mal passe !";
        }

    } else {
        echo "Quelque chose c'est mal passe !";
    }

    include("includes/footer.php") 

?>