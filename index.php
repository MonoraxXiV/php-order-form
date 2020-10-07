<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();


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
//your products with their price. changed the names so they are easier to call on
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
//gets the data food, being the link between drink/food.
//shows different arrays depending on food.
//also checks if food has a value, if not it's the default page and it shows sandwiches.

$food = $_GET['food'];
if (!isset($food)) {
    $products = $sandwiches;
} else if ($food == 0) {
    $products = $drinks;
} else {
    $products = $sandwiches;
}
$totalValue = 0;


//testing showed valid e-mail for my own
//obtaining all the data from post.
//declaring the error messages.
$zipcodeErr = $streetErr = $streetNumErr = $cityErr = "";

//checks if an e-mail has been sent.


/*
$zipCode= $_POST['zipcode'];
$streetNumber=$_POST['streetnumber'];
$streetName= $_POST['street'];
$city= $_POST['city'];
*/

//actions to do once the user pressed post.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //checks if the zipcode is filled in
    if (empty($_POST["zipcode"])) {
        $zipcodeErr = "zipcode is required";
        //checks if the zipcode has only numbers in it.
    } else if (is_numeric($_POST['zipcode'])) {

        $zipCode = test_input($_POST["zipcode"]);
        //saves the content into the session variable.
        $_SESSION['zipCodeSes'] = $zipCode;

    } else {
        //error message in case is_numeric returns false.
        $zipcodeErr = "zipcode must be a number";
    }
    //checks if streetnumber is filled in or not.
    if (empty($_POST["streetnumber"])) {
        $streetNumErr = "street number is required";
        //checks if streetnumber is solely numbers, might have issues people with the same house number.
    } else if (is_numeric($_POST["streetnumber"])) {
        $streetNumber = test_input($_POST["streetnumber"]);
        $_SESSION['streetnumber'] = test_input($_POST["streetnumber"]);

    } else {
        //error message in case a letter occured.
        $streetNumErr = "street number must be a number";
    }

    //checks if city is empty or filled in.
    if (empty($_POST["city"])) {
        $cityErr = " city is required";
    } else {
        //writes post data into a variable, that variable is written into the session.
        $city = test_input($_POST["city"]);
        $_SESSION['city'] = $city;
    }
    //checks if street input is empty or filled in.
    if (empty($_POST["street"])) {
        $streetErr = " street is required";
    } else {
        //writes post data into a variable, that variable is written into the session.
        $street = test_input($_POST["street"]);
        $_SESSION['streetSes'] = $street;
    }
    //checks if there is an e-mail listed, verifies if it's a valid e-mail address.
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
     filter_var($email, FILTER_VALIDATE_EMAIL) ;
     //saves the e-mail into the session.
        $_SESSION['email'] = $email;
    } else {
        //only echoes if the e-mail is wrong as it was not 100% required according to my reading comprehension.
        echo "error, invalid e-mail";
    }

    //changing time depending if express delivery was checked or not

    if (isset($_POST['express_delivery'])) {
        $newTime=date("H:i", strtotime('+45 minutes'));
        $time = "your food will arrive at ".$newTime;
        //also adding price to the total value;
        $totalValue += 5;
    }else {
        $newTime = date("H:i", strtotime('+2 hours'));
        $time= "your food will arrive at ".$newTime;
    }


    //check which checkboxes are checked
    $checkboxes = isset($_POST['products']) ? $_POST['products']: array();
    //var_dump($_POST['products']);
    // for each of these checked checkboxes, add the product price to totalValue.
    foreach ($checkboxes as $value) {

        $totalValue +=$value;
    }
    //array keys, echo price in value in form-view
//fixed this by making it compare all separately, otherwise it assigns the value.
    if ($zipcodeErr == "" && $streetErr == "" && $streetNumErr == "" && $cityErr == "") {
        echo "your order has been sent." . $time;
    }
    $_SESSION['totalses'] += $totalValue;

    //mail ( string $email , string $subject , string $message [, mixed $additional_headers [, string $additional_parameters ]] ) : bool
    $to = $email;
    $subject = "your order";
    $txt = "Hello customer, your order has been processed! It will arrive around ".$time;
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    //temporarily commented this mail () takes ages to load the page, and it doesn't send to gmail yet.
    //installed the sendmail to attempt to fix it.
    //still no mail arrival.
    //mail($to,$subject,$txt,$headers);
}
//First check for post, then check for session, not opposite.
//section to check if there is session data, if so add it to the variable.
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
}
if (isset($_SESSION['totalses'])) {
    $totalValue = $_SESSION['totalses'];
}
function test_input($data)
{
    //if understood correctly trim removes special characters, but can also be specified to trim certain letters in a string.
    $data = trim($data);
    //removes any slashes that might occur.
    $data = stripslashes($data);
    //Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities.
    $data = htmlspecialchars($data);
    return $data;
}

//required to link both files, was already included in code.
require 'form-view.php';

