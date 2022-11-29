<?php

namespace App\Console;

use App\classes\cron\BoomReasonNotificationsSender;
use App\classes\cron\BrandAuditEmailCampaign;
use App\classes\cron\CloseableMessageSender;
use App\classes\cron\EmailsSeqRunner;
use App\classes\cron\NoBoomReasonNotificationsSender;
use App\classes\cron\OpsSnapshotLoader;
use App\classes\cron\PqEmailsSeqRunner;
use App\classes\cron\Q1Q3NoBoomEmailCampaign;
use App\classes\cron\QueueCacheUpdater;
use App\classes\cron\RedFlagsEmailsSeqRunner;
use App\classes\cron\ReferAFriendEmailCampaign;
use App\classes\cron\RfTthEmailsSeqRunner;
use App\classes\cron\SendTmofferInvoiceScheduledEmails;
use App\classes\cron\SendTmofferInvoiceScheduledProblemEmails;
use App\classes\cron\ReminderEmailToClientsAboutBookedCall;
use App\classes\cron\TenThingsEmailsSeqRunner;
use App\classes\cron\TmfsalesAvailabilityLogger;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(new QueueCacheUpdater)->cron('*/3 * * * *');
        $schedule->call(new Q1Q3NoBoomEmailCampaign)->cron('2 9 15 12 2');
        $schedule->call(new ReferAFriendEmailCampaign)->cron('27 16 15 12 2');
        $schedule->call(new BrandAuditEmailCampaign)->cron('0 8 17 12 4');
        // $schedule->command('inspire')->hourly();
        $schedule->call(new SendTmofferInvoiceScheduledProblemEmails)->dailyAt('00:01');
        $schedule->call(new CloseableMessageSender)->dailyAt('09:00');
//        $schedule->call(new BoomReasonNotificationsSender)->everyMinute();
        $schedule->call(new RedFlagsEmailsSeqRunner)->everyMinute();
        $schedule->call(new TenThingsEmailsSeqRunner)->everyMinute();
        $schedule->call(new PqEmailsSeqRunner)->everyMinute();
        $schedule->call(new RfTthEmailsSeqRunner)->everyMinute();
        $schedule->call(new EmailsSeqRunner)->everyMinute();
        $schedule->call(new BoomReasonNotificationsSender)->dailyAt('13:00');
        $schedule->call(new NoBoomReasonNotificationsSender)->dailyAt('10:00');

//        $schedule->call(new SendTmofferInvoiceScheduledEmails)->everyMinute();
        $schedule->call(new ReminderEmailToClientsAboutBookedCall)->everyMinute();
        $schedule->call(new SendTmofferInvoiceScheduledEmails)->dailyAt('00:01');
        $schedule->call(new OpsSnapshotLoader)->dailyAt('23:55');
        $schedule->call(new TmfsalesAvailabilityLogger)->dailyAt('00:01');
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
