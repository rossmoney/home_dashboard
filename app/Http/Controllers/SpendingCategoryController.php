<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SpendingCategory;

class SpendingCategoryController extends Controller
{
    public function create()
    {
        $validated = request()->validateWithBag('category', [
            'name' => 'required|max:255',
        ]);

        $spending = SpendingCategory::create(request()->except('_token', '_method'));

        return redirect()->back()->withSuccess('Saved category.');
    }
}