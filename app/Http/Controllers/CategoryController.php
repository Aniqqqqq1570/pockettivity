<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('categories', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        Auth::user()->categories()->create($this->validatedData($request));

        return redirect()->route('categories')->with('success', 'Kategori berhasil disimpan.');
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $category = $this->ownedCategory($category);
        $category->update($this->validatedData($request, $category));

        return redirect()->route('categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->ownedCategory($category)->delete();

        return redirect()->route('categories')->with('success', 'Kategori berhasil dihapus.');
    }

    private function ownedCategory(Category $category): Category
    {
        abort_unless((int) $category->user_id === (int) Auth::id(), 403);

        return $category;
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        $uniqueName = Rule::unique('categories', 'name')
            ->where('user_id', Auth::id());

        if ($category !== null) {
            $uniqueName->ignore($category->id);
        }

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                $uniqueName,
            ],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);
    }
}
