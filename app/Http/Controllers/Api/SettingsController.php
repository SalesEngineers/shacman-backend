<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResource;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Settings"},
     *     path="/api/settings",
     *     summary="Настройки сайта",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(type="object", property="data", ref="#/components/schemas/SettingsResource")
     *          )
     *     )
     * )
     *
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return SettingsResource
     */
    public function __invoke(Request $request)
    {
        $settings = Settings::first();
        return new SettingsResource($settings);
    }
}
