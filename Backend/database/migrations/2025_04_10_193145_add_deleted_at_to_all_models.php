<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('radionica', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('pitanjaRadionice', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('listaPrijava', function (Blueprint $table) {
			$table->softDeletes();
		});
		Schema::table('korisnikPodatak', function (Blueprint $table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});
		Schema::table('radionica', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});
		Schema::table('pitanjaRadionice', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});
		Schema::table('listaPrijava', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});
		Schema::table('korisnikPodatak', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});
	}
};
