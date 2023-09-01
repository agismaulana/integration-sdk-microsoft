<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class PushNotificationJob implements ShouldQueue, RespondsToWebhook
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        dd($this);

        return response()->json([
            'data' => $this,
            'error' => false,
        ]);
    }
}
