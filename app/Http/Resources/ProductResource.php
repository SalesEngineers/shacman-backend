<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="ProductResource")
 *
 * Class ProductResource
 * @package App\Http\Resources
 */
class ProductResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Url", description="По сути это slug")
     * @OA\Property(type="string", property="content", title="Контент")
     * @OA\Property(type="string", property="video", title="Видео", description="Ссылка на видео")
     * @OA\Property(
     *     type="array",
     *     property="image",
     *     title="Изображения",
     *     @OA\Items(ref="#/components/schemas/ImageResource")
     * )
     * @OA\Property(
     *     type="array",
     *     property="categories",
     *     title="Категории",
     *     @OA\Items(ref="#/components/schemas/CategoryResource")
     * )
     * @OA\Property(
     *     type="array",
     *     property="equipments",
     *     title="Навесное оборудование",
     *     description="Это поле отображается только для спецтехники",
     *     @OA\Items(ref="#/components/schemas/ProductResource"),
     *     example="[]"
     * )
     * @OA\Property(type="object", property="seo", title="SEO", ref="#/components/schemas/SeoResource")
     * @OA\Property(type="object", property="dimension", title="Габариты", ref="#/components/schemas/DimensionResource")
     * @OA\Property(type="array", property="characteristics", title="Характеристики", @OA\Items(ref="#/components/schemas/CharacteristicProductResource"))
     * @OA\Property(type="array", property="advantages", title="Преимущества", @OA\Items(ref="#/components/schemas/AdvantageResource"))
     * @OA\Property(type="array", property="labels", title="Лейблы", @OA\Items(ref="#/components/schemas/LabelResource"))
     * @OA\Property(type="array", property="attachments", title="Файлы", @OA\Items(ref="#/components/schemas/AttachmentResource"))
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'content' => $this->content,
            'script' => $this->script,
            'video' => $this->video,
            'images' => ImageResource::collection($this->images),
            'categories' => CategoryResource::collection($this->categories),
            'equipments' => $this->when(in_array($this->type, [Product::TYPE_SPECIAL_MACHINERY]), ProductResource::collection($this->equipments)),
            'seo' => new SeoResource($this->seo),
            'dimension' => new DimensionResource($this->dimension),
            'characteristics' => CharacteristicProductResource::collection($this->characteristics),
            'advantages' => AdvantageResource::collection($this->advantages),
            'labels' => LabelResource::collection($this->labels),
            'attachments' => AttachmentResource::collection($this->attachments),
            'is_out_of_production' => $this->is_out_of_production
        ];
    }
}
