<?php

namespace App\Console\Commands;

use App\Mail\SendEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\TransactionArchive\FolderDivision\FolderItemFile;

class SendDailyNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-daily-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily notifications at 09:00 AM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch files with notifications for today
        $folderFiles = FolderItemFile::whereNotNull('notification')
            ->whereDate('date_notification', today())
            ->get();

        // Loop through each file and send the email
        foreach ($folderFiles as $file) {
            $ccRecipients = array_filter(array_map('trim', explode(',', $file->email_cc)));

            // Create the email instance
            $email = Mail::to($file->email);

            // Add CC if any are specified
            if (! empty($ccRecipients)) {
                $email->cc($ccRecipients);
            }

            // Send the email
            $email->send(new SendEmail([
                'title' => $file->notification,
                'body' => $file->description,
                'file' => $file->attach_file ? $file->file : null,
            ]));
        }

        $this->info('Daily notifications sent successfully!');
    }
}
