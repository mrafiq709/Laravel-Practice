<?php

namespace App\Devices;

use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PushNotification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'push_notifications';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'message', 'platform'];

    public function send() {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($this->getOriginal('title'));
        $notificationBuilder->setBody($this->message)
                            ->setSound('default');

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = null;

        $tokens = Device::pluck('push_token')->unique()->toArray();;

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $success = $downstreamResponse->numberSuccess();
        $failure = $downstreamResponse->numberFailure();
        $modification = $downstreamResponse->numberModification();

        $this->fill([
            'sender_id' => 1,
            'response' => array(
                'success' => $success,
                'failure' => $failure,
                'modification' => $modification
                )
        ]);
        $this->save();
    }
}
