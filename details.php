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
                '<img src="Images/' . $itemDetails['filename'] . '" width="200" height="200" alt="Afbeelding">'  . 
                '<h3>' . $itemDetails['name'] . '</h3>' .
                " € " . $commaPrice . '<br><br>' .
                $itemDetails['description'] .
                '<br><br>
                _
                </form>
                </div>';
    }

?>