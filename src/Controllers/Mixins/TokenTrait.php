<?php
namespace Savich\ApiSkeleton\Controllers\Mixins;

use Illuminate\Database\Eloquent\Model;
use Savich\ApiSkeleton\Controllers\ApiController;
use Savich\ApiSkeleton\Response\ResponseApi;
use Savich\ApiSkeleton\Response\ResponseInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class TokenTrait
 * @package App\Http\Controllers\Api\Mixins
 * @property ResponseInterface $response
 */
trait TokenTrait
{
    /**
     * @param $user
     *
     * @return mixed
     */
    protected function attemptToken($user)
    {
        try {
            if (!empty($user)) {
                $token = $this->tokenFromUser($user);
            }

            if (empty($token)) {
                return $this->response->send(['user' => null], ['Authentication failed']);
            }
        } catch (JWTException $e) {
            return $this->response->send(['token' => null], ['Could not create token']);
        }

        $userByToken = $this->userByToken($token);

        event('tymon.jwt.valid', $userByToken);

        return $this->response->send($userByToken, [], ResponseApi::STATUS_SUCCESS, $token);
    }

    /**
     * Getting model by api token
     * @param string $token
     */
    protected function userByToken($token)
    {
        return \JWTAuth::toUser($token);
    }

    /**
     * @param Model $user
     */
    protected function tokenFromUser($user)
    {
        return \JWTAuth::fromUser($user);
    }

    /**
     * @param $credentials
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function getUser($credentials)
    {
        /* @var $this ApiController */
        $guard = $this->getGuard();
        $guard->attempt($credentials);

        return $guard->user();
    }
}