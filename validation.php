<?php

// CONTACT
function validateContact()
{
    // declareVariables
    $data = array("salut"=>"", "name"=>"", "com"=>"", "email"=>"", "phone"=>"", "street"=>"", "strnr"=>"", "zpcd"=>"", "resid"=>"", "message"=>"", "salutErr"=>"", "nameErr"=>"", "comErr"=>"", "emailErr"=>"", "phoneErr"=>"", "streetErr"=>"", "strnrErr"=>"", "zpcdErr"=>"", "residErr"=>"", "messageErr"=>"", "valid" => false); 
    
    //varifyRequest
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $data['salut'] = (getPostVar('salut'));            
        $data['name'] = (getPostVar('name'));
        if (!preg_match("/^[a-zA-Z-' ]*$/",$data['name'])) {
            $data['nameErr'] = "U kunt hier alleen letters invullen";}        
        $data['com'] = (getPostVar('com'));
        $data['email'] = (getPostVar('email'));
        $data['phone'] = (getPostVar('phone'));
        $data['street'] = (getPostVar('street'));
        $data['strnr'] = (getPostVar('strnr'));
        $data['zpcd'] = (getPostVar('zpcd'));
        $data['resid'] = (getPostVar('resid'));
        $data['message'] = (getPostVar('message'));
        $data = test_contact_input ($data);
        $data = validateContactData($data);
        
    }
    return $data;   
}

function test_contact_input($data) {
    $results = array();
    foreach($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $results[$key] = $value;
    }
    return $results;
}

function validateContactData($data)
{
    if (empty($data["salut"])) {                       
        $data['salutErr'] = "Aanhef is verplicht";
    } 
    if (empty($data['name'])) {
        $data['nameErr'] = "Naam is verplicht";
    } 
    if (empty($data['message'])) {
        $data['messageErr'] = "Vraag is verplicht";
    } 
    if (empty($data['com'])) {
        $data['comErr'] = "Communicatievoorkeur is verplicht"; 
    } 
    if ($data['com'] =="E-mail") {
        if (empty($data['email'])) {
            $data['emailErr'] = "E-mailadres is verplicht";
        }
        else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailErr'] = "Dit e-mailadres lijkt niet te kloppen";}
        }        
    }    
    if ($data['com'] =="Phone") {                                     
        if (empty($data['phone'])) {
            $data['phoneErr'] = "Telefoonnummer is verplicht";
        }
        else {
            if (!preg_match('/^[0-9 -+]+$/', $data['phone'])) { 
                $data['phoneErr'] = "Dit lijkt geen goed telefoonnummer";} 
            }        
    }       
    
    $adressIncomplete = false;
    $adressIncomplete = !empty($data['street']) || !empty($data['strnr']) || !empty($data['zpcd']) || !empty($data['resid']);                             
    if (empty($data['street'])) { 
        if ($data['com'] =='Mail') {                 
            $data['streetErr'] = "Staatnaam is verplicht"; 
        }
        else if ($adressIncomplete) {
            $data['streetErr'] = "Uw adresgegevens zijn onvolledig";
        }
    }
    if (empty($data['strnr'])) {
        if ($data['com'] =='Mail') {
            $data['strnrErr'] = "Huisnummer is verplicht";
        }
        else if ($adressIncomplete) {
            $data['strnrErr'] = "Uw adresgegevens zijn onvolledig";
        }
    }
    if (empty($data['zpcd'])) {
        if ($data['com'] =='Mail') {
            $data['zpcdErr'] = "Postcode is verplicht";
        }
        else if ($adressIncomplete) {
            $data['zpcdErr'] = "Uw adresgegevens zijn onvolledig";
        }
    } 
    if (empty($data['resid'])) {
        if ($data['com'] =='Mail') {
            $data['residErr'] = "Woonplaats is verplicht";
        }
        else if ($adressIncomplete) {
            $data['residErr'] = "Uw adresgegevens zijn onvolledig";
        }
    }
    if (empty($data['saludErr']) && empty($data['nameErr']) && empty($data['comErr']) && empty($data['emailErr']) && empty($data['phoneErr']) && empty($data['streetErr']) && empty($data['strnrErr']) && empty($data['zpcdErr']) && empty($data['residErr']) && empty($data['messageErr']))
    {
        $data['valid'] = true;
    }
    return $data;
}  

//REGISTER
function validateRegister()
{
    // declareVariables
    $data = array("name"=>"","email"=>"", "password"=>"", "passwordrep"=>"", "nameErr"=>"","emailErr"=>"", "passwordErr"=>"", "passwordrepErr"=>"", "valid" => false); 
    
    //varifyRequest
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {         
        $data['name'] = (getPostVar('name'));
        if (!preg_match("/^[a-zA-Z-' ]*$/",$data['name'])) {
        $data['nameErr'] = "U kunt hier alleen letters invullen";}        
        $data['email'] = (getPostVar('email'));
        $data['password'] = (getPostVar('password'));
        $data['passwordrep'] = (getPostVar('passwordrep'));
        $data = test_register_input ($data);
        $data = validateRegisterData($data);
    }
    return $data;
}

function test_register_input($data) {
    $results = array();
    foreach($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $results[$key] = $value;
    }
    return $results;
}

function validateRegisterData($data)
{
    if (empty($data['name'])) {
        $data['nameErr'] = "Naam is verplicht";
    } 
    if (empty($data['email'])) {
        $data['emailErr'] = "E-mailadres is verplicht";
    } else { 
            //require_once ('user_service.php');                        Dit werkt niet, maar ik kan de vinger er niet op leggen. 
            //checkUserExist($data);  
            $email_input = $data["email"];                              //Zo werkt het wel
            $file = fopen('users.txt', 'r');
            while(!feof($file)){
                $line = fgets($file);
                list($email, $name, $password) = explode ('|', $line);
                if (trim($email) == $email_input) {
                    $data['emailErr'] = 'Dit e-mailadres is al in gebruik'; 
                    break;
                 }
            }
            fclose($file);                                  
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailErr'] = "Dit e-mailadres lijkt niet te kloppen";}
        }               
    if (empty($data['password'])) {
        $data['passwordErr'] = "Wachtwoord is verplicht";
    }
    if (empty($data['passwordrep'])) {
        $data['passwordrepErr'] = "Wachtwoord herhalen is verplicht";
    }
    if (($data['password']) != ($data['passwordrep'])) {
                $data['passwordrepErr'] = $data['passwordErr']= "Wachtwoorden komen niet overeen";
    }
    if (empty($data['nameErr']) && empty($data['emailErr']) && empty($data['passwordErr']) && empty($data['passwordrepErr']))
    {
        $data['valid'] = true;
    }
    return $data;
}    

//LOGIN
function validateLogin()
{
    // declareVariables
    $data = array("email"=>"", "password"=>"", "nameErr"=>"","emailErr"=>"", "passwordErr"=>"", "valid" => false); 
    
    //varifyRequest
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {           
        $data['email'] = (getPostVar('email'));
        $data['password'] = (getPostVar('password'));
        $data = test_login_input ($data);
        $data = validateLoginData($data);    
    }
    return $data;
}

function test_login_input($data) {
    $results = array();
    foreach($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        $results[$key] = $value;
    }
    return $results;
}

function validateLoginData($data)
{
    if (empty($data['email'])) {
        $data['emailErr'] = "E-mailadres is verplicht";
    }
        else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailErr'] = "Dit e-mailadres lijkt niet te kloppen";
            }
        }               
    if (empty($data['password'])) {
        $data['passwordErr'] = "Wachtwoord is verplicht";
    }                                                       
    else {
        //require_once ('user_service.php');
        //checkUserLogin($data);                                                       //dit lijkt niet te gebeuren, ik doe iets fout met 
        $email_input = $data["email"];                                                 // Dit werkt wel. 
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
    return $data;
    }
}
?>