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

namespace Spoorsny\Laravel\Tests\Unit;

use Illuminate\Validation\ValidationException;
use ReflectionClass;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

use Spoorsny\Laravel\Observers\ModelValidatingObserver;
use Spoorsny\Laravel\Tests\Fixtures\Models\Car;
use Spoorsny\Laravel\Tests\Fixtures\Models\WithoutValidationRules;
use Spoorsny\Laravel\Tests\TestCase;

/**
 * @author     Geoffrey Bernardo van Wyk <geoffrey@vanwyk.biz>
 * @copyright  2024 Geoffrey Bernardo van Wyk {@link https://geoffreyvanwyk.dev}
 * @license    {@link http://www.gnu.org/copyleft/gpl.html} GNU GPL v3 or later
 */
#[CoversClass(ModelValidatingObserver::class)]
class ModelValidatingObserverTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_passes_a_new_instance_without_validation_rules(): void
    {
        $this->assertObservedByMe(WithoutValidationRules::class);

        $car = new WithoutValidationRules();
        $car->make = 'Volkswagen';
        $car->model = 'Polo Vivo';
        $car->save();
    }

    #[Test]
    public function it_passes_an_existing_instance_without_validation_rules(): void
    {
        $this->assertObservedByMe(WithoutValidationRules::class);

        $car = new WithoutValidationRules();
        $car->make = 'Volkswagen';
        $car->model = 'Polo Vivo';
        $car->save();

        $car = WithoutValidationRules::find(1);
        $car->make = 'Mitsubishi';
        $car->model = 'Triton';
        $car->save();
    }

    #[Test]
    public function it_passes_a_valid_new_instance(): void
    {
        $this->assertObservedByMe(Car::class);

        $car = new Car();
        $car->make = 'Volkswagen';
        $car->model = 'Polo Vivo';
        $car->save();
    }

    #[Test]
    public function it_passes_a_valid_existing_instance(): void
    {
        $this->assertObservedByMe(Car::class);

        $car = new Car();
        $car->make = 'Volkswagen';
        $car->model = 'Polo Vivo';
        $car->save();

        $car = Car::find(1);
        $car->make = 'Mitsubishi';
        $car->model = 'Triton';
        $car->save();
    }

    #[Test]
    public function it_fails_an_invalid_new_instance(): void
    {
        $this->assertObservedByMe(Car::class);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('We need to know the make of the car.');

        $car = new Car();
        $car->make = '';
        $car->model = 'Polo Vivo';
        $car->save();
    }

    #[Test]
    public function it_fails_an_invalid_existing_instance(): void
    {
        $this->assertObservedByMe(Car::class);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('We need to know the make of the car.');

        $car = new Car();
        $car->make = 'Volkswagen';
        $car->model = 'Polo Vivo';
        $car->save();

        $car = Car::find(1);
        $car->make = '';
        $car->model = 'Polo Vivo';
        $car->save();
    }

    /**
     * Assert that the class is observed by the ModelValidatingObserver::class.
     */
    private function assertObservedByMe(string $className): void
    {
        $attributes = (new ReflectionClass($className))->getAttributes();

        $observedByAttributes = array_filter($attributes, function ($attr) {
            return $attr->getName() === ObservedBy::class
                && in_array(ModelValidatingObserver::class, $attr->getArguments());
        });

        $this->assertTrue(count($observedByAttributes) >= 1);
    }
}
