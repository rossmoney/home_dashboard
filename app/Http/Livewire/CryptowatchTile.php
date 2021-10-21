<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Dashboard\Models\Tile;

class CryptowatchTile extends Component
{
    /** @var string */
    public $position;

    public $exchange = 'kraken';
    public $currencyPair = 'btcgbp';
    public $timePeriod = '4h';
    public $configuration = null;
    public $title = null;

    public function mount(
        string $position,
        ?string $configuration = 'default'
    )
    {
        $this->position = $position;
        $this->configuration = $configuration;
        $this->currencyPair = config('dashboard.tiles.cryptowatch.' . $configuration . '.currency_pair') ?? $this->currencyPair;
        $this->exchange = config('dashboard.tiles.cryptowatch.' . $configuration . '.exchange') ?? $this->exchange;
        $this->timePeriod = config('dashboard.tiles.cryptowatch.' . $configuration . '.time_period') ?? $this->timePeriod;
        $this->title = config('dashboard.tiles.cryptowatch.' . $configuration . '.title') ?? 'CryptoWatch Kraken BTC-GBP 4h';
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