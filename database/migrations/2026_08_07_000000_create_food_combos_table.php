<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Support\RbacPermissions;

class CreateFoodCombosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('food_combos')) {
            Schema::create('food_combos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('images')->nullable();
                $table->text('description')->nullable();
                $table->longText('menu')->nullable();
                $table->longText('content')->nullable();
                $table->decimal('price', 15, 0)->default(0);
                $table->decimal('sale_price', 15, 0)->nullable();
                $table->integer('sort')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->tinyInteger('status_home')->default(1);
                $table->timestamps();
            });
        }

        $now = now();
        foreach (RbacPermissions::all() as $slug => $name) {
            if (strpos($slug, 'foodcombo.') !== 0) {
                continue;
            }
            $exists = DB::table('permissions')->where('slug', $slug)->first();
            if (!$exists) {
                DB::table('permissions')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $superAdminRole = DB::table('roles')->where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $permissionIds = DB::table('permissions')
                ->where('slug', 'like', 'foodcombo.%')
                ->pluck('id');
            foreach ($permissionIds as $permissionId) {
                $exists = DB::table('role_permission')
                    ->where('role_id', $superAdminRole->id)
                    ->where('permission_id', $permissionId)
                    ->first();
                if (!$exists) {
                    DB::table('role_permission')->insert([
                        'role_id' => $superAdminRole->id,
                        'permission_id' => $permissionId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('food_combos');

        $permissionIds = DB::table('permissions')
            ->where('slug', 'like', 'foodcombo.%')
            ->pluck('id');
        if ($permissionIds->isNotEmpty()) {
            DB::table('role_permission')->whereIn('permission_id', $permissionIds)->delete();
            DB::table('permissions')->whereIn('id', $permissionIds)->delete();
        }
    }
}
