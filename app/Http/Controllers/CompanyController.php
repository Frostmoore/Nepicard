<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.companies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'coordinates' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'points' => 'nullable|integer|min:0',
            'piva' => 'nullable|string|max:20',
            'cf' => 'nullable|string|max:20',
            'pec' => 'nullable|email|max:255',
            'codice_univoco' => 'nullable|string|max:20',
        ]);

        $pictures = [];
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $img) {
                if ($img->isValid()) {
                    $path = $img->store('companies', 'public');
                    $pictures[] = 'storage/' . $path;
                }
            }
        }

        Company::create(array_merge(
            $request->only([
                'name',
                'address',
                'coordinates',
                'website',
                'category',
                'email',
                'phone',
                'status',
                'points',
                'piva',
                'cf',
                'pec',
                'codice_univoco',
            ]),
            ['pictures' => $pictures]
        ));


        
        return redirect()->route('admin.companies.index')->with('success', 'Azienda creata.');
    }

    public function show(Company $company)
    {
        $categories = Category::all();
        return view('admin.companies.show', compact('company', 'categories'));
    }

    public function edit(Company $company)
    {
        $categories = Category::all();
        return view('admin.companies.edit', compact('company', 'categories'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'coordinates' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'points' => 'nullable|integer|min:0',
            'piva' => 'nullable|string|max:20',
            'cf' => 'nullable|string|max:20',
            'pec' => 'nullable|email|max:255',
            'codice_univoco' => 'nullable|string|max:20',
        ]);
        
        $company->update($request->only([
            'name',
            'address',
            'coordinates',
            'website',
            'category',
            'email',
            'phone',
            'status',
            'points',
            'piva',
            'cf',
            'pec',
            'codice_univoco',
        ]));
        

        $pictures = $request->input('existing_pictures', []);
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $img) {
                if ($img->isValid()) {
                    $path = $img->store('companies', 'public');
                    $pictures[] = 'storage/' . $path;
                }
            }
        }

        $company->update(array_merge(
            $request->except(['pictures', 'existing_pictures']),
            ['pictures' => $pictures]
        ));



        return redirect()->route('admin.companies.index')->with('success', 'Azienda aggiornata.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Azienda eliminata.');
    }
}

