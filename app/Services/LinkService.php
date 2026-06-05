<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LinkService
{
    public function shorten(string $url): Link
    {
        $existing = Link::query()->where('url', $url)->first();
        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($url) {
            $maxAttempts = 10;
            $attempt = 0;

            while ($attempt < $maxAttempts) {
                $code = Str::random(6);

                if (!Link::query()->where('code', $code)->exists()) {
                    return Link::query()
                        ->create([
                            'url' => $url,
                            'code' => $code,
                        ]);
                }

                $attempt++;
            }

            throw new \RuntimeException('Не удалось сгенерировать уникальный код ссылки за отведенное количество попыток.');
        });
    }
}
