<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;
use App\Tag;

class RefreshDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is Useful Feature to Refresh Your Database and Seeds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:refresh');

        $this->call('db:seed');

        $this->info('All database has been referes ');
        // return 0;
    }
}
