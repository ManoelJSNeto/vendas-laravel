<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('mail_settings')) {
            $mailSetting = MailSetting::first();

            if ($mailSetting && $mailSetting->mail_host) {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', $mailSetting->mail_host);
                Config::set('mail.mailers.smtp.port', $mailSetting->mail_port);
                Config::set('mail.mailers.smtp.username', $mailSetting->mail_username);
                Config::set('mail.mailers.smtp.password', $mailSetting->mail_password);
                Config::set('mail.mailers.smtp.encryption', $mailSetting->mail_encryption);
                Config::set('mail.from.address', $mailSetting->mail_from_address);
                Config::set('mail.from.name', $mailSetting->mail_from_name);
            }
        }
    }
}