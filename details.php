<?php

function showDetailsHeader ()
{
    echo '<h1>Product details</h1>';
}

function showItemDetails ($data)
{
    require_once('file_repository.php');
    $itemDetails = $data['item'];
    $commaPrice = number_format($itemDetails['price'], 2, ',', '.');
        echo    '<div class="itemDetails">' . 
                '<img src="Images/' . $itemDetails['filename'] . '" width="300" height="300" alt="Afbeelding">'  . 
                '<h2>' . $itemDetails['name'] . '</h2>' .
                " € " . $commaPrice . '<br><br>' .
                $itemDetails['description'] .
                '<br><br>';
        require_once('session_manager.php');
        if (!empty(isUserLoggedIn())) {
            echo '  <form action="index.php" method="post">
                        <input type="hidden" name="page" value="details">
                        <input type="hidden" name="id" value="' . $itemDetails['id'] . '">
                        <input type="hidden" name="action" value="storeItemInSession">
                        <input class="cartButton "type="submit" value="Voeg toe aan winkelwagentje">
                        <br>
                    </form>';
        }
        echo    '</div>';
}

?>