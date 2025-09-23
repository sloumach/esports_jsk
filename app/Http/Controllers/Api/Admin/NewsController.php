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
        try {
            return response()->json(NewsResource::collection($this->newsService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch news'], 500);
        }
    }

    public function store(NewsRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
            }

            $news = $this->newsService->create($data);
            return response()->json(new NewsResource($news), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create news'], 500);
        }
    }

    public function show(News $news): JsonResponse
    {
        try {
            return response()->json(new NewsResource($news->load('author')));
        } catch (Throwable $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }

    public function update(NewsRequest $request, News $news): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('cover_image')) {
                $data['cover_image'] = $request->file('cover_image')->store('news', 'public');
            }

            $updated = $this->newsService->update($news, $data);
            return response()->json(new NewsResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update news'], 500);
        }
    }

    public function destroy(News $news): JsonResponse
    {
        try {
            $this->newsService->delete($news);
            return response()->json(['message' => 'News deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete news'], 500);
        }
    }
}
