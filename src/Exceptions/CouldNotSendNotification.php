<?php

namespace NotificationChannels\FcmChannel\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($message = 'Notification canot be send !')
    {
        return new static($message);
    }
}
