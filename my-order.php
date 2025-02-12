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
                <a href="my-orther.php" class="text-white redirection-link">
                    Mes commandes
                </a>
            </h6>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <h4>Mes Commandes</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tracking_No</th>
                                    <th>Prix</th>
                                    <th>Date</th>
                                    <th>Voir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $orders = getOrders();

                                    if(mysqli_num_rows($orders) > 0){
                                        foreach ($orders as $item){
                                            ?>
                                                <tr>
                                                    <td> <?= $item['id'] ?> </td>
                                                    <td> <?= $item['tracking_no'] ?> </td>
                                                    <td> <?= $item['total_price'] ?> </td>
                                                    <td> <?= $item['created_at'] ?> </td>
                                                    <td>
                                                        <a href="view-order.php?t=<?= $item['tracking_no'] ?>" class="btn btn-primary">Voir les details</a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                            <tr>
                                                <td colspan="5" class="text-danger text-center">Aucune donnee</td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("includes/footer.php") ?>