<?php

namespace App\Console\Commands\Lablog;

use Illuminate\Console\Command;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lablog:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Admin';

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
     * 注册用户
     */
    public function handle()
    {

        $username = $this->ask('请输入用户名', false);
        $email = $this->ask('请输入邮箱', false);
        $password = $this->ask('请输入密码', false);
        event(new Registered($createOrFail = User::create([
            'name'     => $username,
            'email'    => $email,
            'password' => Hash::make($password),
            'status'   => 1,
            'avatar'   => '\uploads\avatar\default.png',
        ])));
        $this->warn('=======！！！ 牢记注册信息 ！！！=======');
        $this->line('管理员邮箱：'.$email);
        $this->line('管理员密码：'.$password);
        $this->warn('=======！！！ 牢记注册信息 ！！！=======');
    }
}
