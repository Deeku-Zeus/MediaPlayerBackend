<?php
declare(strict_types=1);

namespace App\Util\Api;

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

/**
 * set information and Access Api.
 * get Api result and return it.
 */
class InternalApiUtil
{
    /**
     * Cache key.
     *
     * @var string
     */
    private string $cacheKey;

    /**
     * Sync lock key
     *
     * @var string
     */
    protected string $syncLockKey;

    /**
     * Construct
     * @param string $baseUri
     * @param string $tokenEndpoint
     */
    public function __construct(
        private string $baseUri,
        private string $tokenEndpoint)
    {
        $splitUrl = explode('/', $this->baseUri);
        $domain = $splitUrl[2] ?? '';
        $this->cacheKey = 'INTERNAL_API_ACCESS_TOKEN_' . str_replace('-', '_', str_replace('.', '_', $domain));
        $this->syncLockKey = 'LOCK_' . $this->cacheKey;
    }

    /**
     * Call Internal API Get URI
     *
     * @param string $path (api path)
     *
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    public function get(string $path): mixed
    {
        $requestPath = $this->baseUri . "/" . $path;
        return $this->createHeaders()->get($requestPath)->throw()->json();
    }

    /**
     * Call Internal API Put URI
     *
     * @param string $path (api path)
     * @param array $data (request data)
     *
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    public function put(string $path, array $data = []): mixed
    {
        $requestPath = $this->baseUri . "/" . $path;
        return $this->createHeaders()->put($requestPath, $data)->throw()->json();
    }

    /**
     * Call Internal API POST URI
     *
     * @param string $path (api path)
     * @param array $data (request data)
     *
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    public function post(string $path, array $data = []): mixed
    {
        $requestPath = $this->baseUri . "/" . $path;
        return $this->createHeaders()->post($requestPath, $data)->throw()->json();
    }

    /**
     * Call Internal API Put URI
     *
     * @param string $path (api path)
     * @param array $data (request data)
     *
     * @return mixed
     * @throws ConnectionException
     * @throws RequestException
     */
    public function delete(string $path, array $data = []): mixed
    {
        $requestPath = $this->baseUri . "/" . $path;
        return $this->createHeaders()->delete($requestPath, $data)->throw()->json();
    }

    /**
     * Get token from redis cache server with hostname.
     * If there is no cache for token, request to api server.
     *
     * @return string token
     */
    private function getToken(): string
    {
        // Make the GET request to the API
        $path = $this->baseUri."/getToken";
        $response = Http::get($path);

        // Check if the request was successful
        if ($response->successful()) {
            return $response->json()['token'];
        } else {
            // Handle the error, e.g., throw an exception or return an error response
            return response()->json(['error' => 'Unable to retrieve token'], 500);
        }
    }

    /**
     * Create request header
     *
     * @return PendingRequest
     */
    private function createHeaders(): PendingRequest
    {
        $token = $this->getToken();

        return Http::retry(config('api.maxTryCounts'), config('api.apiWaitSeconds'), fn($exception, $request) => $exception instanceof ConnectionException)->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => sprintf('Bearer %s', $token)
        ]);
    }
}
