<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kelasList = [
            'X TJKT 1', 'X TJKT 2', 'X SIJA 1', 'X SIJA 2',
            'XI TJKT 1', 'XI TJKT 2', 'XI SIJA 1', 'XI SIJA 2',
            'XII TJKT 1', 'XII TJKT 2', 'XII SIJA 1', 'XII SIJA 2',
        ];

        return [
            'name' => fake()->name(),
            'nis' => fake()->unique()->numerify('##########'),
            'kelas' => fake()->randomElement($kelasList),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'siswa',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
