<?php

namespace NotificationChannels\GoogleChat;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Notifications\Notification;
use NotificationChannels\GoogleChat\Exceptions\CouldNotSendNotification;

class GoogleChatChannel
{
    /**
     * The Http Client.
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Initialise a new Google Chat Channel instance.
     *
     * @param \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\GoogleChat\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toGoogleChat')) {
            throw CouldNotSendNotification::undefinedMethod($notification);
        }

        /** @var \NotificationChannels\GoogleChat\GoogleChatMessage $message */
        if (! ($message = $notification->toGoogleChat($notification)) instanceof GoogleChatMessage) {
            throw CouldNotSendNotification::invalidMessage($message);
        }

        $space =  $notifiable->routeNotificationFor('googleChat');


//        if (! $endpoint = config("google-chat.spaces.$space", $space)) {
//            throw CouldNotSendNotification::webhookUnavailable();
//        }

        try {

            $request = new Request(
                'POST',
                'https://chat.googleapis.com/v1/'.$space->name.'/messages',
                ['content-type' => 'application/json'],
                json_encode($message->toArray())
            );


            $client = new \Google\Client();
            $client->setAuthConfig(base_path('so-cm-opanalytics-dev-a1956d9336c9.json'));
            $client->setApplicationName("FLTOPSENG_CHATBOT");
            $client->setScopes(['https://www.googleapis.com/auth/chat.bot']);

            $response = $client->execute($request);

        } catch (ClientException $exception) {
            return dd($exception);
        }catch (\Google\Exception $exception) {
            dd($exception->getTrace());
        }catch (Exception $exception) {
            dd($exception);
        }

        return $this;
    }
}
