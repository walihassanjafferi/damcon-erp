<?php

namespace Database\Factories;

use App\Models\BankPayments;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashPaymentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankPayments::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
