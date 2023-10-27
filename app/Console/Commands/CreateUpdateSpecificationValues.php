<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use CarTwoDb\Apis\BasebuyAutoApi;
use CarTwoDb\Apis\connectors\CurlGetConnector;

class CreateUpdateSpecificationValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:createspecificationvalues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command create/updates specificationvalues tabel car_specification_value';

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
        $downloadFolder = $_SERVER['DOCUMENT_ROOT'] . '/develop.carish.ee/';
        $lastDateUpdate = strtotime('01.09.2021 00:00:00'); // Date of the last API call to check first, and only then download files
        $idType         = 1; // Passenger cars (a complete list can be obtained through $basebuyAutoApi->typeGetAll())

        $basebuyAutoApi = new BasebuyAutoApi(
            new CurlGetConnector(\Config::get('app.api_key_cartwodb'), \Config::get('app.api_url_cartwodb'), $downloadFolder)
        );

        try {
            if ($basebuyAutoApi->specificationValueGetDateUpdate($idType) > $lastDateUpdate) {
                $downloadedFilePath = $basebuyAutoApi->specificationValueGetAll($idType);
            } 
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
}
