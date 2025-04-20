<?php

namespace App\Http\Controllers;

use App\Models\GuideCategory;
use Illuminate\Http\Request;

class GuideCategoryController extends Controller
{
    protected function middleware(): array
    {
        return [
            'permission:guide-categories.index' => ['only' => ['index']],
            'permission:guide-categories.store' => ['only' => ['store']],
            'permission:guide-categories.update' => ['only' => ['update']],
            'permission:guide-categories.destroy' => ['only' => ['destroy']],
        ];
    }

    public function index()
    {
        $guideCategories = GuideCategory::all();
        return view('guides.categories', compact('guideCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        GuideCategory::create(['name' => $request->name]);

        return back()->with('success', 'Gid Kategoriyasi qo‘shildi.');
    }

    public function update(Request $request, GuideCategory $guideCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $guideCategory->update($validated);

        return back()->with('success', 'Yangilandi!');
    }

    public function destroy(GuideCategory $guideCategory)
    {
        $guideCategory->delete();

        return back()->with('success', 'O‘chirildi!');
    }

}
