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

function storeUser($data['email'], $data['name'], $data['password'])
{
    $dbInfo = startDatabase();
    $conn = $dbInfo['conn'];
    $email = $data['email']; 
    $name = $data['name']; 
    $password = $data['password'];
    $sql = "INSERT INTO users (name, email, password)
    VALUES ($name, $email, $password);"

    if (mysqli_query($conn, $sql)) {
        echo "Nieuw record succesvol aangemaakt";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    return $data;
    mysqli_close($conn);
}

function checkUserLogin($data) {
    $dbInfo = startDatabase();
    $conn = $dbInfo['conn'];
    $email = $data['email'];
    $password = $data['password'];
    $sql = "SELECT name FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_fetch_array($result);
    if(isset($check)){
        echo 'test';
        $data['valid'] = true;
    }   else {
            echo 'test deel 2';
            $data['emailErr'] = $data['passwordErr'] = 'Onjuiste combinatie';
        }
    return $data;
    mysqli_close($conn);    
}



?>
