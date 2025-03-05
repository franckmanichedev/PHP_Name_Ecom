<?php
    session_start();
    include_once("functions/usersfunctions.php");
    include("includes/header.php");

    include("authentificate.php");

    if(isset($_GET['t'])){
        $tracking_no = $_GET['t'];

        $orderData = checkTrackigNoValid($tracking_no);
        if(mysqli_num_rows($orderData) <= 0){
            ?>
                <h4>Quelque chose c'est mal passe !</h4>
            <?php 
            die();
        }
    } else {
        ?>
            <h4>Quelque chose c'est mal passe !</h4>
        <?php
        die();
    }
    $item = mysqli_fetch_assoc($orderData);
?>

    <div class="py-3 bg-primary">
        <div class="container">
            <h6 class="text-white">
                <a href="index.php" class="text-white redirection-link">
                    Home /
                </a>
                <a href="my-order.php" class="text-white redirection-link">
                    Mes commandes /
                </a>
                <a href="#" class="text-white redirection-link">
                    Voir commandes
                </a>
            </h6>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
                                <h4 class="text-center">Voir commande</h4>
                                <a href="my-order.php" class="btn btn-warning"><i class="bi bi-reply-fill"></i> Retour</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Details livraison</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="fw-bold mb-2">Nom</label>
                                                <div class="border p-1">
                                                    <?= $item['name']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="fw-bold mb-2">Email</label>
                                                <div class="border p-1">
                                                    <?= $item['email']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="fw-bold mb-2">Telephone</label>
                                                <div class="border p-1">
                                                    <?= $item['phone']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="fw-bold mb-2">Tracking No</label>
                                                <div class="border p-1">
                                                    <?= $item['tracking_no']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Addresse</label>
                                                <div class="border p-1">
                                                    <?= $item['address']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Pin code</label>
                                                <div class="border p-1">
                                                    <?= $item['pincode']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Details commande</h4>
                                        <hr>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Prix</th>
                                                    <th>Quantite</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $user_id = $_SESSION['auth_user']['user_id'];
                                                    $order_query = "SELECT o.id as `oid`, o.tracking_no, o.user_id, oi.*, oi.qte as otherqte,p.* 
                                                                    FROM others o
                                                                    JOIN others_items oi ON o.id = oi.other_id
                                                                    JOIN products p ON p.id = oi.product_id 
                                                                    WHERE o.user_id = '$user_id' AND o.tracking_no = '$tracking_no'";
                                                    $order_query_run = mysqli_query($con, $order_query);
                                                    if(mysqli_num_rows($order_query_run) > 0){
                                                        foreach ($order_query_run as $key) {
                                                            ?>
                                                                
                                                                <tr>
                                                                    <td class="align-middle">
                                                                        <img src="uploads/<?= $key['image'] ?>" alt="<?= $key['name'] ?>" width="50px" height="50px">
                                                                        <?= $key['name'] ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?= $key['price'] ?>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <?= $key['otherqte'] ?>
                                                                    </td>
                                                                </tr>

                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center">Aucune donnée trouvée</td>
                                                        </tr>
                                                        <?php
                                                    }

                                                ?>
                                            </tbody>
                                        </table>

                                        <hr>
                                        <h5 class="row">
                                            <p class="col-md-9">Prix total </p>
                                            <span class="float-end fw-bold col-md-3">Rs <?= $item['total_price']?></span>
                                        </h5>

                                        <hr>
                                        <label class="fw-bold">Mode de paiement</label>
                                        <div class="border p-1 mb-3">
                                            <?= $item['payment_mode'] ?>
                                        </div>

                                        <label class="fw-bold">Satut</label>
                                        <div class="border p-1 mb-3">
                                            <?php
                                                if($item['status'] == 0){
                                                    echo "Under process";
                                                } else if ($item['status'] == 1){
                                                    echo "Completed";
                                                } else if($item['status'] == 2){
                                                    echo "Cancelled";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("includes/footer.php") ?>