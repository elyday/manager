<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class TeamSeeder
 *
 * @package Database\Seeders
 */
class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        DB::table('teams')->insert(
            [
                'id' => 1,
                'user_id' => $user->id,
                'name' => 'Team 1',
                'personal_team' => 1
            ]
        );
    }
}
