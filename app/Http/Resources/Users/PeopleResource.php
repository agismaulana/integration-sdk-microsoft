<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeopleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'displayName' => $this['displayName'],
            'givenName' => $this['givenName'],
            'surname' => $this['surname'],
            'phones' => $this['phones'] ?? null,
            'mobilePhone' => $this['mobilePhone'] ?? null,
            'businessPhone' => $this['businessPhone'] ?? null,
            'userPrincipalName' => $this['userPrincipalName'],
            'mail' => $this['mail'] ?? null,
            'personType' => $this['personType'] ?? []
        ];
    }
}
