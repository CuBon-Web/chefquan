<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddDetailFieldsToPromotionTable extends Migration
{
    public function up()
    {
        Schema::table('promotion', function (Blueprint $table) {
            if (!Schema::hasColumn('promotion', 'slug')) {
                $table->string('slug')->nullable()->after('name');
            }
            if (!Schema::hasColumn('promotion', 'badge')) {
                $table->string('badge')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('promotion', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('promotion', 'start_date')) {
                $table->date('start_date')->nullable()->after('content');
            }
            if (!Schema::hasColumn('promotion', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });

        $used = [];
        foreach (DB::table('promotion')->orderBy('id')->get(['id', 'name', 'slug']) as $row) {
            $slug = $row->slug ?: trim(preg_replace('/-+/', '-', to_slug((string) $row->name)), '-');
            if ($slug === '' || in_array($slug, $used, true)) {
                $slug = trim($slug . '-' . $row->id, '-');
            }
            $used[] = $slug;
            DB::table('promotion')->where('id', $row->id)->update(['slug' => $slug]);
        }
    }

    public function down()
    {
        Schema::table('promotion', function (Blueprint $table) {
            foreach (['slug', 'badge', 'content', 'start_date', 'end_date'] as $column) {
                if (Schema::hasColumn('promotion', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
