<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Services\Managerservice\NewsService;
use Illuminate\Http\JsonResponse;
use Throwable;

class NewsController extends Controller
{
    public function __construct(
        private NewsService $newsService
    ) {}

    public function index(): JsonResponse
    {

            return response()->json(NewsResource::collection($this->newsService->list()));

    }

    public function store(NewsRequest $request): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
            }

            $news = $this->newsService->create($data);
            return response()->json(new NewsResource($news), 201);

    }

    public function show(News $news): JsonResponse
    {

            return response()->json(new NewsResource($news->load('author')));

    }

    public function update(NewsRequest $request, News $news): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
            }

            $updated = $this->newsService->update($news, $data);
            return response()->json(new NewsResource($updated));

    }

    public function destroy(News $news): JsonResponse
    {

            $this->newsService->delete($news);
            return response()->json(['message' => 'News deleted successfully']);

    }
}
