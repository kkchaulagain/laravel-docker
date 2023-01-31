<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use kkchaulagain\phpQueue\Consumer;

class Queuelistner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:queue {queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume Queue';

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
        $queue = $this->argument('queue');
        $config = [
            'user' => 'guest',
            'password' => 'guest',
            'vhost' => "/",
            'host' => "rabbitmq",
            'port' => "5672",
            'queue' => $queue
        ];
        Consumer::consume($config);
    }
}
