<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class NotExistsException extends \Exception
{

    protected $code = Response::HTTP_NOT_FOUND;

}
