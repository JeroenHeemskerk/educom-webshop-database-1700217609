<?php

function showContactHeader()
{ 
    echo '<h1>Contact</h1>' . PHP_EOL;
}

function showContactForm ($data)
{
    echo '<form action="index.php" method="POST">
            <div class="invoervelden">
                <label for="salut">Aanhef:</label>
                    <select class="sel" id="salut" name="salut">
                        <option value=""></option>  
                        <option value="man"' . ($data['salut'] == "man" ? 'selected="selected"' : ' ') . '>Dhr.</option>
                        <option value="woman"' . ($data['salut'] == "woman" ? 'selected="selected"' : ' ') . '>Mvr.</option>
                        <option value="different"' . ($data['salut'] == "different" ? 'selected="selected"' : ' ') . '>Anders</option>
                    </select>
                        <span class="error">' . $data['salutErr'] . '</span><br> 
                <label for="fname">Naam:</label>
                    <input class="sw" type="text" id="fname" name="name" placeholder="Typ hier uw naam" value="' . $data['name'] . '">
                    <span class="error">' . $data['nameErr'] . '</span><br>                
                <label for="email">E-mailadres:</label>
                    <input class="sw" type="text" id="email" name="email" placeholder="Typ hier uw e-mailadres" value="' . $data['email'] . '" > 
                    <span class="error">' . $data['emailErr'] . '</span><br>
                <label for="phone">Telefoonnummer:</label>
                    <input class="sw" type="text" id="phone" name="phone" placeholder="Typ hier uw telefoonnummer" value="' . $data['phone'] . '">
                    <span class="error">' . $data['phoneErr'] . '</span><br>
                <label for="street">Straatnaam</label>
                    <input class="sw" type="text" id="street" name="street" placeholder="Typ hier uw straat" value="' . $data['street'] . '"> 
                    <span class="error">' . $data['streetErr'] . '</span><br>
                <label for="strnr">Huisnummer</label>
                    <input class="sw" type="text" id="strnr" name="strnr" placeholder="Typ hier uw huisnummer" value="' . $data['strnr'] . '">
                    <span class="error">' . $data['strnrErr'] . '</span><br>
                <label for="zpcd">Postcode</label>
                    <input class="sw" type="text" id="zpcd" name="zpcd" placeholder="Typ hier uw postcode als 1234 AB" value="' . $data['zpcd'] . '">
                    <span class="error">' . $data['zpcdErr'] . '</span><br>
                <label for="resid">Woonplaats</label>
                    <input class="sw" type="text" id="resid" name="resid" placeholder="Typ hier uw woonplaats" value="' . $data['resid'] . '">
                    <span class="error">' . $data['residErr'] . '</span><br>
                <br>   
            </div>
            <div>
            Kies uw communicatievoorkeur:<span class="error">' . $data['comErr'] . '</span><br>
                <input type="radio" id="com_email" name="com" value="E-mail"' . ($data['com'] =="E-mail" ? 'checked = "checked"' : '') . '>
                    <label for="com_email">E-mail</label><br>
                <input type="radio" id="phone" name="com" value="Phone"' . ($data['com'] =="Phone" ? 'checked = "checked"' : ' ') . '>
                    <label for="phone">Telefoon</label><br>
                <input type="radio" id="mail" name="com" value="Mail"' . ($data['com'] =="Mail" ? 'checked = "checked"' : ' ') . '>
                    <label for="mail">Post</label><br>
                <br>
            </div>
            <div class="invoervelden">    
            Waarover wilt u contact opnemen?<br>
                <textarea class="sw" name="message" rows="4" cols="53" placeholder="Typ hier uw vraag">' . $data['message'] . '</textarea>
                <span class="error">' . $data['messageErr'] . '</span><br>
                <br>
                <input class="knop" type="submit" Value="Verstuur">
                <input type="hidden" name="page" value="contact">       
            </div>    
        </form>';
    return $data;
}

?>