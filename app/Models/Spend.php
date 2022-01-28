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

    public static function byMonth(int $month, bool $wholeMonth = true)
    {
        $currentYear = config('app.current_year');

        $startMonth = Carbon::parse($currentYear .'-'. $month .'-01')->startOfMonth();
        $endMonth = Carbon::parse($currentYear .'-'. $month .'-01')->endOfMonth();
        
        $endDay = $endMonth->format('d');
        if (!$wholeMonth) { 
            if (date("m") < $month) {
                $endDay = '01'; //month hasn't started ye
            }
            $endDay = date("d");
            $endMonth = Carbon::parse($currentYear. "-".$month."-". $endDay);
        }

        return This::select('spends.id', 'spends.end_date', 'spends.installment', DB::raw('IF(spends.user_id = 2, (spends.cost * -1), spends.cost) AS cost'), 'date', 'desc', 'users.name as user', 'spending_categories.name as category')
            ->where(function ($query) use ($startMonth, $endMonth, $endDay) {
                $query->where(function ($query) use ($startMonth, $endMonth, $endDay) {
                $query->where('date', '<=', $endMonth)
                      //->where('date', '>=', $startMonth)
                      ->where('end_date','>=', $startMonth) //permanent installment like bills
                      ->whereDay('date', '<=', $endDay);
                }) 
                ->orWhereBetween('date', [$startMonth, $endMonth]); //short term installments
            })
            ->leftJoin('users', 'users.id', '=', 'spends.user_id')
            ->leftJoin('spending_categories', 'spending_categories.id', '=', 'spends.category_id')
            ->orderBy('date');
    }

    public static function byCategory(int $month)
    {
        $categorySpends = [];
        $totals = ['jack' => 0, 'ross' => 0,'totalToRoss' => 0];

        foreach (SpendingCategory::orderBy('recurrent', 'DESC')->orderBy('name')->get() as $category)
        {
            //$spendsJack = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Jack');
            $spendsRoss = This::byMonth($month, false)->where('category_id', $category->id)->where('users.name', 'Ross');
            $totalJack = This::byMonth($month, false)->where('category_id', $category->id)->where('users.name', 'Jack')->sum('cost');
            $totalRoss = This::byMonth($month, false)->where('category_id', $category->id)->where('users.name', 'Ross')->sum('cost');
            if ($totalJack + $totalRoss == 0) {
                continue;
            }
            $totals['jack'] += $totalJack;
            $totals['ross'] += $totalRoss;
            $totals['totalToRoss'] += ($totalRoss + $totalJack);

            $categorySpends[$category->name]['Total'] = ($totalRoss + $totalJack > 0) ? $totalRoss+$totalJack : 0;

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

        return [$categorySpends, $totals];
    }

    public function getWhenAttribute()
    {
        $day = date("d", strtotime($this->date));
        return $day . '/' . config('app.current_month');
    }

    public function getWhenDayAttribute()
    {
        return date("jS", strtotime($this->date));
    }

    public function getWhenDateAttribute()
    {
        $day = date("d", strtotime($this->date));
        return config('app.current_year') .'-'. config('app.current_month') . '-' . $day;
    }
}
