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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use Spoorsny\Laravel\Contracts\SelfValidatingModel;

/**
 * Validates any Eloquent model before persisting it by listening for the
 * model's `saving` event.
 *
 * @see        {@link https://laravel.com/docs/11.x/eloquent#observers}
 * @see        {@link https://laravel.com/docs/11.x/validation#manually-creating-validators}
 * @see        {@link https://laravel.com/docs/11.x/validation#manual-customizing-the-error-messages}
 * @author     Geoffrey Bernardo van Wyk <geoffrey@vanwyk.biz>
 * @copyright  2024 Geoffrey Bernardo van Wyk {@link https://geoffreyvanwyk.dev}
 * @license    {@link http://www.gnu.org/copyleft/gpl.html} GNU GPL v3 or later
 */
class ValidateModel
{
    public function saving(Model & SelfValidatingModel $model): void
    {
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
}
