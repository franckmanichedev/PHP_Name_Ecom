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
                        <h4 class="card-title">Toute les categories</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive" id="category_table">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Images</th>
                                <th>Statut</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $category = getAll("category");

                                    if(mysqli_num_rows($category) > 0){
                                        foreach ($category as $item){
                                            ?>
                                                <tr>
                                                    <td><?= $item['id'] ?></td>
                                                    <td><?= $item['name'] ?></td>
                                                    <td>
                                                        <img src="../uploads/<?= $item['image'] ?>" alt="<?= $item['image'] ?>" height="50px" width="auto">
                                                    </td>
                                                    <td><?= $item['statut'] == "0" ? "Visible":"Masque" ?></td>
                                                    <td>
                                                        <a href="edit-category.php?id=<?= $item['id'] ?>" class="btn btn-primary">Modifier</a>
                                                    </td>
                                                    <td>
                                                        <form action="code.php" method="POST">
                                                            <input type="hidden" name="category_id" value="<?= $item['id'] ?>" />
                                                            <button class="btn btn-danger" type="submit" name="delete_category_btn">Supprimer</button>
                                                        </form>
                                                        <!-- <button type="button" class="btn btn-danger delete_category_btn" type="submit" value="">Supprimer</button> -->
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td class='alert alert-danger' colspan='5'>Aucune catégorie trouvée</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("./includes/footer.php"); ?>