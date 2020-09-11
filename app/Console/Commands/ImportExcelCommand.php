<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\UserInfoImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;

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
        //start1表示
        $this->output->title('Starting import');
        //file取得
        $file = $this->argument('file');
        //insertなどの処理
        $import = new UserInfoImport();
        $import->import($file);
        //成功件数を取得
        $success_number = $import->succes_number();
        //エラー内容を取得
        $alls = Session::all();
        $erroe_number = 0;
        //エラーがあれば、メッセージ表示、エラー数カウント
        if (!empty($alls)) {
            $this->error(\Lang::get('excel.error_msg'));
            foreach ($alls as $all) {
                foreach ($all as $key => $error) {
                    //エラー行数取得
                    $row = $error->row();
                    $row--;
                    //エラーメッセージ取得
                    $error_msg = $error->errors();
                    $this->info($row.'行目の'.$error_msg[0]);
                }
                //エラー数をカウント
                $erroe_number++;
            }
        }
        //処理後、文言表示
        $this->output->success('エラー件数'.$erroe_number.'件、'.'成功件数'.$success_number.'件');
    }

}
