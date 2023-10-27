<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Versions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makemodels:versions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run First of All,First time populate versions table.';

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
        DB::statement('INSERT IGNORE INTO versions(id,label,transmission_label,extra_details,id_car_serie,id_car_generation,model_id,from_date,to_date)
SELECT id_car_trim,t.name,t.name as transmission_label,s.name,s.id_car_serie,g.id_car_generation,t.id_car_model,g.year_begin,g.year_end
FROM car_generation AS g INNER JOIN car_serie s ON s.id_car_generation=g.id_car_generation
INNER JOIN car_trim t ON t.id_car_serie=s.id_car_serie');
    }



    /* INSERT INTO versions(id,label,extra_details,serie,generation,model_id,from_date,to_date)
SELECT id_car_trim,t.name,s.name,s.id_car_serie,g.id_car_generation,t.id_car_model,g.year_begin,g.year_end
FROM car_generation AS g INNER JOIN car_serie s ON s.id_car_generation=g.id_car_generation
INNER JOIN car_trim t ON t.id_car_serie=s.id_car_serie */
}
