<?php

namespace App\Console\Commands;

use Illuminate\Console\Command; 
use Mail;
use App\Mail\NotifyMail;

use App\Mail\CronJobTest;
use App\City;
class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMail:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check on daily basis when will feature property end of an Ad';

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
          Mail::to('mutahiricup@gmail.com')->send(new NotifyMail());
        if (Mail::failures()) {
            echo 'Sorry! Please try again latter';
            print  'Sorry! Please try again latter';
        } else {
            echo 'Great! Successfully send in your mail';
             print 'Great! Successfully send in your mail';
        }
         
        $data = ['poster_name' => 'Ahsan Elahi','now_date' => $date,'message' => $message];
        Mail::to('mr.elahi.ehsan@gmail.com')->send(new CronJobTest($data));

        $data = array('name'=>'shah','code'=>'sh','status'=>1);

$img = City::create($data);
        print "I am called\n".$img;
        return Command::SUCCESS;
     }
}