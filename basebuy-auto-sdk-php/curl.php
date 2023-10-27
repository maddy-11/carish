<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api.car2db.com/api/auto/v1/model.getAll.csv.en?id_type=1&api_key=info@carish.eecbb78eb66cac4770bc284b962ccec006"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close ($ch);

// Will dump a beauty json :3
var_dump($server_output, true);

// Further processing ...
if ($server_output == "OK") {
    echo 'ok';
} else { echo 'error';
}