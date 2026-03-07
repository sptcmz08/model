<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'mail:test {email?}';
    protected $description = 'Test email sending';

    public function handle()
    {
        $to = $this->argument('email') ?? config('mail.from.address');

        $this->info('=== Mail Configuration ===');
        $this->info('Mailer: ' . config('mail.default'));
        $this->info('Host: ' . config('mail.mailers.smtp.host'));
        $this->info('Port: ' . config('mail.mailers.smtp.port'));
        $this->info('Scheme: ' . (config('mail.mailers.smtp.scheme') ?: '(empty)'));
        $this->info('Username: ' . config('mail.mailers.smtp.username'));
        $this->info('Password: ' . (config('mail.mailers.smtp.password') ? '***SET***' : '(empty)'));
        $this->info('From: ' . config('mail.from.address'));
        $this->info('Sending to: ' . $to);
        $this->info('========================');

        try {
            Mail::raw('This is a test email from Film Custom Model Shop. If you received this, email is working!', function ($message) use ($to) {
                $message->to($to)
                    ->subject('Test Email - Film Custom Model');
            });

            $this->info('✅ Email sent successfully to ' . $to);
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->error('Full trace:');
            $this->error($e->getTraceAsString());
        }
    }
}
