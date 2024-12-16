<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
		'command' => $this->faker->sentence, //Generates a fake sentence
        'param' => $this->faker->sentence, //Generates a fake sentence
		'description' => $this->faker->paragraph(30), //generates fake 30 paragraphs
	    //'id' => $this->faker->randomDigit(),
        'updated_at' => $this->faker->dateTime()
            //
        ];
    }
}
