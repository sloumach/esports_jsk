<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Services\ManagerService\PageService;
use Illuminate\Http\JsonResponse;
use Throwable;

class PageController extends Controller
{
    public function __construct(
        private PageService $pageService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(PageResource::collection($this->pageService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch pages'], 500);
        }
    }

    public function store(PageRequest $request): JsonResponse
    {
        try {
            $page = $this->pageService->create($request->validated());
            return response()->json(new PageResource($page), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create page'], 500);
        }
    }

    public function show(Page $page): JsonResponse
    {
        try {
            return response()->json(new PageResource($page));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    }

    public function update(PageRequest $request, Page $page): JsonResponse
    {
        try {
            $updated = $this->pageService->update($page, $request->validated());
            return response()->json(new PageResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update page'], 500);
        }
    }

    public function destroy(Page $page): JsonResponse
    {
        try {
            $this->pageService->delete($page);
            return response()->json(['message' => 'Page deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete page'], 500);
        }
    }
}
