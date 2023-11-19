<?php

function showThanksHeader()
{ 
    echo '<h1>Bedankt</h1>' . PHP_EOL;
}

function showThanksContent ($data) 
{ 
    echo '<p> Uw reactie is verzonden. Bedankt voor het invullen!</p>';
    echo '<p> U heeft het volgende ingevuld:' . '<br><br>';
    echo 'Aanhef: ' . $data['salut'] . '<br>';
    echo 'Naam: ' . $data['name'] . '<br>';
    echo 'E-mailadres: ' . $data['email'] . '<br>';
    echo 'Telefoonnummer: ' . $data['phone'] . '<br>';
    echo 'Straatnaam: ' . $data['street'] . '<br>';
    echo 'Huisnummer: ' . $data['strnr'] . '<br>';
    echo 'Postcode: ' . $data['zpcd'] . '<br>';
    echo 'Woonplaats: ' . $data['resid'] . '<br>';
    echo 'Communicatievoorkeur: ' . $data['com'] . '<br>';
    echo 'Vraag: ' . $data['message'] . '<br></p>';
    return $data;
}

?>