<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();
$_SESSION['Kayalin'];

function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

whatIsHappening();
//your products with their price.
$sandwiches = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];

$drinks = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];
//get food
//change names
$food=$_GET['food'];

if ($food==1){
    $products=$sandwiches;
} else if ($food==0){
    $products=$drinks;
}

$totalValue = 0;
//testing showed valid e-mail for my own
//obtaining all the data from post.
$zipcodeErr = $streetErr = $streetNumErr = $cityErr = "";
$email = $_POST['email'];

/*
$zipCode= $_POST['zipcode'];
$streetNumber=$_POST['streetnumber'];
$streetName= $_POST['street'];
$city= $_POST['city'];
*/
if (isset($_SESSION['streetnumber'])) {
    $streetNumber = test_input($_SESSION['streetnumber']);
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
if (isset($_SESSION['streetSes'])) {
    $street = $_SESSION['streetSes'];
}
if (isset($_SESSION['city'])) {
    $city = $_SESSION['city'];
}
if (isset($_SESSION['zipCodeSes'])) {
    $zipCode = $_SESSION['zipCodeSes'];
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "zipcode is required";
    } else if (is_numeric($_POST['zipcode'])) {

        $zipCode = test_input($_POST["zipcode"]);
        $_SESSION['zipCodeSes'] = $zipCode;

    } else {
        $zipcodeErr = "zipcode must be a number";
    }

    if (empty($_POST["streetnumber"])) {
        $streetNumErr = "street number is required";
    } else if (is_numeric($_POST["streetnumber"])) {
        $streetNumber = test_input($_POST["streetnumber"]);
        $_SESSION['streetnumber'] = test_input($_POST["streetnumber"]);

    } else {
        $streetNumErr = "street number must be a number";
    }


    if (empty($_POST["city"])) {
        $cityErr = " city is required";
    } else {
        $city = test_input($_POST["city"]);
        $_SESSION['city'] = $city;
    }
    if (empty($_POST["street"])) {
        $streetErr = " street is required";
    } else {
        $street = test_input($_POST["street"]);
        $_SESSION['streetSes'] = $street;
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email'] = $email;
    } else {
        echo "error, invalid e-mail";
    }
//fixed this by making it compare all separately, otherwise it assigns the value.
    if ($zipcodeErr == "" && $streetErr == "" && $streetNumErr == "" && $cityErr == "") {
        echo "your order has been sent";
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


require 'form-view.php';

