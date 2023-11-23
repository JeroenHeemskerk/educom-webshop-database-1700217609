<?php

function showDetailsHeader ()
{
    echo '<h1>Product details</h1>';
}

function getItemId ()
{
    $itemId = $_GET['itemId'];
    return $itemId;
}

function showItemDetails ($itemId)
{
    require_once('file_repository.php');
    $itemDetails = getItemDetails($itemId);
    $commaPrice = number_format($itemDetails['price'], 2, ',', '.');
        echo    '<div class="itemDetails">' . 
                '<img src="Images/' . $itemDetails['filename'] . '" width="300" height="300" alt="Afbeelding">'  . 
                '<h2>' . $itemDetails['name'] . '</h2>' .
                " € " . $commaPrice . '<br><br>' .
                $itemDetails['description'] .
                '<br><br>';
        require_once('session_manager.php');
        if (!empty(isUserLoggedIn())) {
            echo '<button onclick="addItemToCart ()" class="cart"><img src="Images/winkelwagen.png" width="25" height="25" alt ="Voeg toe aan winkelwagen"></button><br>';
        } 
        echo    '</div>';
    }

?>