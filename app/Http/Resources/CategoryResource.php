<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(title="CategoryResource")
 *
 * Class CategoryResource
 * @package App\Http\Resources
 */
class CategoryResource extends JsonResource
{
    /**
     * @OA\Property(type="integer", format="int64", property="id", title="Идентификатор")
     * @OA\Property(type="string", property="name", title="Название")
     * @OA\Property(type="string", property="url", title="Url", description="По сути это slug")
     * @OA\Property(type="string", property="content", title="Контент")
     * @OA\Property(type="boolean", property="is_tag", title="Тег", description="Является ли тегом", default="false")
     * @OA\Property(type="boolean", property="is_active", title="Активная", description="Отобразить или скрыть категорию")
     * @OA\Property(type="object", property="promotion", title="Акция", ref="#/components/schemas/PromotionResource")
     * @OA\Property(type="array", property="children", @OA\Items(
     *      @OA\Property(type="integer", format="int64", property="id", example="1"),
     *      @OA\Property(type="string", property="name"),
     *      @OA\Property(type="string", property="content"),
     *      @OA\Property(type="boolean", property="is_tag", default="false"),
     *      @OA\Property(type="boolean", property="is_active"),
     *      @OA\Property(type="object", property="promotion", ref="#/components/schemas/PromotionResource"),
     *      @OA\Property(type="array", property="children", @OA\Items(), example="[]"),
     *      @OA\Property(type="object", property="image", ref="#/components/schemas/ImageResource"),
     *      @OA\Property(type="array", property="filters", title="Фильтр", @OA\Items(ref="#/components/schemas/FilterResource")),
     *      @OA\Property(type="array", property="characteristics", title="Характеристики", @OA\Items(type="integer"), example="[1,2]"),
     *      @OA\Property(type="object", property="seo", ref="#/components/schemas/SeoResource")
     * ))
     * @OA\Property(type="object", property="image", title="Изображение", ref="#/components/schemas/ImageResource")
     * @OA\Property(type="array", property="filters", title="Фильтр", @OA\Items(ref="#/components/schemas/FilterResource"))
     * @OA\Property(
     *     type="array",
     *     property="product_main_characteristic_ids",
     *     title="Идентификаторы характеристик",
     *     description="Характеристики, которые будут отображаться в карточке товара",
     *     @OA\Items(type="integer"), example="[1,2]"
     * )
     * @OA\Property(type="object", property="seo", title="SEO", ref="#/components/schemas/SeoResource")
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'url'       => $this->url,
            'content'   => $this->content,
            'is_tag'    => $this->is_tag,
            'is_active' => $this->is_active,
            'promotion' => new PromotionResource($this->promotion),
            'children'  => CategoryResource::collection($this->children),
            'image'     => $this->when($this->image && $this->image->url, new ImageResource($this->image), null),
            'filters'   => FilterResource::collection($this->filters),
            'product_main_characteristic_ids' => $this->mainCharacteristicIds->pluck('id'),
            'seo'       => new SeoResource($this->seo),
            'video'     => $this->video,
            'gallery'   => $this->when(count($this->gallery), [
                'name'   => $this->gallery_name,
                'tabs' => GalleryResourceCollection::collection($this->gallery)
            ], null)
        ];
    }
}
