<?php

    $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

?>

<div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="" class="simple-text">
                ZONE TRAVEL
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item <?= $page == "index.php" ? "active":"";?>">
                <a class="nav-link" href="index.php"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>Statistique</p>
                </a>
            </li>
            <li class="nav-item <?= $page == "add-category.php" ? "active":"";?>">
                <a class="nav-link" href="add-category.php">
                    <i class="bi bi-plus-lg"></i>
                    <p>Ajouter categorie</p>
                </a>
            </li>
            <li class="nav-item <?= $page == "category.php" ? "active":"";?>">
                <a class="nav-link" href="category.php">
                    <i class="bi bi-eye-fill"></i>
                    <p>Voir categorie</p>
                </a>
            </li>
            <li class="nav-item <?= $page == "add-product.php" ? "active":"";?>">
                <a class="nav-link" href="add-product.php">
                    <i class="bi bi-cart-plus"></i>
                    <p>Ajouter produit</p>
                </a>
            </li>
            <li class="nav-item <?= $page == "product.php" ? "active":"";?>">
                <a class="nav-link" href="product.php">
                    <i class="bi bi-search"></i>
                    <p>Voir produit</p>
                </a>
            </li>
            <li class="nav-item <?= $page == "order.php" ? "active":"";?>">
                <a class="nav-link" href="order.php">
                    <i class="bi bi-bag"></i>
                    <p>Commandes</p>
                </a>
            </li>
            <li class="nav-item active active-pro">
                <a class="nav-link active" href="../logout.php">
                    <i class="nc-icon nc-alien-33"></i>
                    <p>Se deconnecter</p>
                </a>
            </li>
        </ul>
    </div>
</div>