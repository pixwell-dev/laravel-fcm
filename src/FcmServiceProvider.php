<?php

namespace NotificationChannels\FcmChannel;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase;
use Kreait\Firebase\ServiceAccount;

class FcmServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(FcmChannel::class)->needs(Firebase\Messaging::class)->give(function () {
            $fcmConfig = config('broadcasting.connections.fcm.json_file_path');
            $serviceAccount = ServiceAccount::fromJsonFile($fcmConfig);

            return (new Firebase\Factory())->withServiceAccount($serviceAccount)->create()->getMessaging();
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
