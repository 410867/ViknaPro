<?php

namespace App\Object;

use Symfony\Component\HttpFoundation\Request;

interface FromRequestObjectInterface
{
    public static function newFromRequest(Request $request): static;
}