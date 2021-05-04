<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
Use Storage;
class BackupRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore Database backup';

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
        //get all files in s3 storage backups directory
        $files = Storage::disk('local')->files();
//        $data ='backup-2021-05-04_07-04-38.sql';
        $numItems = count($files);
        $i = 0;
        foreach($files as $key=>$value) {
            if(++$i === $numItems) {
                $data =$value;
            }
        }

        Storage::disk('local')->put($data, 'Contest');

        $mime = Storage::mimeType($data);

        if($mime == "application/x-gzip"){

            //mysql command to restore backup from the selected gzip file
            $command = "zcat " . storage_path() . "/" . $data . " | mysql --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "";

        }elseif($mime == "text/plain"){

            //mysql command to restore backup from the selected sql file
            $command = "mysql --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " < " . storage_path() . "/" . $data . "";

        }else{

            //throw error if file type is not supported
            $this->error("File is not gzip or plain text");
            Storage::disk('local')->delete($data);
            return false;

        }
            $returnVar  = NULL;
            $output     = NULL;
            exec($command, $output, $returnVar);

            Storage::disk('local')->delete($data);

            if(!$returnVar){

                $this->info('Database Restored');

            }else{

                $this->error($returnVar);

            }

    }
}
