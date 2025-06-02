<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDatabaseStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database structure and report issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking database structure...');

        try {
            // Check if users table exists
            $hasUsersTable = Schema::hasTable('tbl_users');
            $this->info('Users table exists: ' . ($hasUsersTable ? 'Yes' : 'No'));

            if ($hasUsersTable) {
                // Get columns
                $columns = Schema::getColumnListing('tbl_users');
                $this->info('Users table columns:');
                foreach ($columns as $column) {
                    $this->line("- $column");
                }

                // Check for required columns
                $requiredColumns = ['id', 'nis', 'nama', 'email', 'gender', 'nohp', 'tgllahir', 'avatar', 'role'];
                $missingColumns = array_diff($requiredColumns, $columns);
                
                if (!empty($missingColumns)) {
                    $this->error('Missing required columns: ' . implode(', ', $missingColumns));
                }
            }

            // Check sample data
            $sampleUser = DB::table('tbl_users')->where('role', 'user')->first();
            if ($sampleUser) {
                $this->info('Sample user data found:');
                $this->line(json_encode($sampleUser, JSON_PRETTY_PRINT));
            } else {
                $this->warn('No user data found with role = user');
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
