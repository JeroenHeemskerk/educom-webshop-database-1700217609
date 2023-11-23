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
        echo    '<a class="shopItem" href="index.php?page=details&itemId=' . $row['id'] . '"><div class="' .$shopItemClass . '">' . 
                $row['id'] . '<br>' .
                '<img src="Images/' . $row['filename'] . '" width="100" height="100" alt="Afbeelding"> 
                <h3>' . $row['name'] . '</h3>
                € ' . $commaPrice . 
                '<br><br>'; 
        require_once('session_manager.php'); 
        if (!empty(isUserLoggedIn())) {
            echo '  <form>
                        <input type="hidden" name="' . $row['id'] . '" id="itemId"
                        <button class="cart"><img src="Images/winkelwagen.png" width="25" height="25" alt ="Voeg toe aan winkelwagen"></button><br>';
        }
        echo    '</div></a>';
                $counter++;
    }
}



?>
  