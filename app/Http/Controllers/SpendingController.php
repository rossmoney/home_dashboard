<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Spend;
use App\Models\SpendingCategory;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class SpendingController extends Controller
{
    public function index()
    {
        $spending = Spend::byMonth(date('m'))->get();
        $spendingCategories = SpendingCategory::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $totalRoss = Spend::byMonth(date('m'))->where('users.name', 'Ross')->sum('cost');
        $totalJack = Spend::byMonth(date('m'))->where('users.name', 'Jack')->sum('cost');

        $totals = collect([
            'jack' => $totalJack,
            'ross' => $totalRoss,
            'totalToRoss' => $totalRoss - $totalJack
        ]);

        return view('spending.index', compact('spending', 'spendingCategories', 'users', 'totals'));
    }

    public function create()
    {
        $validated = request()->validateWithBag('spending', [
            'desc' => 'required|max:255',
            'cost' => 'required|gt:0',
            'date' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);

        $spending = Spend::create(request()->except('_token', '_method'));

        return redirect()->back()->with(['success' => 'Saved Spend']);
    }
}
