<?php

namespace App\Console;

use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AccountManagerSchedule;
use App\Models\TravelManagement\TravelAgency;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     */
        protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (){
            $ta_id = TravelAgency::select('ta_id')->get();
            foreach ($ta_id as $tid) {
                $accountManager = AccountManagement::where('ta_id', $tid->ta_id)->latest()->first();
                if (!empty($accountManager)) {
                    $newAccountManager = $accountManager->replicate();
                    $newAccountManager->date = Carbon::parse($accountManager->date)->addMonth()->format('Y-m').'-1';
                    $newAccountManager->save();
                }
            }
            return 'Account Manager updated Successfully!!';
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
