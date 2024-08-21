<?php

namespace App\Services\Api;

use App\Util\Api\InternalApiUtil;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Crypt;

/**
 * Energy Contract Api Service
 *
 */
class EcomApiServices
{
    private InternalApiUtil $util;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->util = new InternalApiUtil(config('app.apiUrl.energyContract'), config('internalApi.ecomApi.endpoint.token'));
    }
    public function test(){
        $this->util->post('test',[]);
    }
}
