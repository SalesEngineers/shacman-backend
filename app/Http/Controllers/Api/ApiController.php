<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *      @OA\Info(version="1.0", title="REST API"),
 *      @OA\Server(url="https://api.xcmg-rf.marketolog.sale"),
 *      @OA\Server(url="http://api.xcmg.marketolog.sale")
 * )
 */
abstract class ApiController extends Controller {}
