<?php

namespace Spoorsny\Laravel\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spoorsny\Laravel\Observers\ModelValidatingObserver;

#[ObservedBy(ModelValidatingObserver::class)]
class Car extends Model
{
    use HasFactory;

    /**
     * Rules for validating the model's attributes.
     *
     * @see     {@link https://laravel.com/docs/11.x/validation#available-validation-rules}
     * @return  array<string,array<string,mixed>>
     */
    protected static function validationRules(): array
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
