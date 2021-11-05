<?php
require 'db.class.php';
require 'panier.class.php';
$bdd = new DB();
$panier = new panier($bdd);
session_start();
?>