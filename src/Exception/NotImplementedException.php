<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class NotImplementedException extends \Exception
{

    /** @var int */
    protected $code = Response::HTTP_NOT_IMPLEMENTED;

}
