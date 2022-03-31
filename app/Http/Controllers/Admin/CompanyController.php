<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('rowCompanies')) {
            $row = session('rowCompanies');
        } else {
            $row = 5;
        }

        $companies = DB::table('companies')->latest()->paginate($row);

        return view('admin.company.list', [
            'companies' => $companies
        ]);
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:5|max:100',
            'slug' => 'required|max:255|unique:companies',
            'email' => 'required|email|unique:companies',
            'logo' => 'required|image|dimensions:min_width=100,min_height=100|mimes:png|max:2024',
            'website' => 'required|min:5|max:255'
        ]);

        $extension = $request->file('logo')->getClientOriginalExtension();
        $logoname = $request->slug . '-' . time() . '.' . $extension;
        $request->file('logo')->storeAs('images/companies',  $logoname);

        $data = Company::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'email' => $validatedData['email'],
            'logo' => 'companies/' . $logoname,
            'website' => $validatedData['website'],
        ]);

        if ($data) {
            return redirect('/anm/companies')->with('succes', 'Company has been create successfully!');
        } else {
            return redirect('/anm/companies')->with('error', 'Company failed to add!');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', [
            'company' => $company
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required|min:5|max:100',
            'slug' => 'required|max:255|unique:companies,slug,' . $request->id,
            'email' => 'required|email|unique:companies,email,' . $request->id,
            'logo' => 'image|dimensions:min_width=100,min_height=100|mimes:png|max:2024',
            'website' => 'required|min:5|max:255'
        ]);

        if ($request->file('logo')) {
            if ($company->logo) {
                if (Storage::exists('images/' . $company->logo)) {
                    Storage::delete('images/' . $company->logo);
                }
            }

            $extension = $request->file('logo')->getClientOriginalExtension();
            $logoname = $request->slug . '-' . time() . '.' . $extension;
            $request->file('logo')->storeAs('images/companies',  $logoname);
            $logo = 'companies/' . $logoname;
        } else {
            $logo = $company->logo;
        }

        $data = Company::where('id', $validatedData['id'])
            ->update([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
                'email' => $validatedData['email'],
                'logo' => $logo,
                'website' => $validatedData['website'],
            ]);

        if ($data) {
            return redirect('/anm/companies')->with('succes', 'Company has been edited successfully!');
        } else {
            return redirect('/anm/companies')->with('error', 'Company failed to edit!');
        }
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            if (Storage::exists('images/' . $company->logo)) {
                Storage::delete('images/' . $company->logo);
            }
        }
        $data = Company::destroy($company->id);

        if ($data) {
            return redirect('/anm/companies')->with('succes', 'Company has been deleted successfully!');
        } else {
            return redirect('/anm/companies')->with('error', 'Company not found!');
        }
    }

    public function checkslug(Request $request)
    {
        if ($request->ajax()) {
            $slug = SlugService::createSlug(Company::class, 'slug', $request->name);

            return response()->json(['slug' => $slug]);
        }
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $companies = DB::table('companies')
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('website', 'like', '%' . $request->search . '%')
                ->latest()
                ->paginate($request->row);

            session(['rowCompanies' => $request->row]);

            return view('admin.company.listAjax', ['companies' => $companies])->render();
        }
    }
}
