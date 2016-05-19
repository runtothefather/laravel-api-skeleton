<?php
namespace Savich\ApiSkeleton\Response;

interface ResponseInterface
{
    public function send($result = [], $errors = [], $status = null, $newToken = null);
}