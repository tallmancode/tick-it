<?php


namespace App\Service\InterestsService\Exceptions;

use Throwable;

class TablesNotFoundException extends \Exception
{
    public function __construct(array $missingTables, $code = 418, Throwable $previous = null)
    {
        $message = 'The following tables could not be found: '. implode(' ', $missingTables);
        parent::__construct($message, $code, $previous);
    }
}