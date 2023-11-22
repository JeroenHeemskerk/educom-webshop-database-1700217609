<?php

function showShopHeader ()
{
    echo '<h1>Spellenwinkel</h1>';
}

function showShopContent()
{
    $item = '';
    require_once('file_repository.php');
    $item = showShopItems($item);
    $counter = 0;
    foreach ($item as $row) {
        $commaPrice = number_format($row['price'], 2, ',', '.');
        $shopItemClass = ($counter % 2 == 0) ? 'evenItem' : 'oddItem';
        
        echo    '<form method="post" action="index.php">' .
                '<input type="hidden" name="page" value="details">' .
                '<input type="hidden" name="itemId" value="' . $row['id'] . '">' .
                '<div class="' .$shopItemClass . '">' . 
                $row['id'] . '<br>' .
                '<a class="shopItem" href="index.php?page=details"' . '><img src="Images/' . $row['filename'] . '" width="100" height="100" alt="Afbeelding"></a>'  . 
                '<h3>' . $row['name'] . '</h3>' .
                " € " . $commaPrice . 
                '<br>
                </form>
                </div>';
                $counter++;
    }
}

?>
  