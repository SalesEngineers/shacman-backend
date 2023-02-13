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
    public function index(Request $request)
    {
        return ContactResource::collection(Contact::orderBy('sort', 'asc')->get());
    }

    public function dynamic(ContactService $service)
    {
        $contact = $service->getDynamicContact();

        if ($contact) {
            return new ContactResource($contact);
        }

        return abort(404);
    }

    public function location(Request $request)
    {
        $ip = $request->get('ip');
        $location = [];

        if ($ip) {
            $geo = \App\SypexGeo\SypexGeoFacade::get($ip);

            if (isset($geo['city']['name_ru'])) {
                $location['city'] = $geo['city']['name_ru'];
            }
    
            if (isset($geo['region']['name_ru'])) {
                $location['region'] = $geo['region']['name_ru'];
            }
        }

        return view('location', ['location' => $location]);
    }
}
