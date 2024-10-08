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

namespace Spoorsny\Laravel\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spoorsny\Laravel\Observers\ValidateModel;

/**
 * @author     Geoffrey Bernardo van Wyk <geoffrey@vanwyk.biz>
 * @copyright  2024 Geoffrey Bernardo van Wyk {@link https://geoffreyvanwyk.dev}
 * @license    {@link http://www.gnu.org/copyleft/gpl.html} GNU GPL v3 or later
 */
#[ObservedBy(ValidateModel::class)]
class NotSelfValidatingCar extends Model
{
    use HasFactory;

    /**
     * Rules for validating the model's attributes.
     *
     * @see     {@link https://laravel.com/docs/11.x/validation#available-validation-rules}
     * @return  array<string,array<string,mixed>>
     */
    public static function validationRules(): array
    {
        return [
            'rules' => [
                'make' => 'required|string',
                'model' => 'required|string',
            ],
            'messages' => [
                'make.required' => 'We need to know the make of the car.',
            ],
        ];
    }
}
