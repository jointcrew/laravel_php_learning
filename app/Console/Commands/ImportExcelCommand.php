<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\UserInfoImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportExcelCommand extends Command implements WithHeadingRow
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Excel File From Storage app.';

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
     * @return mixed
     */
    public function handle()
    {
        $this->output->title('Starting import');

        $file = $this->argument('file');
        //(new UserInfoImport)->withOutput($this->output)->import($file);
        //(new UserInfoImport)->import($file);
        $import = new UserInfoImport();
        $import->import($file);
        dd($import->errors());


        //var_dump($file);
        //$this->error($val);
        //$totalRows = count($count);
        //$this->error($totalRows);
        //Excel::import(new UserInfoImport, $file);
        //dd('Row count: ' . $import->getRowCount());
        $this->output->success('Import successful');
    }

}
