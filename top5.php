<?php

function showTop5Header ()
{
    echo '<h1>Top 5 spellen</h1>';
}

function showTop5List ($data)
{
    require_once('file_repository.php');
    $top5 = getTop5();
    $counter = 0;
    $topNumber = 1;
    foreach ($top5 as $row) {
        $topItemClass = ($counter % 2 == 0) ? 'evenItem' : 'oddItem';
        echo    '<a class="top5Item" href="index.php?page=details&id=' . $row['id'] . '"><div class="' .$topItemClass . '"> 
                <h2>' . $topNumber . '</h2>
                <img src="Images/' . $row['filename'] . '" width="100" height="100" alt="Afbeelding"> 
                <h3>' . $row['name'] . '</h3>
                <br><br> 
                </div></a>';
                $topNumber++;
                $counter++;
            }
}

?>