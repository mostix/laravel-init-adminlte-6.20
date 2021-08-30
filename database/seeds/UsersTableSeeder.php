<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      foreach (config('roles.roles') as $roleName) {

        $email = $roleName.'@asap.bg';

        if (!User::where('email', $email)->first()) {

          $user = new User;
          $user->username = "$roleName";
          $user->email = $email;
          $user->password = bcrypt('pass123');
          $user->email_verified_at = Carbon::now();
          $user->password_changed_at = Carbon::now();
          $user->save();

          echo "User with email: ".$user->email." saved \n";

          $role = Role::where('name', $roleName)->first();

          $user->assignRole($role);

          echo "Role $role->name was assigned to $user->name \n";
        }
      }
    }
}
