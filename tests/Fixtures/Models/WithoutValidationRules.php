<?php

namespace Spoorsny\Laravel\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spoorsny\Laravel\Observers\ModelValidatingObserver;

#[ObservedBy(ModelValidatingObserver::class)]
class WithoutValidationRules extends Model
{
    use HasFactory;
}
