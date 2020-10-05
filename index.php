<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;
//testing showed valid e-mail for my own
$email= $_POST['email'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "valid e-mail";
}
else {
    echo "invalid e-mail";
}
//validating if zipcode is a number
$zipCode= $_POST['zipcode'];
if (is_numeric($zipCode)){

}else{
    echo "zipcode must be a number";
}
//validating streetnumber is an actual number
$streetNumber=$_POST['streetnumber'];
if(is_numeric($streetNumber)){
    echo "street number is valid";
}else {
    echo "street number must be a number";
}


require 'form-view.php';

