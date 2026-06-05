<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            // Код для ссылки
            'code' => $this->code,
            // Короткая ссылка
            'short_url' => url('/' . $this->code),
        ];
    }
}
