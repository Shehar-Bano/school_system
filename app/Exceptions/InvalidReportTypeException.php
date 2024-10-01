<?php

// app/Exceptions/InvalidReportTypeException.php

namespace App\Exceptions;

use Exception;

class InvalidReportTypeException extends Exception
{
    // You can customize the exception further if needed
    public function __construct($message = "Invalid report type", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
