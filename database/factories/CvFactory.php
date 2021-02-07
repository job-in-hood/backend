<?php

namespace Database\Factories;

use App\Models\Cv;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cv::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'original_name' => Str::slug($this->faker->name."_cv") . ".docx",
            'extension' => 'docx',
            'storage_path' => 'cv/' . Str::random()
        ];
    }
}
