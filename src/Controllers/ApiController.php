<?php
namespace Savich\ApiSkeleton\Controllers;

use Illuminate\Routing\Controller;
use Savich\ApiSkeleton\Response\ResponseInterface;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    /**
     * @var ResponseInterface
     */
    public $response;

    /**
     * Response errors
     * @var array
     */
    private $errors = [];

    /**
     * Response data result
     * @var
     */
    private $responseResult;

    /**
     * Set guard driver
     * @var string
     */
    protected $guard = null;
    
    /**
     * @var Model
     */
    private $user;

    /**
     * BaseApiController constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function getGuard()
    {
        return \Auth::guard($this->guard);
    }

    /**
     * Get current login user
     * @return Model
     */
    protected function user()
    {
        if (is_null($this->user)) {
            $this->user = \JWTAuth::parseToken()->toUser();
        }
        
        return $this->user;
    }
    
    /**
     * Setting errors 
     * @param array|string $errors
     */
    protected function addErrors($errors)
    {
        if (is_array($errors)) {
            $this->errors = array_merge($this->errors, $errors);
        } elseif (is_string($errors)) {
            $this->errors[] = $errors;
        }
    }

    /**
     * Set result response data
     * @param $response
     */
    protected function setResponse($response)
    {
        if (empty($this->errors)) {
            $this->responseResult = $response;
        }
    }

    /**
     * Send response
     * @param null $response
     * @return mixed
     */
    protected function send($response = null)
    {
        if (!$this->checkErrors()) {
            return $this->response->send([], $this->errors);
        } elseif (!empty($response)) {
            return $this->response->send($response);
        } else {
            return $this->response->send($this->responseResult);
        }
    }

    /**
     * Check if error existing
     * @return bool
     */
    protected function checkErrors()
    {
        return empty($this->errors);
    }
}
