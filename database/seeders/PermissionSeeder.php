<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'role' => [
                [
                    'name' => 'role-list',
                    'label' => 'مدیریت نقش',
                ],
                [
                    'name' => 'role-create',
                    'label' => 'ایجاد نقش',
                ],
                [
                    'name' => 'role-edit',
                    'label' => 'ویرایش نقش',
                ],
                [
                    'name' => 'role-delete',
                    'label' => 'حذف نقش',
                ],

            ],
            'user' => [
                [
                    'name' => 'user-list',
                    'label' => 'مدیریت افراد',
                ],
                [
                    'name' => 'user-create',
                    'label' => 'ایجاد افراد',
                ],
                [
                    'name' => 'user-edit',
                    'label' => 'ویرایش افراد',
                ],
                [
                    'name' => 'user-delete',
                    'label' => 'حذف افراد',
                ],
            ],
            'edition' => [
                [
                    'name' => 'edition-all',
                    'label' => 'کل درخواست ها',
                ],
                [
                    'name' => 'edition-doing',
                    'label' => 'درخواست های در حال انجام',
                ],
                [
                    'name' => 'edition-create',
                    'label' => 'ایجاد درخواست',
                ],

                [
                    'name' => 'edition-edit',
                    'label' => 'ویرایش درخواست',
                ],
                [
                    'name' => 'edition-delete',
                    'label' => 'حذف درخواست',
                ],

                [
                    'name' => 'edition-info',
                    'label' => 'اطلاعات درخواست',
                ],
                [
                    'name' => 'edition-team',
                    'label' => 'همکاران مدیر تولید',
                ],
                [
                    'name' => 'edition-comment',
                    'label' => 'کامنت مدیر مستند ساز',
                ],
                [
                    'name' => 'edition-leader',
                    'label' => 'مسول درس',
                ],
                [
                    'name' => 'edition-leader-delete',
                    'label' => 'حذف مسول درس',
                ],
                [
                    'name' => 'edition-time',
                    'label' => 'زمانبندی',
                ],
                [
                    'name' => 'edition-leader-incorrect',
                    'label' => 'اشکالات مسول درس',
                ],
                [
                    'name' => 'edition-leader-comment',
                    'label' => 'کامنت مسول درس',
                ],
                [
                    'name' => 'edition-version',
                    'label' => 'بازبینی',
                ],
                [
                    'name' => 'edition-version-delete',
                    'label' => 'حذف بازبینی',
                ],
                [
                    'name' => 'edition-editor',
                    'label' => 'ویراستار',
                ],
                [
                    'name' => 'edition-editor-delete',
                    'label' => 'حذف ویراستار',
                ],
                [
                    'name' => 'edition-editor-incorrect',
                    'label' => 'اشکالات ویراستار',
                ],
                [
                    'name' => 'edition-editor-color',
                    'label' => 'رنگدهی ویراستار',
                ],
                [
                    'name' => 'edition-editor-comment',
                    'label' => 'کامنت ویراستار',
                ],
            ],
            'report' => [
                [
                    'name' => 'report-all',
                    'label' => 'گزارش کلی',
                ],
            ],
        ];

        foreach ($lists as $key => $items) {
            foreach ($items as $item) {
                $permission = Permission::where('guard_name', $key)->where('name', $item['name'])->first();
                if (!$permission) {
                    Permission::create([
                        'name' => $item['name'],
//                        'label' => $item['label'],
//                        'guard_name' => 'panel',
                    ]);
                } else {
                    $permission->update([
                        'name' => $item['name'],
//                        'label' => $item['label'],
//                        'guard_name' => 'panel',
                    ]);
                }
            }
        }
    }
}
