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
        static $offset = 0;
        while (true) {
            echo $offset . PHP_EOL;
            $response = $tgBotService->getUpdates($offset);

            if (!empty($response->result)) {
                $updateIds = array_map(fn($update) => $update->update_id, $response->result);
                $maxUpdateId = max($updateIds);
                $offset = $maxUpdateId + 1;

                echo $offset;
                foreach ($response->result as $update)
                {
                    echo $update->message->from->first_name;
                }
            }
        }
        //return Command::SUCCESS;
    }
}
