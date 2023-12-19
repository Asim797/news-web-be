<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class BaseResponse implements Responsable
{
    /**
     * request status code will be in this variable
     * @var int
     */
    protected int $code;

    /**
     * response message will be in this variable
     * @var string
     */
    protected string $message;

    /**
     * model data will be in this variable
     * @var array
     */
    protected array $data;

    /**
     * Default constructor to load data
     * @param int $code
     * @param string $message
     * @param array $data
     */
    public function __construct($code, $message, $data)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->data    = $data;
    }

    /**
     * Responsible method to return JSON as per request
     * @param  object $request
     */
    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            $data = [
                "statusCode" => $this->code,
                "message"    => $this->message,
                "data"       => $this->data,
            ];
            return response()->json(
                $data,
                $this->code
            );
        }
        return response()->json(['error' => 'something went wrong'], 401);
    }
}
