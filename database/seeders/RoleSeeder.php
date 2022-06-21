<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $superpermissions = [];
        foreach ($permissions as $permission) {
            $superpermissions[] = $permission->name;
        }
        $lists = [
            0 => [
                'name' => 'super-admin',
                'label' => 'مدیرکل',
                'permissions' => $superpermissions
            ],
            1 => [
                'name' => 'product_manager',
                'label' => 'مدیر تولید',
                'permissions' => [
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'edition-doing',
                    'edition-create',
                    'edition-edit',
                    'edition-delete',
                    'edition-team',
                ]
            ],
            2 => [
                'name' => 'documentary_manager',
                'label' => 'مدیر مستندسازی',
                'permissions' => [
                    'user-list',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'edition-doing',
                    'edition-comment',
                    'edition-leader',
                    'edition-leader-delete',
                    'edition-time',
                    'edition-leader-incorrect',
                    'edition-leader-comment',
                    'edition-version',
                    'edition-version-delete',
                    'edition-editor',
                    'edition-editor-delete',
                    'edition-editor-incorrect',
                    'edition-editor-color',
                    'edition-editor-comment',
                    'report-all',
                ]
            ],

            3 => [
                'name' => 'leader',
                'label' => 'مسول درس',
                'permissions' => [
                    'edition-doing',
                    'edition-leader',
                    'edition-leader-incorrect',
                    'edition-leader-comment',
                    'edition-editor',
                    'edition-editor-delete',
                    'edition-editor-incorrect',
                    'edition-editor-color',
                    'edition-editor-comment',
                ]
            ],
            4 => [
                'name' => 'editor',
                'label' => 'ویراستار',
                'permissions' => [
                    'edition-doing',
                    'edition-leader',
                    'edition-editor',
                    'edition-editor-comment',
                ]
            ],

        ];
        foreach ($lists as $item) {
            $role = Role::where('name', $item['name'])->first();

            if (!$role) {
                $role = Role::create([
                    'name' => $item['name'],
//                    'label' => $item['label'],
                ]);
            }

            $ids = [];
            foreach ($item['permissions'] as $permission) {
                $secret = Permission::where('name', $permission)->pluck('id')->first();
                if ($secret) {
                    $ids[] = $secret;
                }
            }
            $role->syncPermissions($ids);
        }
    }

}
