<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class WebhookSignatureValidator extends DefaultSignatureValidator {

    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return true;
    }
}
