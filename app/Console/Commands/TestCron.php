<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Ad;
use App\Models\GoogleAd;
use DB;
class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive quote to everyone daily via email.';

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
        $downloadedFilePath = $_SERVER['DOCUMENT_ROOT'] . '/develop.carish.ee/specificationValue.getAll.csv.en';
        $fp = fopen($downloadedFilePath, 'r');
        if ($fp) {
            $ignoreFirst = true;
			$i = 1;
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            while (!feof($fp)) {  
                    $fileRow = fgets($fp, 999); 
                    $fields = explode(",", $fileRow); 
				  if (!empty($fields) && !empty($fields[0]) && str_replace("'", "", $fields[3]) != 'value') {
                            if (str_replace("'", "", $fields[7]) == '1' || str_replace("'", "", $fields[7]) == 1) {  
									   DB::table('car_specification_values')
                                    ->insertOrIgnore(
                                        [
                                            'id_car_specification_value' => str_replace("'", "", $fields[0])
                                        ,
                                            'id_car_trim' => str_replace("'", "", $fields[1]),
                                            'id_car_specification' => str_replace("'", "", $fields[2]),
                                            'value' => str_replace("'", "", $fields[3]),
                                            'unit' => str_replace("'", "", $fields[4]),
                                            'date_create' => str_replace("'", "", $fields[5]),
                                            'date_update' => str_replace("'", "", $fields[6]),
                                            'id_car_type' => str_replace("'", "", $fields[7])
                                        ]
                                    );
								echo $i." =Field = ".$fields[0]."\n";
                            }
                        }
				$i++;
            }
        }
         /* 1490965
		 id=36681239
		 $del = GoogleAd::where('id',1)->delete(); 
78822 ID = '268907'
78534
        $to = "mutahiricup@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: carish@carish.ee" . "\r\n" .
"";

if(mail($to,$subject,$txt,$headers))
{
    echo 'email send successfuly';
}
else echo "error in sending email"; 
         $subject = "This is subject";
         
         $message = "<b>This is HTML message.</b>";
         $message .= "<h1>This is headline.</h1>";
         
         $header = "From:abc@somedomain.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
 */
     }

}
