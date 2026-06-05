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

    public function stats(string $code): LinkStatsResource
    {
        $link = Link::query()->where('code', $code)->firstOrFail();

        return new LinkStatsResource($link);
    }
}
