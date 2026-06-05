<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Resources\LinkResource;
use App\Http\Resources\LinkStatsResource;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;

class LinkController extends Controller
{
    /**
     * Создание короткой ссылки.
     *
     * Эндпоинт принимает оригинальный длинный URL, проверяет его формат
     * и генерирует уникальный шестизначный код. Если этот URL уже сокращался
     * ранее, система вернет существующий код вместо создания дубликата.
     *
     */
    public function store(StoreLinkRequest $request, LinkService $linkService): LinkResource
    {
        $link = $linkService->shorten($request->validated('url'));

        return new LinkResource($link);
    }

    public function redirect(string $code): RedirectResponse
    {
        $link = Link::query()->where('code', $code)->firstOrFail();

        $link->increment('clicks');

        return redirect()->away($link->url, 302);
    }

    /**
     * Получение статистики по короткому коду.
     *
     * Возвращает информацию о сокращенной ссылке: оригинальный URL,
     * общее количество переходов (кликов) и дату создания ссылки.
     *
     * @param string $code Уникальный 6-значный короткий код ссылки (например, XyZ123).
     */
    public function stats(string $code): LinkStatsResource
    {
        $link = Link::query()->where('code', $code)->firstOrFail();

        return new LinkStatsResource($link);
    }
}
