<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class TruncateTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:truncate-tables {--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncate database tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $table = $this->option('table');

            if($table != null) {
                $this->truncateTable($table);
            } else {
                $tables = ['users', 'warehouses', 'inventory_items', 'stocks', 'stock_transfers'];
                foreach($tables as $table) {
                    $this->truncateTable($table);
                }
            }

            dump([
                "status"  => true,
                "message" => "Truncate completed."
            ]);
        } catch(Throwable $e) {
            dump([
                "status"  => false,
                "message" => $e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' ',
            ]);
        }
    }

    private function truncateTable($table)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->info('Start truncate table ' . $table . ' ...');
        DB::table($table)->truncate();
        $this->info('Table ' . $table . ' has been truncate.');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return;
    }
}
