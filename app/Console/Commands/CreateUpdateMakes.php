<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use CarTwoDb\Apis\BasebuyAutoApi;
use CarTwoDb\Apis\connectors\CurlGetConnector;

class CreateUpdateMakes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:createmakes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command create/updates makes tabel car_make';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $downloadFolder = $_SERVER['DOCUMENT_ROOT'] . '/';
        $lastDateUpdate = strtotime('01.01.2019 00:00:00'); // Date of the last API call to check first, and only then download files
        $idType         = 1; // Passenger cars (a complete list can be obtained through $basebuyAutoApi->typeGetAll())

        $basebuyAutoApi = new BasebuyAutoApi(
            new CurlGetConnector(\Config::get('app.api_key_cartwodb'), \Config::get('app.api_url_cartwodb'), $downloadFolder)
        );

        try {
            if ($basebuyAutoApi->markGetDateUpdate($idType) > $lastDateUpdate) {
                $downloadedFilePath = $basebuyAutoApi->markGetAll($idType);
            }

            // Disable foreign key checks!
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $fp = fopen($downloadedFilePath, 'r');
            if ($fp) {
                $ignoreFirst = true;
                while (!feof($fp)) {
                    if (!$ignoreFirst) {
                        $fileRow = fgets($fp, 999);
                        $fields = explode(",", $fileRow);
                        if (!empty($fields) && !empty($fields[0]) && str_replace("'", "", $fields[1]) != 'name') {
                            DB::table('car_make')
                                ->updateOrInsert(
                                    [
                                        'id_car_make' => str_replace("'", "", $fields[0]),
                                        'name' => str_replace("'", "", $fields[1])
                                    ],
                                    [
                                        'date_create' => str_replace("'", "", $fields[2]),
                                        'date_update' => str_replace("'", "", $fields[3]),
                                        'id_car_type' => str_replace("'", "", $fields[4])
                                    ]
                                );
                        }
                    }
                    $ignoreFirst = false;
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
    }

    private function getNumericValue($str)
    {
        $re = '/\d+\.?\d*/m';
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
        // Print the entire match result
        $result = call_user_func_array('array_merge', $matches);
        print_r($result);
    }
}
