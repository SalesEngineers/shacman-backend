<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Contacts"},
     *     path="/api/contacts",
     *     summary="Получить список контактов",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="array", property="data", @OA\Items(ref="#/components/schemas/ContactResource"))
     *          )
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        return ContactResource::collection(Contact::orderBy('sort', 'asc')->get());
    }
}
