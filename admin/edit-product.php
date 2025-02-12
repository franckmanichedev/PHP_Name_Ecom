<?php 

    // session_start();
    include("includes/header.php"); 
    include("../middleware/adminMiddleware.php"); 
    
?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                
                <?php
                    if(isset($_GET['id']) && !empty($_GET['id'])){
                        $id = $_GET['id'];
                        $product = getById("products", $id);

                        if(mysqli_num_rows($product) > 0){
                            $data = mysqli_fetch_assoc($product);
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>
                                            Modifier un produit
                                            <a href="product.php" class="btn btn-primary float-end">Retour</a>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="code.php" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="">Categorie</label>
                                                    <select  name="category_id" class="form-select bordered" required>
                                                        <option disabled>Selectionnez une category</option>
                                                        <?php
                                                            $category = getAll("category");

                                                            if(mysqli_num_rows($category) > 0){
                                                                foreach ($category as $item){
                                                                    ?>
                                                                        <option value="<?= $item['id'] ; ?>" <?= $data['category_id']? "selected":"" ?>><?= $item['name'] ; ?></option>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo"<option>Aucune category trouve !</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="row col-lg-12">
                                                    <input type="hidden" name="product_id" value="<?= $data['id']?>">
                                                    <div class="col-lg-6">
                                                        <input type="hidden" name="category_id" value="<?= $data['id']?>">
                                                        <label for="">Nom produit</label>
                                                        <input type="text" name="name" value="<?= $data['name']?>" placeholder="Entrer le nom de categorie" class="form-control" required>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="">Slug</label>
                                                        <input type="text" name="slug" value="<?= $data['slug']?>" placeholder="Entrer le slug" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Small description</label>
                                                    <textarea rows="5" name="small_description" class="form-control" required><?= $data['small_description']?></textarea>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Description</label>
                                                    <textarea rows="5" name="description" class="form-control" required><?= $data['description']?></textarea>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Prix d'achat</label>
                                                    <input type="number" value="<?= $data['original_price'] ?>" name="original_price" class="form-control" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Prix de vente</label>
                                                    <input type="number" value="<?= $data['selling_price'] ?>" name="selling_price" class="form-control" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="">Quantite du produit</label>
                                                    <input type="number" value="<?= $data['qte'] ?>" name="qte" class="form-control" required>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Modifier image</label>
                                                    <input type="file" name="image" class="form-control">
                                                    <label for="">Image actuelle</label>
                                                    <input type="hidden" name="old_image" value="<?= $data['image']?>">
                                                    <img src="../uploads/<?= $data['image'] ;?>" alt="<?= $data['image'] ;?>" height="50px" width="auto">
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Meta title</label>
                                                    <input type="text" name="meta_title" value="<?= $data['meta_title']?>" placeholder="Entrer a meta title" class="form-control" required>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Meta description</label>
                                                    <textarea rows="5" name="meta_description" class="form-control" required><?= $data['meta_description']?></textarea>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label for="">Meta keyword</label>
                                                    <textarea rows="5" name="meta_keyword"class="form-control" required><?= $data['meta_keywords']?></textarea>
                                                </div>
                                                <div class="row col-lg-12 mt-2">
                                                    <div class="col-lg-6">
                                                        <label for="">Statut</label>
                                                        <input type="checkbox" <?= $data['statut'] == '0' ? "":"checked" ?> name="statut">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="">Popularite</label>    
                                                        <input type="checkbox" <?= $data['trending'] == '0' ? "":"checked" ?> name="trending">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-primary" name="update_product_btn">Modifier</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php
                        } else {
                            echo "<p class='alert alert-danger'>Oops, l'id a ete perdu !</p>";
                        }

                    } else {
                        echo "<p class='alert alert-danger'>Hey, l'id a ete perdu !</p>";
                    }
                ?>
            </div>
        </div>
    </div>

<?php include("./includes/footer.php"); ?>