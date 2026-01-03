<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class AdminFaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::orderBy('order')->get();
        return view('admin.faq-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        FaqCategory::create($request->all());

        return redirect()->route('admin.faq-categories.index')
            ->with('success', 'Categorie succesvol aangemaakt.');
    }

    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.faq-categories.edit', compact('faqCategory'));
    }

    public function update(Request $request, FaqCategory $faqCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        $faqCategory->update($request->all());

        return redirect()->route('admin.faq-categories.index')
            ->with('success', 'Categorie succesvol bijgewerkt.');
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();

        return redirect()->route('admin.faq-categories.index')
            ->with('success', 'Categorie succesvol verwijderd.');
    }
}
