<?php
require('_header.php');

if(isset($_GET)){
    $id = $_GET['id'];

    $del = $bdd->query("DELETE FROM products WHERE id=$id");
    
    header('location: admin.php');
}

?>
