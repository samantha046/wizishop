<?php require 'header.php';

if ($_SESSION['connect'] == 0) {
    header('location: index.php');
}

?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Panier</li>
        </ol>
    </nav>
    <div class="row">
        <h2 class="text-end">Mon panier</h2>
    </div>
    <form method="post" action="panier.php">
        <div class="table">
            <div class="row">
                <div class="col-12 d-flex justify-content-between bg-info text-white">
                    <span class="title">Produit</span>
                    <span class="price">Prix</span>
                    <span class="quantity">Quantité</span>
                    <span class="action">Supprimer</span>
                </div>

                <?php
                $ids = array_keys($_SESSION['panier']);
                if (empty($ids)) {
                    $products = array();
                } else {
                    $products = $bdd->query('SELECT * FROM products WHERE id IN (' . implode(',', $ids) . ')');
                }
                foreach ($products as $product) :
                ?>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <span class="title"><?= $product->title; ?></span>
                            <span class="price"><?= number_format($product->price, 2, ',', ' '); ?> €</span>
                            <span class="quantity">
                                <input type="number" min="1" name="panier[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panier'][$product->id]; ?>">
                            </span>

                            <span class="action">
                                <a href="panier.php?delPanier=<?= $product->id; ?>" class="del"><i class="far fa-trash-alt"></i></a>
                            </span>
                        </div>
                    </div>
                <?php

                endforeach; ?>
                
                
            </div>
            <div class="row">
                <div class="col-8 d-flex justify-content-end align-items-center">
                <input type="submit" value="Recalculer" class="btn btn-info">
                
                    <span class="total">Total : <?= number_format($panier->total(), 2, ',', ' '); ?> € </span>
                
            </div></div>
        </div>

    </form>
</div>
<?php require 'footer.php'; ?>