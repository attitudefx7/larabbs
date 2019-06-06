<?php

namespace App\Transformers;

use function GuzzleHttp\Psr7\normalize_header;
use League\Fractal\TransformerAbstract;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransformer extends TransformerAbstract
{
    public function transform(DatabaseNotification $notification)
    {
        return [
            'id' => $notification->id,
            'type' => $notification->type,
            'data' => $notification->data,
            'read_at' => $notification->read_at ? $notification->read_at->toDateTimeString() : null,
            'created_at' => $notification->create_at->toDateTimeString(),
            'updated_at' => $notification->updated_at->toDateTimeString(),
        ];
    }
}