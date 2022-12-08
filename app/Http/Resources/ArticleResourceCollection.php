<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(title="ArticleResourceCollection")
 *
 * Class ArticleResourceCollection
 * @package App\Http\Resources
 */
class ArticleResourceCollection extends ResourceCollection
{
    public $collects = ArticleShortResource::class;
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Url", description="По сути это slug")
     * @OA\Property(type="object", property="image_vertical", title="Изображение вертикальное", ref="#/components/schemas/ImageResource")
     * @OA\Property(type="object", property="image_horizontal", title="Изображение горизонтальное", ref="#/components/schemas/ImageResource")
     * @OA\Property(type="boolean", property="is_main", title="Отображать на главной странице", default="false")
     * @OA\Property(type="string", property="published_at", title="Дата публикации", description="Y.m.d H:i:s", example="2022-08-04 04:08:15")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     *
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
