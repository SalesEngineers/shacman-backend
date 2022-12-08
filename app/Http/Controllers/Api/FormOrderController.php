<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormOrderRequest;
use App\Http\Resources\FormOrderResource;
use App\Services\FormOrderService;

class FormOrderController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"Order"},
     *     path="/api/form-order",
     *     summary="Отправить заявку",
     *     @OA\Parameter(
     *         description="Поля формы",
     *         in="query",
     *         name="fields",
     *         style="deepObject",
     *         explode=true,
     *         allowReserved=true,
     *         required=true,
     *         @OA\Schema(type="object", example={"email":"mail@mail.ru","phone":"76589631245"})
     *     ),
     *     @OA\Parameter(
     *         description="Поля сопоставления",
     *         in="query",
     *         name="labels",
     *         style="deepObject",
     *         explode=true,
     *         allowReserved=true,
     *         @OA\Schema(type="object", example={"email":"E-mail","phone":"Телефон"})
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      description="Вложение",
     *                      property="attachment",
     *                      type="string",
     *                      format="binary",
     *                  ),
     *                  @OA\Property(
     *                      description="Тема письма",
     *                      property="subject",
     *                      type="string",
     *                      format="string",
     *                  ),
     *                  @OA\Property(
     *                      description="Страница",
     *                      description="Страница, с которой была отправлена форма, по умолчанию заполняется автоматически",
     *                      property="page",
     *                      type="string",
     *                      format="string",
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data", ref="#/components/schemas/FormOrderResource")
     *          )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Сообщения об ошибках",
     *          @OA\JsonContent(
     *              @OA\Property(type="string", property="message", example="The given data was invalid."),
     *              @OA\Property(type="object", property="errors", example={"subject":{"Поле «Тема письма» должно быть строкой."}}),
     *          )
     *     ),
     * )
     *
     * Handle the incoming request.
     *
     * @param FormOrderRequest $request
     * @param FormOrderService $service
     *
     * @return FormOrderResource
     */
    public function __invoke(FormOrderRequest $request, FormOrderService $service)
    {
        $formOrder = $service->save($request);
        return new FormOrderResource($formOrder);
    }
}
