<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Cars\Version;


class RemoveSeries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:removeseries';

    /**
     * The console command description.
     *
     * @var string
     * Remove those series labels which are not duplicate means it removes labels name which are
     * repeated one time not many times.
     */
    protected $description = 'Run it Third, it will remove single series names from extra details.';

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
                $updateVersion  = Version::find($version->id);
                $updateVersion->extra_details = $this->updateDetails($version);
                $updateVersion->save();
            }
        }
    }


    private function updateDetails($version)
    {
        ini_set('memory_limit', '2G');
        $extraDetails = $version->extra_details;
        $versions   = Version::where('label', $version->label)
        ->where('model_id', $version->model_id)
            ->where('transmissiontype', $version->transmissiontype)
            ->where('body_type_id', $version->body_type_id)->count();
        if ($versions == 1) {
            $extraDetails = '';
        }
        return $extraDetails;
    }
}
