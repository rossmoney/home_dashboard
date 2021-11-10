<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Spend as This;
use App\Models\SpendingCategory;

use Carbon\Carbon;

class Spend extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'desc', 'date', 'cost', 'category_id', 'user_id', 'installment', 'end_date'
    ];

    public static function byMonth(int $month)
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();

        return This::select('spends.id', 'spends.installment', DB::raw('IF(spends.user_id = 2, (spends.cost * -1), spends.cost) AS cost'), 'date', 'desc', 'users.name as user', 'spending_categories.name as category')
            ->where(function ($query) use ($startMonth, $endMonth) {
                $query->whereBetween('date', [$startMonth, $endMonth])
                      ->orWhere('end_date', '>=', $endMonth);
            })
            ->leftJoin('users', 'users.id', '=', 'spends.user_id')
            ->leftJoin('spending_categories', 'spending_categories.id', '=', 'spends.category_id')
            ->orderBy('date');
    }

    public static function byCategory(int $month)
    {
        $categorySpends = [];

        foreach (SpendingCategory::orderBy('recurrent', 'DESC')->orderBy('name')->get() as $category)
        {
            //$spendsJack = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Jack');
            $spendsRoss = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Ross');
            $totalJack = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Jack')->sum('cost');
            $totalRoss = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Ross')->sum('cost');

            if ($totalJack + $totalRoss == 0) {
                continue;
            }

            $categorySpends[$category->name]['Total'] = This::byMonth($month)->where('category_id', $category->id)->get()->sum('cost');

            $categorySpends[$category->name]['Jack'] = ($totalJack > 0) ? '&pound;' . $totalJack : '-';
            $categorySpends[$category->name]['Ross'] = ($totalRoss > 0) ? '&pound;' . $totalRoss : '-';

            if ($category->show_all)
            {
                $jack = $ross = '';

                /*foreach ($spendsJack->get() as $spend)
                {
                }*/

                foreach ($spendsRoss->get()->sortBy('when_date') as $spend)
                {
                    $jack .= '<span style="float: left;">' . $spend->desc . '</span><span style="float: right;">' . $spend->when_day . '</span><br>';
                    $ross .= '<span>&pound;' . $spend->cost . '</span><br>';
                }

                $categorySpends[$category->name]['Jack'] = $jack;
                $categorySpends[$category->name]['Ross'] = $ross;
            }

            $categorySpends[$category->name]['Recurrent'] = $category->recurrent;
        }

        return collect($categorySpends);
    }

    public function getWhenAttribute()
    {
        $day = date("d", strtotime($this->date));
        return $day . '/' . date('m');
    }

    public function getWhenDayAttribute()
    {
        return date("jS", strtotime($this->date));
    }

    public function getWhenDateAttribute()
    {
        $day = date("d", strtotime($this->date));
        return date('Y') . '-'. date('m') . '-' . $day;
    }
}
