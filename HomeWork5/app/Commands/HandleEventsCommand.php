<?php

namespace App\Commands;

use App\Application;

use App\Database\SQLite;

use App\EventSender\EventSender;

use App\Models\Event;
use App\Telegram\TelegramApiImpl;

//use App\Models\EventDto;

class HandleEventsCommand extends Command

{

    protected Application $app;

    public function __construct(Application $app)

    {

        $this->app = $app;

    }

    public function run(array $options = []): void

    {

        $event = new Event(new SQLite($this->app));

        $events = $event->select();

        $eventSender = new EventSender(new TelegramApiImpl($this->app->env('TELEGRAM_TOKEN')));

        foreach ($events as $event) {

            die(var_dump(123, $event));
            
            if ($this->shouldEventBeRan($event)) {

                $eventSender->sendMessage($event['receiver_id'], $event['text']);

            }

        }

    }

    private function shouldEventBeRan($event): bool

    {
        $currentMinute = date("i");

        $currentHour = date("H");

        $currentDay = date("d");

        $currentMonth = date("m");

        $currentWeekday = date("w");

        return true;

        // return ($event['minute'] === $currentMinute &&

        //     $event['hour'] === $currentHour &&

        //     $event['day'] === $currentDay &&

        //     $event['month'] === $currentMonth &&

        //     $event['weekDay'] === $currentWeekday);
    }

}