<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckAndSeedDatabase extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'db:check-and-seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check if specific tables are empty and run seeders if needed';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		// List of tables to check
		$tablesToCheck = ['users']; // Add your table names here

		$isEmpty = true;

		foreach ($tablesToCheck as $table) {
			$count = DB::table($table)->count();
			if ($count > 0) {
				$this->info("Table '{$table}' is not empty.");
				$isEmpty = false;
			} else {
				$this->info("Table '{$table}' is empty.");
			}
		}

		if ($isEmpty) {
			$this->info('All specified tables are empty. Running seeders...');
			$this->call('db:seed', ['--force' => true]);
		} else {
			$this->info('Some tables are not empty. Skipping seeders.');
		}

		return 0;
	}
}
