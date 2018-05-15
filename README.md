# Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coreproc/laravel-notification-channel-fcm.svg?style=flat-square)](https://packagist.org/packages/coreproc/laravel-notification-channel-fcm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/91098630/shield)](https://styleci.io/repos/91098630)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/621d780f-fdb7-479d-8fb2-683cbbc3ee4c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/621d780f-fdb7-479d-8fb2-683cbbc3ee4c)
[![Quality Score](https://img.shields.io/scrutinizer/g/CoreProc/fcm.svg?style=flat-square)](https://scrutinizer-ci.com/g/CoreProc/fcm)
[![Total Downloads](https://img.shields.io/packagist/dt/coreproc/laravel-notification-channel-fcm.svg?style=flat-square)](https://packagist.org/packages/coreproc/laravel-notification-channel-fcm)

This package makes it easy to send notifications using [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM) via new [FCM HTTP v1 API](https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages) with Laravel 5.3, 5.4, and 5.5.

## Contents

- [Installation](#installation)
	- [Setting up the Fcm service](#setting-up-the-Fcm-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

    composer require pixwell-dev/laravel-notification-channel-fcm
    
Register the ServiceProvider in your config/app.php (Skip this step if you are using Laravel 5.5):

    NotificationChannels\Fcm\FcmServiceProvider::class,

### Setting up the FCM service

You need to register for a server key from Firebase for your application. Start by creating a project here: 
[https://console.firebase.google.com](https://console.firebase.google.com)

Once you've registered and set up your project, add the [firebase auth json file](https://firebase.google.com/docs/cloud-messaging/auth-server) key to your configuration in `config/broadcasting.php`

    'connections' => [
        ....
        'fcm' => [
            'json_file_path' => env('FIREBASE_CREDENTIALS'),
        ],
        ...
    ]

## Usage

You can now send notifications via FCM by creating an `FcmNotification` and an `FcmMessages`:

```php
class AccountActivated extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        // The FcmNotification holds the notification parameters
        $fcmNotification = FcmNotification::create()
            ->withTitle('Your account has been activated')
            ->withBody('Thank you for activating your account.');
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setNotification($fcmNotification)
            ->setData([])
            ->setApns($apnsConfig)
            ->setAndroid($androidConfig)
            ->setWebpush($webpushConfig);
    }
}
```

### Available Message methods

The `Message` object always contains attributes (`AndroidConfig` | `ApnsConfig` | `WebPushConfig`) for  differ between different operating systems (Android, iOS, and Chrome). In this perspective, a `Message` object is available for each 
platform which extends the `FcmMessage` object.

All the methods below are explained and defined in the Firebase Cloud Messaging documentation found here: 
[https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages](https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages)
This package wrap [Firebase SDK](https://github.com/kreait/firebase-php) for PHP package to laravel
[https://firebase-php.readthedocs.io/en/latest/cloud-messaging.html](https://firebase-php.readthedocs.io/en/latest/cloud-messaging.html). You can use all available functions.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email balunjozef@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Jozef Balun](https://github.com/jozefbalun)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
