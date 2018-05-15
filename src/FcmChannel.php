<?php

namespace NotificationChannels\FcmChannel;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\MessageToRegistrationToken;
use NotificationChannels\FcmChannel\Exceptions\CouldNotSendNotification;

class FcmChannel
{
    /**
     * @var Messaging
     */
    private $messaging;

    /**
     * FcmChannel constructor.
     *
     * @param Messaging $messaging
     */
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the token/s from the model
        if (!$notifiable->routeNotificationFor('fcm')) {
            return;
        }
        $tokens = (array)$notifiable->routeNotificationFor('fcm');
        if (empty($tokens)) {
            return;
        }

        // Get the message from the notification class
        /**
         * @var FcmMessage $message
         */
        $message = $notification->toFcm($notifiable);
        if (!$message) {
            return;
        }

        $message = $message->toArray();
        $message['token'] = $tokens[0];
        $message = MessageToRegistrationToken::fromArray($message);

        try {
            $this->messaging->send($message);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception->getMessage());
        }
    }
}
