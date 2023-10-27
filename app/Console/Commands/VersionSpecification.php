<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Cars\Version;

class VersionSpecification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 
     */
    protected $signature = 'makemodels:updatespecifications';

    /**
     * The console command description.
     *
     * @var string
     * It will update versions table for different specifications like body type transmissions , weight etc.
     */
    protected $description = 'Run second, it will update specifications in versions table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private function formatNumber($string, $engine_capacity)
    {
        preg_match_all('!\d+\.*\d*!', $string, $matches);
        foreach ($matches[0] as $match) {
            $number = $match;
            if (is_numeric($match)) {
                if (fmod($match, 1) == 0.00) {
                    $number = round($engine_capacity / 1000, 1);
                }
                return $number;
            }
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '2G');
        $getVersions         = DB::table('versions')->get();
        foreach ($getVersions as $versions) {
            $updateVersion  = Version::find($versions->id);
            $specifications = DB::table('car_specification_value')
                ->select("name", "value", "unit", "car_specification_value.id_car_specification")->where('id_car_trim', $versions->id)->join("car_specification", "car_specification.id_car_specification", "=", "car_specification_value.id_car_specification")->get();

            $label                             = explode('(', $updateVersion->label);
            //$engine_capacity                 = preg_replace("/[^0-9]/", "", $label[0]);
            $engine_capacity                   = $this->formatNumber($updateVersion->transmission_label, $updateVersion->cc);
            //$transmission_label                = preg_replace('/[0-9]+/', '', $label[0]);
            // $updateVersion->engine_power       = $updateVersion->kilowatt; //preg_replace("/[^0-9]/", "",  $label[1]);
            $updateVersion->engine_capacity    = $engine_capacity;
            //$updateVersion->transmission_label = $transmission_label;
            foreach ($specifications as $specs) {
                if ($specs->name == 'Gearbox type') {
                    $transmissionType = DB::table('transmission_description')->where('title', 'like', "%$specs->value%")->select('transmission_id')->first();
                    if (!empty($transmissionType)) {
                        $updateVersion->transmissiontype = $transmissionType->transmission_id;
                    }
                }
                if ($specs->name == 'Body type') {
                    $bodyType = DB::table('body_types_description')->select("body_type_id")->where('name', 'like', "%$specs->value%")->first();
                    if (!empty($bodyType)) {
                        $updateVersion->body_type_id = $bodyType->body_type_id;
                    }
                }
                if ($specs->name == 'Engine type') {

                    $fuelType = DB::table('engine_types_description')->select("engine_type_id")->where('title', 'like', "%$specs->value%")->first();
                    if (!empty($fuelType)) {
                        $updateVersion->fueltype = $fuelType->engine_type_id;
                    }
                }
                if ($specs->name == 'Capacity') {
                    $updateVersion->cc = $specs->value;
                }

                if ($specs->name == 'Width') {
                    $updateVersion->car_width = $specs->value . ' ' . $specs->unit;
                }

                if ($specs->name == 'Length') {
                    $updateVersion->car_length = $specs->value . ' ' . $specs->unit;
                }

                if ($specs->name == 'Height') {
                    $updateVersion->car_height = $specs->value . ' ' . $specs->unit;
                }

                if ($specs->name == 'Wheelbase') {
                    $updateVersion->wheel_base = $specs->value . ' ' . $specs->unit;
                }

                if ($specs->name == 'Engine power') {
                    $engine_power = round($specs->value / 1.341) - 1;
                    $updateVersion->kilowatt = $engine_power;
                    if (!empty($label[1])) {
                        $updateVersion->label              = $label[0] . $engine_power . " KW";
                    }
                    $updateVersion->engine_power       = $engine_power;
                }

                if ($specs->name == 'Curb weight') {
                    $updateVersion->curb_weight = $specs->value . ' ' . $specs->unit;
                }

                if ($specs->name == 'Fuel tank capacity') {
                    $updateVersion->fuel_tank_capacity = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Maximum torque') {

                    $updateVersion->torque = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Ground clearance') {
                    $updateVersion->ground_clearance = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Number of seater') {
                    $updateVersion->seating_capacity = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Fuel tank capacity') {
                    $updateVersion->fuel_tank_capacity = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Number of gear') {
                    $updateVersion->gears = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Max speed') {
                    $updateVersion->max_speed = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'acceleration (0-100 km/h)') {
                    $updateVersion->acceleration = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Number of cylinders') {
                    $updateVersion->number_of_cylinders = $specs->value;
                }
                if ($specs->name == 'Drive wheels') {
                    $updateVersion->drive_type = $specs->value . ' ' . $specs->unit;
                }
                if ($specs->name == 'Full weight') {
                    $updateVersion->weight = $specs->value . ' ' . $specs->unit;
                }
                $updateVersion->save();
            }
        }
        //return 0;
    }
}