<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\checkAdFeature::class,
         Commands\DeleteInvoices::class,
         Commands\GenerateSitemap::class,
         Commands\SendMail::class,
    ];

    /**
     * Define the application's command schedule.
     *  
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    { 
        $schedule->command('checkAdFeature:daily')->dailyAt('00:01');
        $schedule->command('delete:invoices')->dailyAt('00:01');
        $schedule->command('sitemap:generate')->dailyAt('00:01');     
        //$schedule->command('SendMail:daily')->dailyAt('10:00');    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}