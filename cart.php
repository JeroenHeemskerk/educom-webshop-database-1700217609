<?php

function showCartHeader ()
{
    echo '<h1>Winkelwagen</h1>';
}

function showCartContent ()
{
    if(isset($_SESSION["cart"])) 
    {
        $cart = $_SESSION["cart"];
        require_once('file_repository.php');
        $items = getShopItems();
        $counter = 0;
        $total = 0;
        foreach ($cart as $itemId => $quantity) {
            $row = $items[$itemId];
            $commaPrice = number_format($row['price'], 2, ',', '.');
            $subtotal = $row['price'] * $quantity;
            $commaSubtotal = number_format($subtotal, 2, ',', '.');
            $shopItemClass = ($counter % 2 == 0) ? 'evenItem' : 'oddItem';
            echo    '<a class="shopItemCart" href="index.php?page=details&id=' . $row['id'] . '">
                    <div id="cartItems" class="' .$shopItemClass . '">
                    <table>
                    <td id="itemImg"><img src="Images/' . $row['filename'] . '" width="50" height="50" alt="Afbeelding"></td> 
                    <td id="itemName"><h3>' . $row['name'] . '</h3></td>
                    <td id="itemQuan">' . $quantity . ' stuk(s)</td>
                    <td id="price">€ ' . $commaPrice . ' per stuk</td>
                    <td id="subtotal"><em>subtotaal € ' . $commaSubtotal . '</em></td>
                    <br><br>
                    </table>
                    </div></a>';
                $total += $subtotal;
                $counter++;
        }
        $commaTotal = number_format($total, 2, ',', '.');
        echo    '<div class="total">
                    <p>
                        <h3>Totaal: € ' . $commaTotal . '</h3>
                    </p>                
                </div>';
    }
    else {
        echo    '<div>
                    <p>
                        <h3>Uw winkelwagen is leeg. Kijk snel in de spellenwinkel!</h3>
                    </p>
                </div>';
    }
}

?>