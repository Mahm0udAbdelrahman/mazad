<?php

namespace App\Exceptions;

use Exception;

class InsuranceNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage() ?: 'Not found',
            'type' => 'error',
            'code' => 400,
        ], 400);
    }
}
