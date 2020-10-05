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
//obtaining all the data from post.
$zipcodeErr=$streetErr=$streetNumErr=$cityErr= "";
$email= $_POST['email'];

$zipCode= $_POST['zipcode'];
$streetNumber=$_POST['streetnumber'];
$streetName= $_POST['street'];
$city= $_POST['city'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "zipcode is required";

    } else {
        // maybe combine these two? if there is input and this is numeric else ...
        $zipCode = test_input($_POST["zipcode"]);
        if (is_numeric($zipCode)){

        }else{
            echo "zipcode must be a number";
        }
    }
    if (empty($_POST["streetnumber"])) {
        $streetNumErr = "street number is required";
    } else {
        $streetNumber = test_input($_POST["streetnumber"]);

        if(is_numeric($streetNumber)){

        }else {
            echo "street number must be a number";
        }

    }
    if (empty($_POST["city"])) {
        $cityErr = " city is required";
    } else {
        $city = test_input($_POST["street"]);
    }
    if (empty($_POST["street"])) {
        $streetErr= " street is required";
    } else {
        $street = test_input($_POST["street"]);
    }
}

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL)){

}
else {

}

require 'form-view.php';

