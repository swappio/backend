<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiHandler extends Handler
{
    private static $statusMessages = [
        400 => 'Bad Request',
        401 => 'Not Authorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if (strpos($request->url(), '/api/') === false) {
            return parent::render($request, $e);
        }

        $response = [];

        // If the app is in debug mode
        if (config('app.debug')) {
            // Add the exception class name, message and stack trace to response
            $response['exception'] = get_class($e); // Reflection might be better here
            $response['message'] = $e->getMessage();
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
        }

        // Default response of 400
        $status = 500;
        $response['message'] = 'Internal Server Error';

        // If this exception is an instance of HttpException
        if ($e instanceof HttpException) {
            // Grab the HTTP status code from the Exception
            $status = $e->getStatusCode();
            $response['status'] = $status;
            $response['message'] = self::$statusMessages[$status];
        }

        // Return a JSON response with the response array and status code
        return response()->json($response, $status);
    }
}
