<?php

namespace App\Console\Commands;

use App\Services\TgBotService;
use Illuminate\Console\Command;

class RunTgBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-tg-bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запуск Tg-бота';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tgBotService = new TgBotService();
        while (true) {
            $res = $tgBotService->getUpdates();

            if (!empty($res->result)) {
                foreach ($res->result as $result)
                {
                    echo $result->message->from->first_name;
                }
            }
        }
        return Command::SUCCESS;
    }
}
