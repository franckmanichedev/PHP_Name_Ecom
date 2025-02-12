<?php 

    // session_start();
    include("includes/header.php"); 
    include("../middleware/adminMiddleware.php"); 
    
?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ajouter un nouveau produit</h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="">Categorie</label>
                                    <select  name="category_id" class="form-select bordered" required>
                                        <option selected disabled>Selectionnez une categorie</option>
                                        <?php
                                            $category = getAll("category");

                                            if(mysqli_num_rows($category) > 0){
                                                foreach ($category as $item){
                                                    ?>
                                                        <option value="<?= $item['id'] ; ?>"><?= $item['name'] ; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                echo"<option>Aucune category trouve !</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Name</label>
                                    <input type="text" name="name" placeholder="Entrer le nom" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Slug</label>
                                    <input type="text" name="slug" placeholder="Entrer le slug" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Small description</label>
                                    <textarea rows="5" name="small_description" placeholder="Entrer une Small description du produit ici" class="form-control" required></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea rows="5" name="description" placeholder="Entrer la description de categorie ici" class="form-control" required></textarea>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Prix d'achat</label>
                                    <input type="number" name="original_price" placeholder="Entrer le prix d'achat" class="form-control" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Prix de vente</label>
                                    <input type="number" name="selling_price" placeholder="Entrer le prix de vente" class="form-control" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="">Quantite du produit</label>
                                    <input type="number" name="qte" placeholder="Entrer la quantite du produit en stock" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Selectionner un image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Meta title</label>
                                    <input type="text" name="meta_title" placeholder="Entrer a meta title" class="form-control" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Meta description</label>
                                    <textarea rows="5" name="meta_description" placeholder="Entrer a meta description" class="form-control" required></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Meta keyword</label>
                                    <textarea rows="5" name="meta_keyword" placeholder="Entrer a meta keyword" class="form-control" required></textarea>
                                </div>
                                <div class="row col-lg-12 mt-2">
                                    <div class="col-lg-6">
                                        <label for="">Statut</label>
                                        <input type="checkbox" name="statut">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="">Trending</label>
                                        <input type="checkbox" name="trending">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary" name="add_product_btn">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include("./includes/footer.php"); ?>