<?php

namespace App\Validators;

use App\Helpers\ArrayKeys;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Validation\ValidationInterface;

abstract class AbstractValidator
{
    protected ValidationInterface $validator;
    protected IncomingRequest $request;
    protected array $errors = [];

    public function __construct(
        IncomingRequest $request,
        ValidationInterface $validator
    ) {
        $this->request = $request;
        $this->validator = $validator;
    }

    abstract protected function rules(): array;

    public function validate(): bool
    {
        $this->validator->setRules($this->rules());

        $isValid = $this->validator->withRequest($this->request)->run();

        $this->errors = $this->validator->getErrors();

        return $isValid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getValidatedData(): array
    {
        $validatedData = ArrayKeys::toSnakeCase($this->validator->getValidated());
        unset($validatedData['id']);

        return $validatedData;
    }
}
