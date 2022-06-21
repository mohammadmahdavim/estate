<?php

namespace App\Helpers;

use Illuminate\Contracts\Validation\Validator;

/**
 * Class Reply
 * @package App\Classes
 */
class Reply
{

    /**
     * @param $messageOrData
     * @param null $data
     * @return array
     */
    public static function success($messageOrData, $data = null)
    {
        $response = [
            'status' => 'true'
        ];

        if (!empty($messageOrData) && !is_array($messageOrData)) {
            $response['message'] = Reply::getTranslated($messageOrData);
        }

        if (is_array($data)) {
            $response = array_merge($data, $response);
        }

        if (is_array($messageOrData)) {
            $response = array_merge($messageOrData, $response);
        }

        return $response;
    }

    public static function successJson($messageOrData, $data = null, $code = 200)
    {
        $response = [
            'status' => 'true'
        ];

        if (!empty($messageOrData) && !is_array($messageOrData)) {
            $response['message'] = Reply::getTranslated($messageOrData);
        }

        if (is_array($data)) {
            $response = array_merge($data, $response);
        }

        if (is_array($messageOrData)) {
            $response = array_merge($messageOrData, $response);
        }

        return response()->json($response,$code);
    }

    public static function errorJson($messageOrData, $data = null, $code = 400)
    {
        $response = [
            'status' => 'false'
        ];

        if (!empty($messageOrData) && !is_array($messageOrData)) {
            $response['message'] = Reply::getTranslated($messageOrData);
        }

        if (is_array($data)) {
            $response = array_merge($data, $response);
        }

        if (is_array($messageOrData)) {
            $response = array_merge($messageOrData, $response);
        }

        return response()->json($response,$code);
    }

    /**
     * @param $message
     * @param null $errorName
     * @param array $errorData
     * @return array
     */
    public static function error($message, $errorName = null, $errorData = [])
    {
        return [
            'status' => 'false',
            'error_name' => $errorName,
            'data' => $errorData,
            'message' => Reply::getTranslated($message)
        ];
    }

    /** Return validation errors
     * @param \Illuminate\Validation\Validator|Validator $validator
     * @return array
     */

    public static function formErrors($validator)
    {
        return [
            'status' => 'false',
            'errors' => $validator->getMessageBag()->toArray(),
            'message' => 'Please make sure to fill all the necessary fields.'
        ];
    }

    /** Response with redirect action. This is meant for ajax responses and is not meant for direct redirecting
     * to the page
     * @param $url string to redirect to
     * @param null $message Optional message
     * @return array
     */

    public static function redirect($url, $message = null)
    {
        if ($message) {
            return [
                'status' => 'true',
                'message' => Reply::getTranslated($message),
                'action' => 'redirect',
                'url' => $url
            ];
        } else {
            return [
                'status' => 'true',
                'action' => 'redirect',
                'url' => $url
            ];
        }
    }

    /**
     * @param $message
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    private static function getTranslated($message)
    {
        $trans = trans($message);

        if ($trans == $message) {
            return $message;
        } else {
            return $trans;
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function dataOnly($data)
    {
        return $data;
    }

    public static function successWithData($data)
    {
        $response = [
            'status' => 'true'
        ];

        $response['data'] = $data;

        return $response;
    }

    public static function formErrorsJson($validator, $code = 422)
    {
        return response()->json([
            'status' => 'false',
            'errors' => $validator->getMessageBag()->toArray(),
            'message' => 'Please make sure to fill all the necessary fields.'
        ], $code);
    }

}
