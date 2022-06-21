<?php

namespace Database\Seeders;

use App\Models\BookRole;
use Illuminate\Database\Seeder;

class BookRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookRoles = [
            0 => [
                'value' => 'documentation_manager',
                'text' => 'مدیر مستندسازی',
                'group' => '1'
            ],
            1 => [
                'value' => 'production_manager',
                'text' => 'مدیر تولید',
                'group' => '2'
            ],
            2 => [
                'value' => 'leader',
                'text' => 'مسئول درس',
                'group' => '1'
            ],
            3 => [
                'value' => 'documentation_editor',
                'text' => 'ویراستار مستندسازی',
                'group' => '1'
            ],
            4 => [
                'value' => 'supervisor',
                'text' => 'ناظر',
                'group' => '2'
            ],
            5 => [
                'value' => 'author',
                'text' => 'مولف',
                'group' => '2'
            ],
            6 => [
                'value' => 'production_coordination',
                'text' => 'هماهنگی تولید',
                'group' => '2'
            ],
            7 => [
                'value' => 'selector',
                'text' => 'گزینشگر',
                'group' => '2'
            ],
            8 => [
                'value' => 'production_editor',
                'text' => 'ویراستار تولید',
                'group' => '2'
            ],
        ];
        BookRole::insert($bookRoles);
    }
}
