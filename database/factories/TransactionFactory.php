<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seller;
use App\Models\User;


class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;
    

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
         //except  expect
        $seller=Seller::has('product')->get()->random();
        $buyer=User::all()->except($seller->id)->random();
        return [ 
         'quantity' =>$this->faker->numberBetween(1,10),
         'buyer_id' =>$buyer->id,
         'product_id' =>$seller->product->random()->id, 
         //'product_id'=>$this->faker->numberBetween  
        ];
    }
}
