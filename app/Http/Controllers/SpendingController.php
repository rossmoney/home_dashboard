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
        $currentMonth = config('app.current_month');
        $currentYear = config('app.current_year');

        $monthStart = $currentDate = $currentYear . '-' . $currentMonth . '-01';
        if (strtotime($currentDate) < strtotime('now'))
        {
            $currentDate = date('Y-m-d');
        }

        $minInstallmentEndDate = date('Y-m-d', strtotime("+2 months", strtotime( $currentDate) ));

        $spending = Spend::byMonth($currentMonth)->get();
        $spendingCategories = SpendingCategory::orderBy('name')->whereNotIn('id', [14])->get(); //not bills or windows
        $users = User::orderBy('name')->get();

        $totalRoss = Spend::byMonth($currentMonth)->where('users.name', 'Ross')->sum('cost');
        $totalJack = Spend::byMonth($currentMonth)->where('users.name', 'Jack')->sum('cost');

        $totals = collect([
            'jack' => $totalJack,
            'ross' => $totalRoss,
            'totalToRoss' => $totalRoss - $totalJack
        ]);

        list($categorySpending, $categoryTotals) = Spend::byCategory($currentMonth);

        return view('spending.index', compact('spending', 'spendingCategories', 'users', 'totals', 'currentMonth', 'currentDate', 'monthStart', 'minInstallmentEndDate', 'categorySpending', 'categoryTotals'));
    }

    public function create()
    {
        $validated = request()->validateWithBag('spending', [
            'desc' => 'required|max:255',
            'cost' => 'required|gt:0',
            'date' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'end_date' => 'sometimes|required_with:installment'
        ]);

        $spending = Spend::create(request()->except('_token', '_method'));

        return redirect()->back()->withSuccess('Saved spend.');
    }
    
    public function destroy(Spend $spending)
    {
        $spending->delete();

        return redirect()->back()->withSuccess('Spend deleted.');
    }
}
