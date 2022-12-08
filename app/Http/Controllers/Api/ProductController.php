<?php

namespace App\Http\Controllers\Api;

use App\Filters\ProductFilter;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/categories/{category}/products",
     *     summary="Получить список товаров из категории",
     *     @OA\Parameter(
     *         description="Идентификатор категории",
     *         in="path",
     *         name="category",
     *         required=true,
     *         @OA\Schema(type="integer", example="1"),
     *     ),
     *     @OA\Parameter(
     *         description="Сортировка товаров по полю: -id, id, -name, name и т.п.",
     *         in="query",
     *         name="sort_by",
     *         @OA\Schema(type="string", example="-id"),
     *     ),
     *     @OA\Parameter(
     *         description="Количество записей на страницу",
     *         in="query",
     *         name="per_page",
     *         @OA\Schema(type="integer", example="8"),
     *     ),
     *     @OA\Parameter(
     *         description="Номер страницы",
     *         in="query",
     *         name="page",
     *         @OA\Schema(type="integer", example="1"),
     *     ),
     *     @OA\Parameter(
     *         description="Фильтр по характеристикам",
     *         in="query",
     *         name="c",
     *         style="deepObject",
     *         explode=true,
     *         allowReserved=true,
     *         @OA\Schema(type="object", example={"1":"ISUZU","2":"20000"})
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data", @OA\Items(ref="#/components/schemas/ProductShortResource")),
     *              @OA\Property(type="object", property="meta", example={"current_page": 1, "from": 1, "last_page": 10, "per_page": 8, "to": 8, "total": 40})
     *          )
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $category
     * @param ProductFilter $filter
     *
     * @return ProductResourceCollection
     */
    public function index(Request $request, $category, ProductFilter $filter)
    {
        $category = Category::query()->where('id', $category)->orWhere('url', $category)->firstOrFail();
        $per_page = (int)$request->get('per_page', config('app.pagination_per_page'));
        $products = $category->products()
                             ->filter($filter)
                             ->paginate($per_page);

        return new ProductResourceCollection($products);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/api/products/{product}",
     *     summary="Получить товар",
     *     @OA\Parameter(
     *         description="Идентификатор товара",
     *         in="path",
     *         name="product",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data", ref="#/components/schemas/ProductResource")
     *          )
     *     )
     * )
     *
     * Display the specified resource.
     *
     * @param $product
     *
     * @return ProductResource
     */
    public function show($product)
    {
        $product = Product::query()
                          ->where(['id' => $product])
                          ->orWhere('url', $product)
                          ->firstOrFail();

        return new ProductResource($product);
    }
}
