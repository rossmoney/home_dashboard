<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use App\Models\Spend as This;
use App\Models\SpendingCategory;

class Spend extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'desc', 'date', 'cost', 'category_id', 'user_id'
    ];

    public static function byMonth(int $month)
    {
        return This::select(DB::raw('IF(spends.user_id = 2, (spends.cost * -1), spends.cost) AS cost'), 'date', 'desc', 'users.name as user', 'spending_categories.name as category')
            ->whereMonth('date', '=', $month)
            ->whereYear('date', '=', date('Y'))
            ->leftJoin('users', 'users.id', '=', 'spends.user_id')
            ->leftJoin('spending_categories', 'spending_categories.id', '=', 'spends.category_id')
            ->orderBy('date');
    }

    public static function byCategory(int $month)
    {
        $categorySpends = [];

        foreach (SpendingCategory::orderBy('recurrent', 'DESC')->orderBy('name')->get() as $category)
        {
            $categorySpends[$category->name]['Total'] = This::byMonth($month)->where('category_id', $category->id)->get()->sum('cost');
            $categorySpends[$category->name]['Jack'] = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Jack')->sum('cost');
            $categorySpends[$category->name]['Ross'] = This::byMonth($month)->where('category_id', $category->id)->where('users.name', 'Ross')->sum('cost');
        }

        return collect($categorySpends);
    }
}
