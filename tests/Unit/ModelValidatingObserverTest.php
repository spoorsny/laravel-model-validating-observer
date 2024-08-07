<?php

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
