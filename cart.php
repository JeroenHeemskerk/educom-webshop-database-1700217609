<?phph

function showCartHeader ()
{
    echo '<h1>Winkelwagen</h1>';
}

function showCartContent ()
{
    if(isset($_SESSION["cart"])) 
    {
        $item = '$_SESSION["cart"][$row['id']]';
        require_once('file_repository.php');
        $item = showShopItems($item);
        $counter = 0;
        foreach ($item as $row) {
            $commaPrice = number_format($row['price'], 2, ',', '.');
            $shopItemClass = ($counter % 2 == 0) ? 'evenItem' : 'oddItem';
            echo    '<a class="shopItemCart" href="index.php?page=details&id=' . $row['id'] . '">
                    <div class="' .$shopItemClass . '">
                    <div><h3>' . $row['name'] . '</h3></div>
                    <div><img src="Images/' . $row['filename'] . '" width="100" height="100" alt="Afbeelding"></div> 
                    <div>€ ' . $commaPrice . '</div>
                    <br><br>
                    </div></a>';
                $counter++;
        }
    }
    else {
        echo    '<div>
                    <p>
                        Uw winkelwagen is leeg
                    </p>
                </div>';
    }
}

?>