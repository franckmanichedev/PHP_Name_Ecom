<?php
    session_start();
    include_once("functions/usersfunctions.php");
    include("includes/header.php");

    include("authentificate.php");
?>

    <div class="py-3 bg-primary">
        <div class="container">
            <h6 class="text-white">
                <a href="index.php" class="text-white redirection-link">
                    Home /
                </a>
                <a href="cart.php" class="text-white redirection-link">
                    Panier
                </a>
            </h6>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div id="mycart">
                        <?php
                            $items = getCartItems(); 
                            if(mysqli_num_rows($items) > 0){
                                ?>
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <h6>Produit</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6>Prix</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <h6>Quantite</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <h6>Retirer</h6>
                                    </div>
                                </div>
                                <div id="">
                                    <?php 
                                        foreach ($items as $item){
                                            ?>
                                                <div class="card shadow-dark shadow-sm mb-3">
                                                    <div class="row align-items-center p-3">
                                                        <div class="col-md-2">
                                                            <img src="uploads/<?= $item['image']?>" alt="<?= $item['image']?>" width="80px">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h5><?= $item['name']?></h5>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <h5>Rs<?= $item['selling_price']?></h5>
                                                        </div>
                                                        <div class="col-md-3 product-data">
                                                            <input type="hidden" class="prodId" value="<?= $item['product_id'] ?>">
                                                            <div class="input-group mb-3" style="width: 125px;">
                                                                <button class="input-group-text decrement-btn updateQte">-</button>
                                                                <input type="text" class="form-control text-center input-qte" value="<?= $item['product_qte']?>" disabled>
                                                                <button class="input-group-text increment-btn updateQte">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-danger btn-sm deleteBtn" value="<?= $item['cid'] ?>">
                                                                <i class="bi bi-trash me-2"></i>Supprimer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="float-end">
                                    <a href="checkout.php" class="btn btn-outline-primary">Proceder a l'achat</a>
                                </div>
                                <?php
                                    } else {
                                ?>
                                    <div class="card card-body text-center">
                                        <h4 class="py-3 text-danger">Votre panier est vide</h4>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("includes/footer.php") ?>