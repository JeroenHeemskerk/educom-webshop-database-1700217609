<?php

function showDetailsHeader ()
{
    echo '<h1>Product details</h1>';
}

function getItemId ($_GET['itemId'])
{
    $itemId = $_GET['itemId'];
    return $itemId;
}

function showItemDetails ($itemId)
{
    require_once('file_repository.php');
    $itemDetails = getItemDetails($itemId);
    for ($itemDetails as $row) {
        $commaPrice = number_format($row['price'], 2, ',', '.');
        echo    '<div class="itemDetails">' . 
                $row['filename'] . '" width="200" height="200" alt="Afbeelding"></a>'  . 
                '<h3>' . $row['name'] . '</h3>' .
                " € " . $commaPrice . '<br>' .
                $row['descripion'] .
                '<br>
                </form>
                </div>';
                $counter++;
    }

}

?>