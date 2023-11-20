<?php

function checkUserExist($data)                                                  //Dit werkt niet. 
{
    $email_input = $data["email"];
    $file = fopen('users.txt', 'r');
    while(!feof($file)){
        $line = fgets($file);
        list($email, $name, $password) = explode ('|', $line);
        if (trim($email) == $email_input) {
            $data['emailErr'] = 'Dit e-mailadres is al in gebruik'; 
            }
    }
    fclose($file);
    return $data;
}

function storeUser($data)
{
    
    
    return $data
}

function checkUserLogin($data)                                                  //Dit werkt niet. In het oefenbestand werkt het wel. 
{
    $email_input = $data["email"];
    $password_input = $data["password"];
            $file = fopen('users.txt', 'r');
            $found = false;
            while(!feof($file)){
                $line = fgets($file);
                list($email, $name, $password) = explode ('|', $line);
                if (trim($email) == $email_input) {
                    $found = true;
                    if (trim($password) == $password_input) {
                        $data['valid'] = true;
                        $data['name'] = $name;
                    }
                    else {
                        $data['passwordErr'] = 'Uw wachtwoord klopt niet'; 
                    }
                    break;
                }
            }
            if (!$found) {
                $data['emailErr'] = 'Uw e-mailadres wordt niet herkend';
            }
            return $data;
}
?>
