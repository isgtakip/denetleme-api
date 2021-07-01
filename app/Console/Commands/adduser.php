<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class adduser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $first_name = $this->ask('What is the first name?');
            $last_name = $this->ask('What is the last name?');
            $email = $this->ask('What is the email address?');
            $password = $this->secret('What is the password?');

            User::create([
                'name' => $first_name.' '.$last_name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);

            $this->info("User $first_name $last_name was created");
        return 0;
    }
}
