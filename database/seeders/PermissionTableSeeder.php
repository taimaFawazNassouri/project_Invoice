<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$permissions = [
'invoices',
'list-invoices',
'paid-invoices',
'partially-invoices',
'unpaid-invoices',
'archive-invoices',
'reports',
'invoices-report',
'cliens-report',
'users',
'list-users',
'permission-users',
'setting',
'products',
'sections',
'add-invoice',
'delete-invoice',
'export-excel',
'change-status-invoice',
'edit-invoice',
'add-attachment',
'delete-attachment',
'add-user',
'edit-user',
'delete-user',
'show-permission',
'add-permission',
'edit-permission',
'delete-permission',
'add-product',
'edit-product',
'delete-product',
'add-section',
'edit-section',
'delete-section',
'notifications',
];
foreach ($permissions as $permission) {
Permission::create(['name' => $permission]);
}
}
}