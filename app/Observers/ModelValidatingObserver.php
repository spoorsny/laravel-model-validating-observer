<?php

// This file is part of package spoorsny/laravel-model-validating-observer.
//
// Package spoorsny/laravel-model-validating-observer is free software: you can redistribute it
// and/or modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Package spoorsny/laravel-model-validating-observer is distributed in the hope that it will be
// useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
// Public License for more details.
//
// You should have received a copy of the GNU General Public License along with
// package spoorsny/laravel-model-validating-observer. If not, see <https://www.gnu.org/licenses/>.

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
