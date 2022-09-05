<?php

namespace NotificationChannels\GoogleChat;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;

class GoogleChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        $this->app->when(GoogleChatChannel::class)
            ->needs(GuzzleClient::class)
            ->give(function () {
                return new GuzzleClient();
            });

        $this->publishes([
            realpath(__DIR__.'/../config/google-chat.php') => config_path('google-chat.php'),
        ], 'google-chat-config');

        $this->publishes([
            __DIR__.'/../database/migrations/2022_03_01_000000_create_spaces_table.php' => database_path('migrations/2022_03_01_000000_create_spaces_table.php')
        ], 'google-chat-migrations');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/google-chat.php'), 'google-chat');
    }
}
