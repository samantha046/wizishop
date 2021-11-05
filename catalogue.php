<?php
include('header.php'); 
if ($_SESSION['connect'] == 0) {
    header('location: index.php');
}

?>

<div id="content" class="container catalogue">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Catalogue</li>
  </ol>
</nav>

    <section class="catalogue">
        <div class="row">
            <div class="col">
            <a href="panier.php"><p>Voir mon panier</p></a>
            </div>
        </div>
        <?php $products = $bdd->query('SELECT * FROM products'); ?>

<div class="row">
        <div class="articles card-deck col-8 m-auto">

            <?php foreach ($products as $product) : ?>

                <div class="article card mb-3">
                    <div class="card-body">
                    <h3 class="card-title"><?= $product->title ?></h3>
                    <p class="card-text"><?= $product->description ?></p>
                    <p><?= $product->price ?>€ <br>
                        <?php
                        if ($product->stock == 0) { ?>
                            <p class="indisponible">Plus disponible</p>
                        <?php
                        } else {
                        ?>
                            <a class="addPanier" href="addpanier.php?id=<?= $product->id; ?>">Ajouter au panier</a>
                        <?php
                        }
                        ?>

                </div></div>
            <?php endforeach ?>

    

    </div></div>
    </section>
</div>

<?php
include('footer.php'); ?>