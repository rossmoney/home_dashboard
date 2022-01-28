<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Spend;

class SpendingTile extends Component
{
    /** @var string */
    public $position;

    public $configuration = null;
    public $title = null;

    public function mount(
        string $position,
        ?string $configuration = 'default'
    )
    {
        $this->position = $position;
        $this->configuration = $configuration;
        $this->title = config('dashboard.tiles.spending.' . $configuration . '.title');
    }

    public function render()
    {
        $refreshInterval = (int) config('dashboard.tiles.spending.refresh_interval_in_seconds') ?? 60;

        $configuration = $this->configuration;
        $title = $this->title;

        $currentMonth = config('app.current_month');

        list($categorySpending, $totals) = Spend::byCategory($currentMonth);

        return view('tiles.spending-tile', compact('title', 'refreshInterval', 'configuration', 'categorySpending', 'totals'));
    }
}