<?php
namespace Savich\ApiSkeleton\Requests;

use App\Http\Requests\Request;

abstract class ApiRequest extends Request
{
    public function response(array $errors)
    {
        return \ResponseApi::send([], $errors);
    }
}