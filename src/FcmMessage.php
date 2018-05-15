<?php

namespace NotificationChannels\FcmChannel;

use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;

class FcmMessage
{

    /**
     * @var Notification
     */
    private $notification;

    /**
     * @var AndroidConfig
     */
    private $android;

    /**
     * @var ApnsConfig
     */
    private $apns;

    /**
     * @var WebPushConfig
     */
    private $webpush;


    private $data;


    public static function create()
    {
        return new self;
    }

    /**
     * @param Notification $notification
     *
     * @return FcmMessage
     */
    public function setNotification(Notification $notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @param AndroidConfig $android
     *
     * @return FcmMessage
     */
    public function setAndroid(AndroidConfig $android)
    {
        $this->android = $android;

        return $this;
    }

    /**
     * @param ApnsConfig $apns
     *
     * @return FcmMessage
     */
    public function setApns(ApnsConfig $apns)
    {
        $this->apns = $apns;

        return $this;
    }

    /**
     * @param WebPushConfig $webpush
     *
     * @return FcmMessage
     */
    public function setWebpush(WebPushConfig $webpush)
    {
        $this->webpush = $webpush;

        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'data' => (array)$this->data,
            'notification' => $this->notification ? $this->notification->jsonSerialize() : null,
            'android' => $this->android ? $this->android->jsonSerialize() : null,
            'apns' => $this->apns ? $this->apns->jsonSerialize() : null,
            'webpush' => $this->webpush ? $this->webpush->jsonSerialize() : null,
        ]);
    }
}
