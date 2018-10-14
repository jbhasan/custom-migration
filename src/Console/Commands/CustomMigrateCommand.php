<?php

namespace Sayeed\CustomMigrate\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:custom {file_name_without_extension=false} {refresh=false} {sub_folder=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custom migrate using file name';

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
        $sub_folder = ($this->argument('sub_folder') == 'false') ? false : $this->argument('sub_folder') ;
        $file_name_without_extension = ($this->argument('file_name_without_extension') == 'false') ? false : $this->argument('file_name_without_extension') ;
        $refresh = ($this->argument('refresh') == 'false') ? false : $this->argument('refresh') ;

        $mainPath = database_path('migrations');
        $directories = glob($mainPath.'/' . $sub_folder . '*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        if ($file_name_without_extension) {
            $files[0] = $mainPath.'/'.$file_name_without_extension.'.php';
        } else {
            $files = glob($paths[0] . '/*.php');
        }
        if(Schema::hasTable('migrations')) {
            $batch_no = DB::table('migrations')->max('batch');
			$this->info('MIGRATION STARTED');
            foreach ($files as $key => $file) {
                $basename = basename($file);
                $file_info = pathinfo($basename);
                $file_name = $file_info['filename'];
				$file_content = explode("Schema::create('", file_get_contents($files[0]));

				if (count($file_content) > 1) {
					$file_content = explode("', function (Blueprint", $file_content[1]);
					if (count($file_content) > 1) {
						$table_name = $file_content[0];
					}
				} else {
					$this->error('-> '.$file_name.' Migration file invalid');
				}

                if ($refresh) {
                    DB::table('migrations')->where('migration', $file_name)->delete();
					Schema::dropIfExists('users');
                     if (Schema::hasTable($table_name)) {
                         Schema::drop($table_name);
                     }
                }

                $already_migrate = DB::table('migrations')->where('migration', $file_name)->first();
                if($already_migrate) {
                    $this->line('-> '.$file_name.' ALREADY MIGRATED');
                } else {
                    require_once($mainPath.'/'.$basename);

                    $all_classes = get_declared_classes();
                    $lastTableClassName = end($all_classes);
                    try {
						DB::table('migrations')->insert(['migration' => $file_name, 'batch' => ($batch_no+1)]);
						if (!Schema::hasTable($table_name)) {
							$tableClass = new $lastTableClassName();
							$tableClass->up();
							$this->info('-> '.$file_name.' SUCCESSFULLY MIGRATED');
						} else {
							$this->info('-> '.$file_name.' ADDED IN MIGRATION TABLE');
						}
                    } catch(\Exception $exception) {
                        // $this->info($exception);
                        $this->error('-> SOME PROBLEM OCCURS, PLEASE INFORM TO DEVELOPER <-');
                    }
                }            
            }

            $this->info('MIGRATION COMPLETED');
        } else {
            $this->error('-> MIGRATIONS TABLE NOT FOUND. PLEASE RUN FIRST "php artisan migrate" <-');
        }
    }
}
