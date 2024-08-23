<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetStoreRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\DisableRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $company = Company::latest()->paginate(5);
          
        return view('companies.index', compact('company'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
       
        $transactionRoute = 'companies.store';
        $company = new Company();

        return view('companies.form',compact('transactionRoute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request):RedirectResponse
    {
        Company::create($request->validated());
           
        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Company $company):View
    {
        return view('companies.show',compact('company'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company):View
    {
        $transactionRoute = 'companies.update';
        return view('companies.form',compact('company','transactionRoute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyStoreRequest $request, Company $asset):RedirectResponse
    {
        $asset->update($request->validated());
          
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
           
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = Company::latest();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('contact_number', 'LIKE', "%{$search}%")
                    ->orWhere('location_coordinates', 'LIKE', "%{$search}%")
                    ->orWhere('country_code', 'LIKE', "%{$search}%")
                    ->orWhere('region_code', 'LIKE', "%{$search}%")
                    ->orWhere('municipality_code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ;
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, Company $company)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $company->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Company updated successfully',
                'item' => $company
            ]);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error updating item: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
