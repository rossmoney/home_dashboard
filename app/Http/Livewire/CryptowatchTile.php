<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Dashboard\Models\Tile;

class CryptowatchTile extends Component
{
    /** @var string */
    public $position;

    public $exchange = null;
    public $currencyPair = null;
    public $timePeriod = null;
    public $configuration = null;
    public $title = null;

    public function mount(
        string $position,
        ?string $configuration = 'default'
    )
    {
        $this->position = $position;
        $this->configuration = $configuration;
        $this->currencyPair = config('dashboard.tiles.cryptowatch.' . $configuration . '.currency_pair');
        $this->exchange = config('dashboard.tiles.cryptowatch.' . $configuration . '.exchange');
        $this->timePeriod = config('dashboard.tiles.cryptowatch.' . $configuration . '.time_period');
        $this->title = config('dashboard.tiles.cryptowatch.' . $configuration . '.title');
    }

    public function render()
    {
        $refreshInterval = (int) config('dashboard.tiles.cryptowatch.refresh_interval_in_seconds') ?? 60;

        $configuration = $this->configuration;
        $title = $this->title;
        $exchange = $this->exchange;
        $timePeriod = $this->timePeriod;
        $currencyPair = $this->currencyPair;

        //$data = Tile::firstOrCreateForName('crypto_watch')->getData($this->username);

        return view('tiles.cryptowatch-tile', compact('exchange', 'currencyPair', 'configuration', 'title', 'refreshInterval', 'timePeriod'));
    }
}