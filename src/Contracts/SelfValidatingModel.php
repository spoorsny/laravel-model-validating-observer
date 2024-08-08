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

namespace Spoorsny\Laravel\Contracts;

/**
 * Specifies the methods that an \Illuminate\Database\Eloquent\Model subclass
 * must implement in order to be validated by the
 * \Spoorsny\Laravel\Observers\ValidateModel observer.
 *
 * @author     Geoffrey Bernardo van Wyk <geoffrey@vanwyk.biz>
 * @copyright  2024 Geoffrey Bernardo van Wyk {@link https://geoffreyvanwyk.dev}
 * @license    {@link http://www.gnu.org/copyleft/gpl.html} GNU GPL v3 or later
 */
interface SelfValidatingModel
{
    /**
     * Rules for validating the model's attributes.
     *
     * An example of an array that must be returned by this method:
     *
     *   [
     *       'rules' => [
     *           'make' => 'required|string',
     *           'model' => 'required|string',
     *       ],
     *       'messages' => [
     *           'make.required' => 'We need to know the make of the car.',
     *       ],
     *   ]
     *
     * @see     {@link https://laravel.com/docs/11.x/validation#manually-creating-validators}
     * @see     {@link https://laravel.com/docs/11.x/validation#manual-customizing-the-error-messages}
     * @return  array<string,array<string,mixed>>
     */
    public static function validationRules(): array;
}
