<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Cars\Version;

class ReplaceGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:updategenerations';

    /**
     * The console command description.
     *
     * @var string
     * It will update those version which has same series names label model body type and transmission type but different generations
     * It replaces lable of series with generations
     */
    protected $description = 'Run It 4th Update Versions tables for duplicate labels and values';

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
                $count           = Version::select("id", "model_id", "id_car_generation")
                    ->where('label', $version->label)
                    ->where('extra_details', $version->extra_details)
                    ->where('model_id', $version->model_id)
                    ->where('transmissiontype', $transmission_id)
                    ->where('body_type_id', $body_type_id)->count();

                if ($count > 1) {
                    $versions        = Version::select("id", "model_id", "id_car_generation")
                        ->where('label', $version->label)
                        ->where('extra_details', $version->extra_details)
                        ->where('model_id', $version->model_id)
                        ->where('transmissiontype', $transmission_id)
                        ->where('body_type_id', $body_type_id)->get();
                    $this->updateDetails($versions);
                }
            }
        }
    }

    private function updateDetails($versions)
    {
        if (!empty($versions)) {
            foreach ($versions as $version) {
                $extra_details  = DB::table('car_generation')->select("name")->where('id_car_model', $version->model_id)
                ->where('id_car_generation', $version->id_car_generation)->first();
                if(!empty($extra_details)){
                    $updateVersion  = Version::find($version->id);
                    $updateVersion->extra_details  = $extra_details->name;
                    $updateVersion->save();
                }
            }
        } // END EMPTY CONDITION.

    }
}


/* INSERT INTO versions(id,label,extra_details,id_car_serie,id_car_generation,model_id,from_date,to_date)
SELECT id_car_trim,t.name,s.name,s.id_car_serie,g.id_car_generation,t.id_car_model,g.year_begin,g.year_end
FROM car_generation AS g INNER JOIN car_serie s ON s.id_car_generation=g.id_car_generation
INNER JOIN car_trim t ON t.id_car_serie=s.id_car_serie */
