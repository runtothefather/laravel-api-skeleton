<?php
namespace Savich\ApiSkeleton\Controllers;

use Illuminate\Routing\Controller;
use Savich\ApiSkeleton\Response\ResponseInterface;

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
     * Add error message
     * @param $message
     */
    protected function addError($message)
    {
        $this->errors[] = $message;
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
