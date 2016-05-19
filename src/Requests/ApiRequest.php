<?php
namespace Savich\ApiSkeleton\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    public function response(array $errors)
    {
        return \ResponseApi::send([], $errors);
    }
}