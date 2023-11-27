<?php

function showPasswordHeader()
{ 
    echo '<h1>Instellingen</h1>';
}

function showPasswordContent ($data)
{ 
    echo    '<div class="center">
                <h2>Wachtwoord wijzigen<h2> 
            </div>';
    showPasswordForm ($data);
    return $data;
}

function showPasswordForm ($data)
{
    echo '<form action="index.php" method="POST">
            <div class="invoervelden">
                <label for="password">Oude wachtwoord:</label>
                    <input class="sw" type="password" id="password" name="password" placeholder="Typ hier uw oude wachtwoord" value="' . $data['password']; echo '">
                    <span class="error">' . $data['passwordErr'] . '</span><br>
                <label for="newpassword">Nieuwe wachtwoord:</label>
                    <input class="sw" type="password" id="newpassword" name="newpassword" placeholder="Typ hier uw nieuwe wachtwoord" value="' . $data['password']; echo '">
                    <span class="error">' . $data['newpasswordErr'] . '</span><br>    
                <label for="passwordrep">Herhaal nieuw wachtwoord</label>
                    <input class="sw" type="password" id="passwordrep" name="passwordrep" placeholder="Herhaal uw nieuwe wachtwoord" value="' . $data['passwordrep'] . '"> 
                    <span class="error">' . $data['passwordrepErr'] . '</span><br>
                <br>
                </div>
                <input class="knop" type="submit" Value="Wijzig wachtwoord">
                <input type="hidden" name="page" value="password"><br>
            </div> 
            </div>
        </form>';   
}
?>