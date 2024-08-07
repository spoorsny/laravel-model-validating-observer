<?php

namespace Spoorsny\Laravel\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ModelValidatingObserver
{
    public function saving(Model $model): void
    {
        if (! $this->hasValidationRules($model)) {
            return;
        }

        $validationRules = $model::validationRules();

        $validator = Validator::make(
            $model->getAttributes(),
            $validationRules['rules'] ?? [],
            $validationRules['messages'] ?? []
        );


        if ($validator->fails()) {
            throw new ValidationException($validator, null, $validator->errors()) ;
        }
    }

    private function hasValidationRules(Model $model): bool
    {
        $methods = (new \ReflectionClass(get_class($model)))->getMethods();

        $methodNames = array_map(fn ($method) => $method->name, $methods);

        return in_array(needle: 'validationRules', haystack: $methodNames);
    }
}
