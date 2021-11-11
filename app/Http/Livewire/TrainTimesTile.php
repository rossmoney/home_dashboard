<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Dashboard\Models\Tile;

class TrainTimesTile extends Component
{
    /** @var string */
    public $position;

    public $originStation = null;
    public $destinationStation = null;
    public $data = 'departures';
    public $configuration = null;
    public $title = null;

    public function mount(
        string $position,
        ?string $configuration = 'default'
    )
    {
        $this->position = $position;
        $this->configuration = $configuration;
        $this->originStation = config('dashboard.tiles.train_times.' . $configuration . '.origin_station');
        $this->destinationStation = config('dashboard.tiles.train_times.' . $configuration . '.destination_station');
        $this->data = config('dashboard.tiles.train_times.' . $configuration . '.data');
        $this->title = config('dashboard.tiles.train_times.' . $configuration . '.title');
    }

    public function render()
    {
        $refreshInterval = (int) config('dashboard.tiles.train_times.refresh_interval_in_seconds') ?? 60;

        $configuration = $this->configuration;
        $title = $this->title;
        $originStation = $this->originStation;
        $destinationStation = $this->destinationStation;
        $data = $this->data;

        $trains = collect(Tile::firstOrCreateForName('train_times')->getData($this->configuration));

        return view('tiles.train-times-tile', compact('originStation', 'destinationStation', 'data', 'title', 'refreshInterval', 'configuration', 'trains'));
    }
}