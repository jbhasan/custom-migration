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
    protected $signature = 'migrate:custom {--f|file=} {--r|refresh} {--d|directory=}';

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
    public $migrator;
    public $resolver;
    public $files;
    public function handle()
    {
        $directory = $this->option('directory');
        $given_file = $this->option('file');
        $refresh = $this->option('refresh');

        $mainPath = database_path('migrations');
        $directories = glob($mainPath.'/' . $directory . '*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        if ($given_file) {
            $files[0] = $mainPath.'/'.$given_file.'.php';
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
				$file_content = explode("Schema::create(", file_get_contents($file));

				$table_create_migrate = true;
				if (count($file_content) > 1) {
					$file_content = explode("'", $file_content[1]);
					if (count($file_content) > 1) {
                        $table_name = trim($file_content[0], '"');
						$table_name = trim($table_name, "'");
					} else {
						$this->error('-> '.$file_name.' Migration file invalid');
						continue;
					}
				} else {
					$table_create_migrate = false;
					// non table-create migration
					//$this->error('-> '.$file_name.' Migration file invalid');


				}

                if ($refresh) {
                    DB::table('migrations')->where('migration', $file_name)->delete();
                    if ($table_create_migrate) {
						Schema::dropIfExists($table_name);
						if (Schema::hasTable($table_name)) {
							Schema::drop($table_name);
						}
					}
                }

				require_once($mainPath.'/'.$basename);
				$all_classes = get_declared_classes();
				$lastTableClassName = end($all_classes);

				$already_migrate = DB::table('migrations')->where('migration', $file_name)->first();
				if($already_migrate) {
					if ($table_create_migrate) {
						$this->line('-> '.$file_name.' ALREADY MIGRATED');
						if (!Schema::hasTable($table_name)) {
							$tableClass = new $lastTableClassName();
							$tableClass->up();
							$this->info('-> '.$file_name.' SUCCESSFULLY MIGRATED');
						}
					} else {
						$tableClass = new $lastTableClassName();
						$tableClass->up();
						$this->info('-> '.$file_name.' SUCCESSFULLY RE-MIGRATED');
					}
                } else {
                    try {
						DB::table('migrations')->insert(['migration' => $file_name, 'batch' => ($batch_no+1)]);
						if ($table_create_migrate) {
							if (Schema::hasTable($table_name)) {
								$this->info('-> ' . $file_name . ' ADDED IN MIGRATION TABLE');
							}
						}

						$tableClass = new $lastTableClassName();
						$tableClass->up();
						$this->info('-> '.$file_name.' SUCCESSFULLY MIGRATED');
                    } catch(\Exception $exception) {
                    	//$this->error($exception);
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
