<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class blade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:blade {blade : blade path} {template? : copy from template}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade file';

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
        //
        $blade = $this->argument('blade');
        $template = $this->argument('template');
        $template_path='';
        if(!empty($template)){
            $template_path = base_path('resources/views/'.$template.'.blade.php');
            if(!file_exists($template_path)){
                $this->error('template is not exist!');
                return;
            }
        }


        $blade_path = base_path('resources/views/'.$blade.'.blade.php');
        if(file_exists($blade_path)){
            $this->info('blade is  exist!');
            if (!$this->confirm('Do you want to overwrite? [y|N]')) {
                return;
            }
        }
        $blade_path_info = pathinfo($blade_path);

        if(!file_exists($blade_path_info['dirname'])){

            if(!mkdir($blade_path_info['dirname'],0775,true)){
                $this->error('Failed to create folder');
                return;
            }
        }


        if(file_exists($template_path)){
            file_put_contents($blade_path,file_get_contents($template_path),LOCK_EX);
        }else{
            file_put_contents($blade_path,'',LOCK_EX);
        }

        $this->info('blade generated successfully');
    }
}
