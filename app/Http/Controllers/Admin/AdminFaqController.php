<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->orderBy('category_id')->orderBy('order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::orderBy('order')->get();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ succesvol aangemaakt.');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::orderBy('order')->get();
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'order' => ['required', 'integer', 'min:0'],
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ succesvol bijgewerkt.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ succesvol verwijderd.');
    }
}
