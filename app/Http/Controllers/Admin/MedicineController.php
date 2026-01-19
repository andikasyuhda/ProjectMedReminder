<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of medicines
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $medicines = $query->withCount(['schedules as active_schedules_count' => function ($q) {
            $q->active();
        }])
        ->orderBy('name')
        ->paginate(15);

        // Get unique categories for filter
        $categories = Medicine::distinct()->pluck('category');

        return view('admin.medicines.index', compact('medicines', 'categories'));
    }

    /**
     * Show the form for creating a new medicine
     */
    public function create()
    {
        $categories = [
            'Antihipertensi',
            'ACE Inhibitor',
            'Calcium Channel Blocker',
            'Beta Blocker',
            'Diuretik',
            'ARB',
        ];

        $dosageForms = ['Tablet', 'Kapsul', 'Sirup', 'Injeksi', 'Suspensi'];

        return view('admin.medicines.create', compact('categories', 'dosageForms'));
    }

    /**
     * Store a newly created medicine
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'dosage_form' => ['required', 'string', 'max:50'],
            'strength' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'side_effects' => ['nullable', 'string'],
            'contraindications' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
        ]);

        $validated['code'] = Medicine::generateCode();

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil ditambahkan!');
    }

    /**
     * Display the specified medicine
     */
    public function show(Medicine $medicine)
    {
        $medicine->load(['schedules' => function ($query) {
            $query->active()->with('user');
        }]);

        return view('admin.medicines.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified medicine
     */
    public function edit(Medicine $medicine)
    {
        $categories = [
            'Antihipertensi',
            'ACE Inhibitor',
            'Calcium Channel Blocker',
            'Beta Blocker',
            'Diuretik',
            'ARB',
        ];

        $dosageForms = ['Tablet', 'Kapsul', 'Sirup', 'Injeksi', 'Suspensi'];

        return view('admin.medicines.edit', compact('medicine', 'categories', 'dosageForms'));
    }

    /**
     * Update the specified medicine
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'dosage_form' => ['required', 'string', 'max:50'],
            'strength' => ['required', 'string', 'max:50'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'side_effects' => ['nullable', 'string'],
            'contraindications' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Data obat berhasil diperbarui!');
    }

    /**
     * Remove the specified medicine
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->update(['is_active' => false]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dinonaktifkan.');
    }
}
