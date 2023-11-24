<?php

function startDatabase() {
    $servername = "localhost";
    $username = "nicole_web_shop_user";
    $password = "5-W?QM&mEXws%V>";
    $dbname = "nicole_web_shop_user"; 

    // Verbinding maken
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Verbinding checken
    if (!$conn) {
        die("Verbinding mislukt: " . mysqli_connect_error());
    }
    return array('conn' => $conn, 'servername' => $servername, 'username' => $username, 'password' => $password, 'dbname' => $dbname);
}

function checkUserExist($data) {
   
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $email = $data['email'];
    $sql = "SELECT name FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data['emailErr'] = "Dit e-mailadres is al in gebruik";
            break;     
        }
    }
    return $data;
    mysqli_close($conn);    
}

function storeUser($email, $name, $password)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $sql = "INSERT INTO users (name, email, password)
    VALUES ('$name', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        echo "Nieuw record succesvol aangemaakt";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

function checkUserLogin($data) {
    $dbInfo = startDatabase();
    $conn = $dbInfo['conn'];
    //declareVariables
    $email = $data['email'];
    $password = $data['password'];
    $sql = "SELECT id, name FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_fetch_array($result);
    if(isset($check)){
        $data['valid'] = true;
        $data['id'] = $check['id'];
        $data['name'] = $check['name'];
    } else {
        $data['emailErr'] = $data['passwordErr'] = 'Onjuiste combinatie';
    }    
    return $data;
    mysqli_close($conn);    
}

function checkPassword($data)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $userId = $data['userId'];
    $password = $data['password'];
    $sql = "SELECT password FROM users WHERE id = '$userId' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_fetch_array($result);
    if (isset($check)){
        $data['passwordErr'] ="";
    } else {
        $data['passwordErr'] = 'Uw oude wachtwoord is onjuist';
    }
}

function updatePassword($data)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $userId = $_SESSION['userId'];
    $password = $data['newpassword'];
    $sql = "UPDATE password FROM users WHERE id = '$userId'";           //Dit moet een ander comando met SET worden
    if (mysqli_query($conn, $sql)) {
        echo "Wachtwoord succesvol aangepast";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    return $data;
    mysqli_close($conn);
}

//Shop
function getShopItems ()
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $sql = "SELECT * FROM item";
    $results = mysqli_query($conn, $sql);
    $item = array();
    while ($row = mysqli_fetch_array($results)) {
        $item[$row['id']] = $row;
    }
    mysqli_close($conn);
    return $item;
}

//Details
function getItemDetails ($itemId)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $sql = "SELECT * FROM item WHERE id = '$itemId'";
    $results = mysqli_query($conn, $sql);
    $itemDetails = mysqli_fetch_array($results);
    mysqli_close($conn);
    return $itemDetails;
}

//Order plaatsen
function insertOrderInDb($cart)
{
    $userId = $_SESSION['userId']; 
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $cart = $_SESSION['cart'];
    $orderDate = date("ymdHis"); 
    $orderNumber = $orderDate . $userId;
    //in tabel orders plaatsen
    $sqlInsertOrder = "INSERT INTO orders (user_id, order_nr) VALUES ('$userId', '$orderNumber')";
    mysqli_query($conn, $sqlInsertOrder);
    $orderId = mysqli_insert_id($conn); //laatste orderId ophalen
    //in tabel order_line
    foreach ($cart as $itemId => $quantity) {
        $sqlInsertOrderLine = "INSERT INTO order_line (order_id, item_id, quantity) VALUES ('$orderId', '$itemId', '$quantity')";
        mysqli_query($conn, $sqlInsertOrderLine);
    }
    mysqli_close($conn);
}

?>
