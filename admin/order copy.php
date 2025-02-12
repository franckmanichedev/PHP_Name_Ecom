<?php
    // session_start();
    include("includes/header.php"); 
    include("../middleware/adminMiddleware.php"); 
?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header ">
                        <h4 class="card-title">Commandes client</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive" id="category_table">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Tracking_No</th>
                                    <th>Prix</th>
                                    <th>Date</th>
                                    <th>Voir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $orders = getAllOrders();

                                    if(mysqli_num_rows($orders) > 0){
                                        foreach ($orders as $item){
                                            ?>
                                                <tr>
                                                    <td> <?= $item['id'] ?> </td>
                                                    <td> <?= $item['name'] ?> </td>
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