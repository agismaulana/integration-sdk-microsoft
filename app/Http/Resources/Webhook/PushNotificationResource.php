<?php

namespace App\Http\Resources\Webhook;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationResource implements RespondsToWebhook
{
    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        return response()->json([
            'data' => [
                'header' => $request->header(),
                'body' => $request->input(),
            ],
            'error' => false,
        ]);
    }
}