<?php

namespace App\Http\Resources\Webhook;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationResource implements RespondsToWebhook
{
    // public function respondToValidWebhook(Request $request, WebhookConfig $config)
    // {
    //     return response()->json($request->input('validationToken'));
    // }

    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        return response($request->input('validationToken'));
    }
}
