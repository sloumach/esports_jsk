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

            return response()->json(PageResource::collection($this->pageService->list()));

    }

    public function store(PageRequest $request): JsonResponse
    {

            $page = $this->pageService->create($request->validated());
            return response()->json(new PageResource($page), 201);

    }

    public function show(Page $page): JsonResponse
    {

            return response()->json(new PageResource($page));

    }

    public function update(PageRequest $request, Page $page): JsonResponse
    {

            $updated = $this->pageService->update($page, $request->validated());
            return response()->json(new PageResource($updated));

    }

    public function destroy(Page $page): JsonResponse
    {

            $this->pageService->delete($page);
            return response()->json(['message' => 'Page deleted successfully']);

    }
}
