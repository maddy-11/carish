<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Cars\Version;

class ReplaceSeries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:series';

    /**
     * The console command description.
     *
     * @var string
     * If label have same generation labels with same body model transmission and same generation
     * generation will be replaced again by series names .
     */
    protected $description = 'Run it Last,It will remove duplicate generation labels.';

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
        ini_set('memory_limit', '2G');
        $getVersions         = Version::get();
        foreach ($getVersions as $version) {
            if (!empty($version->extra_details)) {
                $transmission_id = $version->transmissiontype;
                $body_type_id    = $version->body_type_id;
                DB::enableQueryLog();
                $count        = Version::select("id", "model_id", "id_car_serie")
                    ->where('label', $version->label)
                    ->where('extra_details', $version->extra_details)
                    ->where('id_car_generation', $version->id_car_generation)
                    ->where('model_id', $version->model_id)
                    ->where('transmissiontype', $transmission_id)
                    ->where('body_type_id', $body_type_id)->count();
                if ($count > 1) {
                    $versions        = Version::select("id", "model_id", "id_car_serie")
                        ->where('label', $version->label)
                        ->where('extra_details', $version->extra_details)
                        ->where('id_car_generation', $version->id_car_generation)
                        ->where('model_id', $version->model_id)
                        ->where('transmissiontype', $transmission_id)
                        ->where('body_type_id', $body_type_id)->get();
                    $query = DB::getQueryLog();
                    $query = end($query);
                    $this->updateDetails($versions);
                }
            }
        }
    }

    private function updateDetails($versions)
    {
        ini_set('memory_limit', '2G');
        if (!empty($versions)) {
            foreach ($versions as $version) {
                $updateVersion = Version::find($version->id);
                $extra_details = DB::table('car_serie')->select("name")
                    ->where('id_car_model', $version->model_id)
                    ->where('id_car_serie', $version->id_car_serie)->first(); 
                $updateVersion->extra_details  = $extra_details->name;
                $updateVersion->save();
            }
        } // END EMPTY CONDITION.

    }
}
