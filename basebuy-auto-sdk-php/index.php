<?php
require(__DIR__ . '/vendor/autoload.php');

use \basebuy\basebuyAutoApi\BasebuyAutoApi;
use \basebuy\basebuyAutoApi\connectors\CurlGetConnector;
use \basebuy\basebuyAutoApi\exceptions\EmptyResponseException;

define("API_KEY", "info@carish.eecbb78eb66cac4770bc284b962ccec006");

define("API_URL", "https://api.car2db.com/api/auto/v1/");
$downloadFolder = $_SERVER['DOCUMENT_ROOT'].'/';

$lastDateUpdate = strtotime('01.01.2019 00:00:00'); // Date of the last API call to check first, and only then download files
$idType = 1; // Passenger cars (a complete list can be obtained through $basebuyAutoApi->typeGetAll())

$basebuyAutoApi = new BasebuyAutoApi(
    new CurlGetConnector(API_KEY, API_URL, $downloadFolder)
);

try {

   /*  if ($basebuyAutoApi->typeGetDateUpdate() > $lastDateUpdate) {
        $downloadedFilePath = $basebuyAutoApi->typeGetAll(); 
    } */
    
        if ( $basebuyAutoApi->markGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->markGetAll( $idType );
        }
/*
        if ( $basebuyAutoApi->modelGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->modelGetAll( $idType );
        }

        if ( $basebuyAutoApi->generationGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->generationGetAll( $idType );
        }

        if ( $basebuyAutoApi->serieGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->serieGetAll( $idType );
        }

        if ( $basebuyAutoApi->modificationGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->modificationGetAll( $idType );
        }

        if ( $basebuyAutoApi->characteristicGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->characteristicGetAll( $idType );
        }

        if ( $basebuyAutoApi->characteristicValueGetDateUpdate( $idType ) > $lastDateUpdate){
            $downloadedFilePath = $basebuyAutoApi->characteristicValueGetAll( $idType );
        }
        */

    $fp = fopen($downloadedFilePath, 'r');
    if ($fp) {
        while (!feof($fp)) {
            $fileRow = fgets($fp, 999);
            echo $fileRow . "<br />";
        }
    } else {
        echo "Error opening file";
    }
    fclose($fp); 
} catch (Exception $e) { 
    switch ($e->getCode()) {
        case 401:
            echo '<pre>' . $e->getMessage() . "\nAn invalid API key was specified, or your key has expired. Contact support atsupport@basebuy.ru</pre>";
            break;

        case 404:
            echo '<pre>' . $e->getMessage() . "\nIt is impossible to build a result based on the specified query parameters. Check for the id_type parameter, which is required for all entities, except for the type itself.</pre>";
            break;

        case 500:
            echo '<pre>' . $e->getMessage() . "\nTemporary service interruptions.</pre>";
            break;

        case 501:
            echo '<pre>' . $e->getMessage() . "\nA non-existent action was requested for the specified entity.</pre>";
            break;

        case 503:
            echo '<pre>' . $e->getMessage() . "\nTemporary suspension of the service due to database update.</pre>";
            break;

        default:
            echo '<pre> The last message.' . $e->getMessage() . "</pre>";
    }
}
