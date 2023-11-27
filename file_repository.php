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
    $email = mysqli_real_escape_string($conn, $email);
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
    $email = mysqli_real_escape_string($conn, $email);
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
    $oldPassword = $data['password'];
    $newPassword = $data['newpassword'];
    $escapedPassword = mysqli_real_escape_string($conn, $newPassword);
    $checkOldPasswordQuery = "SELECT id FROM users WHERE id = '$userId' AND password = '$oldPassword'";
    $result = mysqli_query($conn, $checkOldPasswordQuery);
    if (mysqli_num_rows($result) == 1) {
        $updatePasswordQuery = "UPDATE users SET password = '$escapedNewPassword' WHERE id = '$userId'";
        if (mysqli_query($conn, $updatePasswordQuery)) {
            echo "Wachtwoord succesvol aangepast";
        } else {
            echo "Error: " . $updatePasswordQuery . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Uw oude wachtwoord komt niet overeen. Aanpassen mislukt. Probeer opnieuw.";
    }

    mysqli_close($conn);

    return $data;
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
    $dbInfo = startDatabase();
    //declareVariables
    $userId = $_SESSION['userId']; 
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

//Top 5
function getTop5()
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
    $sql =  "SELECT item_id, SUM(quantity) AS total_quantity
            FROM order_line
            GROUP BY item_id
            ORDER BY total_quantity DESC
            LIMIT 5";
    $result = mysqli_query($conn, $sql);
    $top5 = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $itemId = $row['item_id']; 
        $itemInfo = getItemDetails($itemId);
        $top5[] = $itemInfo;
    }
    mysqli_close($conn);
    return $top5;
}

?>
