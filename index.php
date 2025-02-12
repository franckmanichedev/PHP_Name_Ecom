<?php 
    session_start();
    include("functions/usersfunctions.php");
    include("includes/header.php");
    include "includes/slider.php"; 
?>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Tendance des ventes</h4>
                    <div class="underline mb-2"></div>
                    <div id="owl-demo" class="owl-carousel owl-theme">
                        <?php
                            $trendingProduct = getAllTrenfing();

                            if(mysqli_num_rows($trendingProduct) > 0){
                                foreach($trendingProduct as $item){
                                    ?>
                                        <div class="item">
                                            <a href="product-view.php?product=<?= $item['slug'];?>">
                                                <div class="card shadow-dark shadow ">
                                                    <div class="card-header">
                                                        <div class="img">
                                                            <img src="uploads/<?= $item['image'];?>" alt="Product image" class="w-100" height="400px">
                                                            <div class="icons">
                                                                <div class="first">
                                                                    <i class="bi bi-heart fw-bold"></i>
                                                                    <i class="bi bi-shop fw-bold"></i>
                                                                </div>
                                                                <div class="last">
                                                                    <i class="bi bi-star-fill fw-bold"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <h6 class=""><?= $item['name'];?></h6>
                                                            <h6 class="fw-bold"><?= $item['selling_price'];?> FCFA</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 bg-f2f2f2">
        <div class="container home-link">
            <div class="row">
                <div class="col-md-12">
                    <h4>A propos de nous</h4>
                    <div class="underline"></div>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt quis magnam, dicta optio neque commodi excepturi quasi quidem iure fugit, nostrum quae maiores laudantium eaque culpa sit in autem nesciunt?</p>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt quis magnam, dicta optio neque commodi excepturi quasi quidem iure fugit, nostrum quae maiores laudantium eaque culpa sit in autem nesciunt?<br> 
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Incidunt quis magnam, dicta optio neque commodi excepturi quasi quidem iure fugit, nostrum quae maiores laudantium eaque culpa sit in autem nesciunt?
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 bg-dark">
        <div class="container home-link">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <h4 class="text-white">Lynn Shop</h4>
                    <div class="underline"></div>
                    <div class="d-flex flex-column g-5">
                        <a href="index.php">
                            <i class="bi bi-dot"></i>Accueil
                        </a><br>
                        <a href="categories.php">
                            <i class="bi bi-dot"></i>A propos
                        </a><br>
                        <a href="categories.php">
                            <i class="bi bi-dot"></i>Collections
                        </a><br>
                        <a href="cart.php">
                            <i class="bi bi-dot"></i>Mon panier
                        </a><br>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <h4 class="text-white">Addresse</h4>
                    <div class="underline"></div>
                    <p class="text-white">
                        Buea: Mambanda Bonaberie,<br>
                        Yaounde: depot Bandja Aladji,<br>
                        Douala: Ancienne route, Akwa.<br>
                    </p>
                    <a href="tel:+674884620" class="text-white"> <i class="bi bi-phone"></i> +674884620</a><br>
                    <a href="mailto:franckmaniche6@gmail.com" class="text-white"> <i class="bi bi-envelope"></i> info@lynn-shop.com</a>
                </div>
                <div class="col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d497.47034146442866!2d9.6585653!3d4.0687038!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1061139a6bf50659%3A0xb51822f3f79683bf!2sPharmacie%20Populaire!5e0!3m2!1sfr!2scm!4v1739277074108!5m2!1sfr!2scm" class="w-100" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2 bg-danger">
        <div class="text-center">
            <p class="text-white mb-0">Tout droit revervé. Copyright @ Skills For Modernity - <?= date('Y')?> </p>
        </div>
    </div>

<?php include("includes/footer.php") ?>
<script>
    $(document).ready(function() {

        $("#owl-demo").owlCarousel({

            autoPlay: 2000, //Set AutoPlay to 3 seconds

            items : 4,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [979,3]

        });

    });
</script>