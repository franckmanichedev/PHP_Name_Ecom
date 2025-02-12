<?php
    
    session_start();
    include("includes/header.php");
    include_once("functions/usersfunctions.php");

?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white" >
            <a href="index.php" class="redirection-link text-white">
                Home / 
            </a>
            Collections</h6>
    </div>
</div>
<div class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <h2>Nos categorie</h2>
            <hr>
                <div class="row">

                    <?php
                        $category = getAllActive('category');

                        if(mysqli_num_rows($category) > 0){
                            foreach($category as $item){
                                ?>
                                    <div class="col-lg-3 mb-2">
                                        <a href="products.php?category=<?= $item['slug']; ?>">
                                            <div class="card shadow-dark shadow">
                                                <div class="card-body">
                                                    <img src="uploads/<?= $item['image'];?>" alt="<?= $item['image'];?>" class="w-100" height="300px">
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

<?php include("includes/footer.php") ?>