<?php
namespace Savich\ApiSkeleton\Response;

class ResponseApi implements ResponseInterface
{
    /**
     * Error status
     */
    const STATUS_ERROR = 0;
    /**
     * Success status
     */
    const STATUS_SUCCESS = 1;
    /**
     * Error token expires
     */
    const STATUS_EXPIRED = 2;
    /**
     * Error token invalid
     */
    const STATUS_INVALID = 3;
    /**
     * Error token not provided
     */
    const STATUS_NOT_PROVIDED = 4;

    public function send($result = [], $errors = [], $status = null, $newToken = null)
    {
        $message = $this->prepareErrorList($errors);
        $data = [
            'status' => $message === null ? self::STATUS_SUCCESS : ($status !== null ? $status : self::STATUS_ERROR),
            'message' => $message,
            'token' => $newToken ?: null,
            'result' => !empty($result) ? $result : null,
        ];

        return response()->json($data);
    }

    /**
     * Make error array not multidimensional
     *
     * @param $errorList
     *
     * @return array
     */
    public function prepareErrorList($errorList)
    {
        if (is_array($errorList) && count($errorList)) {
            $resultErrorList = [];

            foreach ($errorList as $fieldName => $errors) {
                if (is_array($errors)) {
                    $resultErrorList[$fieldName] = array_first($errors);
                } elseif (is_string($errors)) {
                    $resultErrorList[$fieldName] = $errors;
                };
            }

            return $resultErrorList;
        } else {
            return null;
        }
    }
}