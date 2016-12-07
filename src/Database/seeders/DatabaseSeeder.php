<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Site administrator with full access to all functions'
        ]);
        DB::table('roles')->insert([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Site editor with ability to change data, but not access administrative functions'
        ]);
        DB::table('roles')->insert([
            'name' => 'backend',
            'display_name' => 'Backend',
            'description' => 'Backend user with limited powers to change data and no administrative rights'
        ]);
        DB::table('permissions')->insert([
            'name' => 'adminminister-site',
            'display_name' => 'Administer site',
            'description' => 'Use administration functions'
        ]);
        DB::table('permissions')->insert([
            'name' => 'read-content',
            'display_name' => 'Read content',
            'description' => 'View non-administrative content'
        ]);
        DB::table('permissions')->insert([
            'name' => 'edit-content',
            'display_name' => 'Edit content',
            'description' => 'Edit non-administrative content'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '1'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '1',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '2',
            'permission_id' => '2'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '2',
            'permission_id' => '3'
        ]);
        DB::table('permission_role')->insert([
            'role_id' => '3',
            'permission_id' => '3'
        ]);
    }
}
