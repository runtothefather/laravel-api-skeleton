<?php
namespace Savich\ApiSkeleton\Middleware;

use Closure;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\ResponseFactory;
use Savich\ApiSkeleton\Response\ResponseApi;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Auth extends BaseMiddleware
{
    /**
     * @var ResponseApi
     */
    protected $responseApi;

    public function __construct(ResponseFactory $response, Dispatcher $events, JWTAuth $auth, ResponseApi $responseApi)
    {
        parent::__construct($response, $events, $auth);
        $this->responseApi = $responseApi;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {
            $user = $this->auth->parseToken()->toUser();
        } catch (TokenExpiredException $e) {
            $newToken = $this->auth->setRequest($request)->parseToken()->refresh();

            return $this->responseApi->send([], ['Token expired'], ResponseApi::STATUS_EXPIRED, $newToken);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (!$user) {
            return response('Not found.', 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}
