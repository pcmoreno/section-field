<?php
declare (strict_types=1);

namespace Tardigrades\FieldType;

use Throwable;

class NoCustomGeneratorDefinedException extends \Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = empty($message) ? 'For this field there is no custom generator, falling back to default handling' : $message;

        parent::__construct($message, $code, $previous);
    }
}
