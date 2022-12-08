<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleResourceCollection;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Articles"},
     *     path="/api/articles",
     *     summary="Получить список статей",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data", @OA\Items(ref="#/components/schemas/ArticleResourceCollection"))
     *          )
     *     ),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     *
     * @param Request $request
     *
     * @return ArticleResourceCollection
     */
    public function index(Request $request)
    {
        $per_page = (int)$request->get('per_page', config('app.pagination_per_page'));
        $articles = Article::paginate($per_page);
        return new ArticleResourceCollection($articles);
    }

    /**
     * @OA\Get(
     *     tags={"Articles"},
     *     path="/api/articles/{article}",
     *     summary="Получить информацию о статье",
     *     @OA\Parameter(
     *         description="Идентификатор статьи",
     *         in="path",
     *         name="article",
     *         required=true,
     *         @OA\Schema(type="integer", example="1"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data", ref="#/components/schemas/ArticleResource")
     *          )
     *     ),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     *
     * @param $article
     *
     * @return ArticleResource
     */
    public function show($article)
    {
        $article = Article::query()->where('id', $article)->orWhere('url', $article)->firstOrFail();
        return new ArticleResource($article);
    }
}
