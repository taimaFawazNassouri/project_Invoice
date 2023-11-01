<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$user = User::create([
'name' => 'taima nassouri',
'email' => 'taimanass21@gmail.com',
'password' => bcrypt('12345678'),
'role_name'=> ['Owner'],
'status'=>'Enabled',
]);
$role = Role::create(['name' => 'Owner']);
$permissions = Permission::pluck('id','id')->all();
$role->syncPermissions($permissions);
$user->assignRole([$role->id]);
}
}