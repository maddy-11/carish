<?php

namespace App\Imports;

use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Cars\Make;
use App\Models\Cars\Carmodel;
use App\Models\Cars\Version;
use App\Models\Cars\BodyTypes;
use DB;
use App\BodyTypesDescription;

class makesImport implements ToCollection
{
    /**
    * @param model
    */
    public function __construct()
    {
    }

    public function collection(Collection $rows)
    {
        $fields    = array(); 
        $bodyTypes = array();

        foreach ($rows as $values) {
            $fields[$values[0]][$values[1]][] =   array(
                'label' => $values[2], 'details' => $values[3],
                'cc' => $values[4],
                'extra_details' => $values[5],
                'from' => $values[7], 'to' => $values[8],  
                'kilowatt' => $values[6]
            );
            if(!empty($values[3])){
             $bodyTypes['bodyTypes'][$values[3]] = $values[3];
            }

        } 
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach( $bodyTypes['bodyTypes'] as $keys => $bodydata)
        {
            if($bodydata != 'BodyType'){ 
                $bodyArray     = array('name'=>trim($bodydata),
                'name_slug'=> str_replace("","-",$bodydata));
                /*$create = BodyTypes::firstOrCreate($bodyArray); */
             $BodyTypes   = BodyTypesDescription::where('name', trim($bodydata))->first();
            if ($BodyTypes == null) { // insert BODYTYPES
                $bts = BodyTypes::firstOrCreate($bodyArray);
                $btd = BodyTypesDescription::firstOrCreate(['name'=>$bodydata,'body_type_id'=>$bts->id,'language_id'=>2]);

            }
        }
        } 
        unset($fields['Make']); 
        foreach ($fields as $keys => $row) {
            $makes   = Make::where('title', trim($keys))->first();
            if ($makes == null) { // insert MAKES
                $makes = Make::firstOrCreate(['title' => $keys]);
            }
            $make_id = $makes->id;

            foreach ($row as $model_keys => $models) {

                $models_data = Carmodel::where('name', trim($model_keys))->where('make_id', $make_id)->first();
                if ($models_data == null) { // insert MODELS
                    $models_data = Carmodel::firstOrCreate(['name' => trim($model_keys), 'make_id' => $make_id]);
                }
                $mode_id = $models_data->id;

                foreach ($models as $versions) {

                    if($versions['extra_details'] == trim("."))
                    {
                        $versions['extra_details'] = '';
                    }

                    if ($versions['to'] == "" || $versions['to'] == null) {
                        $versions['to'] = '.';
                    }

                    $version_data = Version::where('label', trim($versions['label']))
                    ->where('model_id', $mode_id)->where('from_date', $versions['from'])
                    ->where('to_date', $versions['to'])->where('cc', trim($versions['cc']))
                    ->where('kilowatt', trim($versions['kilowatt']))
                    ->where('extra_details', trim($versions['extra_details']))->first();
                    if ($version_data == null) { // insert MODELS
                        if(isset($versions['details']) && !empty($versions['details'])){
                            $BodyT   = BodyTypesDescription::where('name', $bodydata)->first();
                            $versions['details'] = $BodyT->id; 
                        }
                        else {
                            $versions['details'] = '';
                        }

                        if($versions['to'] == trim('.') || $versions['to'] == '' )
                        {
                            $versions['to'] = trim('.');
                        }

                        Version::firstOrCreate(['model_id' => $mode_id,
                            'label' => trim($versions['label']), 'extra_details'=> trim($versions['extra_details']), 'from_date' => $versions['from'], 'to_date' => $versions['to'],
                            'cc'=> trim($versions['cc']), 'body_type_id'=> trim($versions['details']), 
                            'kilowatt'=> trim($versions['kilowatt'])
                        ]);
                    }

                } // END OF Th


            } // END SECOND FOREACH


        } // END FIRST FOREACH
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
