<?php

function showRegisterHeader()
{ 
    echo '<h1>Aanmelden</h1>' . PHP_EOL;
}

function showRegisterForm ($data)
{ 
    echo '<form action="index.php" method="POST"> 
            <div class="invoervelden">
                <label for="fname">Naam:</label>
                    <input class="sw" type="text" id="fname" name="name" placeholder="Typ hier uw naam" value="' . $data['name'] . '">
                    <span class="error">' . $data['nameErr'] . '</span><br>                
                <label for="email">E-mailadres:</label>
                    <input class="sw" type="text" id="email" name="email" placeholder="Typ hier uw e-mailadres" value="' . $data['email'] . '" > 
                    <span class="error">' . $data['emailErr'] . '</span><br>
                <label for="password">Wachtwoord:</label>
                    <input class="sw" type="password" id="password" name="password" placeholder="Typ hier uw wachtwoord" value="' . $data['password']; echo '">
                    <span class="error">' . $data['passwordErr'] . '</span><br>
                <label for="passwordrep">Herhaal wachtwoord</label>
                    <input class="sw" type="password" id="passwordrep" name="passwordrep" placeholder="Herhaal uw wachtwoord" value="' . $data['passwordrep'] . '"> 
                    <span class="error">' . $data['passwordrepErr'] . '</span><br>
                <br>   
            </div>
                <input class="knop" type="submit" Value="Meld aan">
                <input type="hidden" name="page" value="register">
            </div>    
        </form>';
    return $data;
} 

?>
