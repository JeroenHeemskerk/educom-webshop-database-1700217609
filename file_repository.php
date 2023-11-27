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
        throw new Exception("Verbinding mislukt met database mislukt: " . mysqli_connect_error());
    }
    return array('conn' => $conn, 'servername' => $servername, 'username' => $username, 'password' => $password, 'dbname' => $dbname);
}

function checkUserExist($data) {
   
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try {
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
 }
 finally {
    mysqli_close($conn);    
 }
}

function storeUser($email, $name, $password)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try {
    $raw_password = $password;
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT, ['cost' =>14]);
    $sql = "INSERT INTO users (name, email, password)
    VALUES ('$name', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "U bent succesvol aangemeld, u kunt nu inloggen.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
 } finally {
    mysqli_close($conn);
 }
}

function checkUserLogin($data) {
    $dbInfo = startDatabase();
    $conn = $dbInfo['conn'];
 try {
    //declareVariables
    $email = $data['email'];
    $email = mysqli_real_escape_string($conn, $email);
    $entered_password = $data['password'];
    $sql = "SELECT id, name, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        if(password_verify($entered_password, $row['password'])) {
            $data['valid'] = true;
            $data['id'] = $row['id'];
            $data['name'] = $row['name'];
        } else {
            $data['emailErr'] = $data['passwordErr'] = 'Onjuiste combinatie';
        }    
    } 
    return $data;
 } finally {
    mysqli_close($conn);    
 } 
}

function checkPassword($data)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try {
    $userId = $data['userId'];
    $entered_password = $data['password'];
    $sql = "SELECT password FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if ($result && $row = mysqli_fetch_array($result)) {
        if (password_verify($entered_password, $row['password'])) {
            $data['passwordErr'] ="";
        } else {
            $data['passwordErr'] = 'Uw oude wachtwoord is onjuist';
        }
        return $data;
    }
 }finally {
    mysqli_close($conn);
 }
}

function updatePassword($data)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try{
    $userId = $_SESSION['userId'];
    $oldPassword = $data['password'];
    $newPassword = $data['newpassword'];
    $escapedPassword = mysqli_real_escape_string($conn, $newPassword);
    $checkOldPasswordQuery = "SELECT id, password FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $checkOldPasswordQuery);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        if (password_verify($oldPassword, $row['password'])) {
            $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 14]);
            $updatePasswordQuery = "UPDATE users SET password = '$newHashedPassword' WHERE id= '$userId'";
            if(mysqli_query($conn, $updatePasswordQuery)) {
                $data['valid'] = true;
            } else {
                echo "Error: " . $updatePasswordQuery . "<br>" . mysqli_error($conn);
                $data['valid'] = false;
            }
        }
    }
    return $data;
 } finally {
    mysqli_close($conn);
 }
}

//Shop
function getShopItems ()
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try {
    $sql = "SELECT * FROM item";
    $results = mysqli_query($conn, $sql);
    $item = array();
    while ($row = mysqli_fetch_array($results)) {
        $item[$row['id']] = $row;
    }
    return $item;
 } finally {
     mysqli_close($conn);
 }
}

//Details
function getItemDetails ($itemId)
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try {
    $sql = "SELECT * FROM item WHERE id = '$itemId'";
    $results = mysqli_query($conn, $sql);
    $itemDetails = mysqli_fetch_array($results);
    return $itemDetails;
 } finally {
    mysqli_close($conn);
 }
}

//Order plaatsen
function insertOrderInDb($cart)
{
    $dbInfo = startDatabase();
    //declareVariables
    $userId = $_SESSION['userId']; 
    $conn = $dbInfo['conn'];
 try{
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
 } finally {
    mysqli_close($conn);
 }
}

//Top 5
function getTop5()
{
    $dbInfo = startDatabase();
    //declareVariables
    $conn = $dbInfo['conn'];
 try{
    $sql =  "SELECT item_id, SUM(quantity) 
            FROM order_line
            GROUP BY item_id
            ORDER BY SUM(quantity) DESC
            LIMIT 5";
    $result = mysqli_query($conn, $sql);
    $top5 = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $itemId = $row['item_id']; 
        $itemInfo = getItemDetails($itemId);
        $top5[] = $itemInfo;
    }
    return $top5;
 } finally {
    mysqli_close($conn);
 }
}

?>
