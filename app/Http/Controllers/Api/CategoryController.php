<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/categories",
     *     summary="Получить список категорий",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data", @OA\Items(ref="#/components/schemas/CategoryResource")),
     *              @OA\Property(type="object", property="meta", example={"current_page": 1, "from": 1, "last_page": 10, "per_page": 8, "to": 8, "total": 40})
     *          )
     *     ),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     *
     * Список категорий
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $categories = Category::onlyParents()->with(['children'])->orderBy('sort', 'asc')->get();

        return CategoryResource::collection($categories);
    }

    /**
     * @OA\Get(
     *     tags={"Categories"},
     *     path="/api/categories/{category}",
     *     summary="Получить информацию о категории",
     *     @OA\Parameter(
     *         description="Идентификатор категории",
     *         in="path",
     *         name="category",
     *         required=true,
     *         @OA\Schema(type="integer", example="1"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data", ref="#/components/schemas/CategoryResource")
     *          )
     *     ),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     *
     * Категория
     *
     * @param $category
     *
     * @return CategoryResource
     */
    public function show($category)
    {
        $category = Category::query()->where('id', $category)->orWhere('url', $category)->firstOrFail();
        return new CategoryResource($category);
    }
}
