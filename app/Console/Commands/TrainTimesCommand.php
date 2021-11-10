<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;

use Spatie\Dashboard\Models\Tile;

use Carbon\Carbon;

class TrainTimesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:fetch-train-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch updated train times';
    
    private $tile = null;
    private $nationalRailToken = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->tile = Tile::firstOrCreateForName('train_times');
        $this->nationalRailToken = env('NATIONAL_RAIL_TOKEN');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set("Europe/London");

        $tileConfigurations =  config('dashboard.tiles.train_times');
        foreach($tileConfigurations as $configurationName => $configuration)
        {
            if (!is_array($configuration))
                continue;

            $requestData = $configuration['data'];
            $originStation = $configuration['origin_station'];
            $destinationStation = $configuration['destination_station'];
            $resultCount = $configuration['result_count'] ?? 20;

            //https://huxley.apphb.com/departures/Hednesford/to/Birmingham New Street/20?accessToken=
            $response = Http::get("https://huxley.apphb.com/{$requestData}/{$originStation}/to/{$destinationStation}/{$resultCount}?accessToken={$this->nationalRailToken}");

            if (! $response->ok()) {
                return [];
            }
    
            $data = $response->json();
    
            $trains = collect($data['trainServices'] ?? [])
                ->map(function (array $service) use ($requestData) {
                    if ($service['isCancelled'])
                    {
                        return [];
                    }

                    $delayed = (!empty($service['etd']) && $service['etd'] != 'On time') ? true : false;

                    if ($delayed) {
                        $timeKey = ($requestData == 'departures') ? 'etd' : 'eta';
                    }

                    if (!$delayed) {
                        $timeKey = ($requestData == 'departures') ? 'std' : 'sta';
                    }

                    $serviceTime = $service[$timeKey];

                    $time = Carbon::parse(date('Y-m-d') . ' ' . $serviceTime);
                    $now = Carbon::now();

                    return [
                        'time' => $time->format('H:i'),
                        'tooLateToLeave' => $time->subMinutes(25)->lt($now),
                        'status' => $service['etd'],
                        'platform' => $service['platform'],
                        'operator' => $service['operator'],
                        'origin' => $service['origin'],
                        'destination' => $service['destination'],
                        'delayed' => $delayed,
                        'delayReason' => $service['delayReason']
                    ];
                })
                //->take(12)
                ->toArray();

            dump($trains);
    
            $this->tile->putData($configurationName, $trains);
        }

        $this->info('All done!');

        return Command::SUCCESS;
    }
}
