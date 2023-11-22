<?php

function showShopHeader ()
{
    echo '<h1>Spellenwinkel</h1>';
}

function showShopContent ()
{
    $item = '';
    require_once ('file_repository.php');
    $item = showShopItems ($item);
    foreach ($item as $row) {
        echo $row['id'] . '<img src="Images/' . $row['filename'] . '" alt="Afbeelding">'  . $row['name'] . "€ " . $row['price'] . "<br>";
    }

}
?>