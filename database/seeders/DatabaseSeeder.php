<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 'super',
            'email_verified_at' => now(),
            'password' => '$2y$10$WefUM5vUSa06yWRZnSARteKyw8T.OSE1SCJ/u9rDoLs1rkoV7zSD6', //password :admin@4427
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'super',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);


        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'doctor',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('roles')->insert([
            'name' => 'patient',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'create',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'update',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('permissions')->insert([
            'name' => 'show',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::table('model_has_permissions')->insert([
            'permission_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);

        DB::table('model_has_permissions')->insert([
            'permission_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);

        DB::table('model_has_permissions')->insert([
            'permission_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);

        DB::table('model_has_permissions')->insert([
            'permission_id' => 4,
            'model_type' => 'App\Models\User',
            'model_id' => 1,
        ]);


//        \App\Models\User::factory(51)->doctor()->create();
//        \App\Models\Doctor::factory(50)->create();

//         for ($i = 1; $i <= 5; $i++) {
//             switch ($i) {
//                 case 1:
//                     \App\Models\User::factory(51)->doctor()->create();
//                     \App\Models\Doctor::factory(50)->create();
//                     break;
//                 case 2:
//                     \App\Models\User::factory(50)->patient()->create();
//                     \App\Models\Patient::factory(50)->create();
//                     break;
//                 case 3:
//                     \App\Models\Appointment::factory(50)->create();
//                     break;
//                 case 4:
//                     \App\Models\Transaction::factory(50)->create();
//                     break;
//                 case 5:
//                     \App\Models\CustomerInvoice::factory(50)->create();
//                 break;
//             }
//         }

    }
}
