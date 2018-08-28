<?php

namespace App\Console\Commands\Lablog;

use Illuminate\Console\Command;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lablog:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lablog Config';

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
     * 初始化
     *
     */
    public function handle()
    {
        $app_name = $this->ask('请输入应用名', 'LABLOG');
        $app_url = $this->ask('请输入应用域名', 'https://imwnk.cn');
        $username = $this->ask('请输入数据库账号', 'root');
        $password = $this->ask('请输入数据库密码', false);
        $database = $this->ask('请输入数据库名', 'lablog');
        // ask 不允许为空  此处是为了兼容一些数据库密码为空的情况
        $password = $password ? $password : '';
        $envExample = file_get_contents(base_path('.env.example'));
        $search_db = [
            'APP_NAME=Lablog',
            'APP_URL=http://localhost',
            'DB_DATABASE=homestead',
            'DB_USERNAME=homestead',
            'DB_PASSWORD=secret'
        ];
        $replace_db = [
            'APP_NAME='.$app_name,
            'APP_URL='.$app_url,
            'DB_DATABASE='.$database,
            'DB_USERNAME='.$username,
            'DB_PASSWORD='.$password,
        ];
        $env = str_replace($search_db, $replace_db, $envExample);
        file_put_contents(base_path('.env'), $env);
        $this->call('key:generate');
    }
}
