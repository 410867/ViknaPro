<?php

namespace App\ValueResolver;

use App\Object\FromRequestObjectInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use App\Object\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ObjectFromRequestResolver implements ValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(ArgumentMetadata $argument): bool
    {
        return
            $argument->getType() === FromRequestObjectInterface::class ||
            is_subclass_of($argument->getType(), FromRequestObjectInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->supports($argument)){
            return [];
        }

        $class = $argument->getType();

        $data = $class::newFromRequest($request);

        $constraints = $this->validator->validate($data);
        if ($constraints->count()){
            throw new ValidationFailedException($constraints);
        }

        yield $data;
    }
}
