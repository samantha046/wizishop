<?php
require 'header.php';
?>


<?php
// Page autorisée seulement aux administrateurs du site
// Verifie si une connexion est en cours et son rôle
if ($_SESSION['connect'] == 0) {
    header('location: index.php');
} else if ($_SESSION['role'] == false) {
    header('location: catalogue.php');
}

// Requête pour inserer des produits dans la table "products"
if (isset($_POST['insert'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if (!empty($title) && !empty($description) && !empty($price) && !empty($stock)) {
        $req = $bdd->query('INSERT INTO products (title, description, price, stock)
                VALUES (?,?,?,?)', array($title, $description, $price, $stock));
        header('Location: admin.php?success=1');
    }
}
?>
<div class="container">
    <div class="row">
        <div class="list-products col-8 m-auto">
            <h1 class="text-uppercase">Ajout d'articles</h1>
            <form action="admin.php" method="post" id="form-admin" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <input type="text" name="title" id="title" placeholder="Titre">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="description" name="description" rows="2" cols="50" placeholder="Description">
        </textarea>
                        </td>
                    </tr>
                    <td>
                        <input type="number" step="0.01" name="price" id="price" placeholder="Prix">
                    </td>

                    <td>
                        <input type="number" name="stock" id="stock" placeholder="Stock">
                    </td>

                    <td> <button name="insert" type="submit">Ajouter</button></td>
                    </tr>
                </table>
            </form>

            <?php // Pour récupérer toutes les infos du pruduit de tous les produits
            $products = $bdd->query('SELECT * FROM products'); ?>
        </div>

        <br><br>
    </div>
    <div class="row mt-5">

        <div class="list-products col-8 m-auto ">
            <h1>MODIFICATION</h1>
            <?php
            foreach ($products as $product) : ?>

                <?php
                // requête pour modifier un produit existant
                if (isset($_POST[$product->id])) {
                    $num = $product->id;
                    $title = $_POST["title$num"];
                    $description = $_POST["description$num"];
                    $price = $_POST["price$num"];
                    $stock = $_POST["stock$num"];
                    if (!empty($title) || !empty($description) || !empty($price) || !empty($stock)) {
                        $update = $bdd->query('UPDATE products SET title = ?,description = ?,price = ?,stock = ? WHERE id = ?', array($title, $description, $price, $stock, $num));
                        header('location: ./admin.php');
                    }
                }
                ?>


                <form action="admin.php" method="post" name="<?= $product->id ?>">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="title<?= $product->id ?>" value="<?php echo $product->title; ?>">
                            </td>
                            <td>
                                <input type="text" name="description<?= $product->id ?>" value="<?= $product->description; ?>">
                            </td>
                            <td>
                                <input type="text" name="price<?= $product->id ?>" value="<?= $product->price; ?>">
                            </td>
                            <td>
                                <input type="text" name="stock<?= $product->id ?>" value="<?= $product->stock; ?>">
                            </td>
                            <td>
                                <button type="submit" name="<?= $product->id ?>">Modifier</button>
                                <a href="delete-products.php?id=<?= $product->id ?>">Supprimer</a>
                            </td>

                        </tr>
                    </table>
                </form>

            <?php endforeach ?>

        </div>

    </div>
</div>
</div>


<?php include('footer.php') ?>