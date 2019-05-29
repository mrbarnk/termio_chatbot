<?php

// namespace App\Http\Controllers;

// use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
// use App\Conversations\ExampleConversation;
// use BotMan\BotMan\Messages\Outgoing\Question;
// use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;


class Botmancontroller
{
    /**
     * Place your BotMan logic here.
     */
    public function index() {
      // $this->hears('hello', 'hi');
      $config = [
          // Your driver-specific configuration
          // "telegram" => [
          //    "token" => "bot707979113:AAG2EQ_zzgrOn1IPNfUAjS7fu6tOgVeYIOE"
          // ]
          // 'web' => [
          // 	'matchingData' => [
          //         'driver' => 'web',
          //     ]
          //   ]
      ];

      // Load the driver(s) you want to use
      // DriverManager::loadDriver(BotMan\Drivers\Telegram\TelegramDriver::class);

      DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

      // Create BotMan instance
      // BotManFactory::create($config);
      $request = Request::capture();
      // Create an instance
      // $request = [
        // 'driver' => 'web',
        // "driver" => "web",
	      // "userId" => "1234",
	      // "message" => "hi"
      // ];
      // $request  = (object) $request;
      // echo $request->message;
      $botman = BotManFactory::create($config);

      // Give the bot something to listen for.
      ($botman->hears('Hello', function (BotMan $bot) {
          return $bot->say('Hello yourself.');
      }));
      // $botman->fallback(function($bot) {
      //     $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
      // });
      // Start listening
      $botman->listen();
      // $bot = BotMan::hears('Hello', function ($bot) {
      //     $bot->reply('Canceled, let\'s do a new one :). smiles...');
      // });
      // $this->handle($bot);
    }
    public function handle($botman)
    {
        $request = Request::capture();
        // $botman = new BotMan('botman');//app('botman');

        // echo "string";
        // Give the bot something to listen for.
        $msg = \App\Chatbots::where('message', $request->message);

        if(strtolower($request->message) == 'cancel') {
            if (isset(session()->get('learn')['status'])) {
                session()->flush('*');
                $botman->hears($request->message, function (BotMan $bot) {
                    $bot->reply('Canceled, let\'s do a new one :). smiles...');
                });
            }  else {
                $botman->hears($request->message, function (BotMan $bot) {
                    $bot->reply('Sorry, nothing to cancel at this time. :).');
                });
            }
        }
        if(isset(session()->get('learn')['status']) && session()->get('learn')['status'] == 'ok') {
            $c = new \App\Chatbots;
            $c->message = session()->get('learn')['message'];
            $c->reply = $request->message;
            $c->save();
            session()->flush('*');
            $botman->hears($request->message, function (BotMan $bot) {
                $bot->reply('Thanks, I already saved that. I won\'t forget it :).');
            });
            // return false;
        }
        if ($msg->count() > 0) {
            $botman->fallback(function($bot) {
                $request = Request::capture();
                $msg = \App\Chatbots::where('message', ($request->message));
                $bot->reply($msg->first()->reply);
            });
        } else {
            $botman->fallback(function($bot) {
                $request = Request::capture();
                session()->put('learn', ['status' => 'ok', 'message' => $request->message]);
                // session()->
                $bot->reply('Sorry, I did not understand this message, please tell me what to reply so i\'ll know. I promise not to forget it :), but tell me "cancel" to stop the learning.');
            });
        }

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    // public function startConversation(BotMan $bot)
    // {
    //     $bot->startConversation(new ExampleConversation());
    // }
}
