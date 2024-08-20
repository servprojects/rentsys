<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisableRequest;
use App\Http\Requests\ItemBrandStoreRequest;
use App\Http\Requests\LeadSourceStoreRequest;
use App\Models\ItemBrand;
use App\Models\LeadSource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Log;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $leadSource = LeadSource::latest()->paginate(5);
          
        return view('leadSource.index', compact('leadSource'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        $transactionRoute = 'lead-source.store';
        return view('leadSource.form',compact('transactionRoute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadSourceStoreRequest $request):RedirectResponse
    {
        LeadSource::create($request->validated());
           
        return redirect()->route('lead-source.index')
                         ->with('success', 'Lead Source created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadSource $leadSource):View
    {
        return view('leadSource.show',compact('leadSource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadSource $leadSource):View
    {
        $transactionRoute = 'lead-source.update';
        return view('leadSource.form',compact('leadSource','transactionRoute' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadSourceStoreRequest $request, LeadSource $leadSource)
    {
        $leadSource->update($request->validated());
          
        return redirect()->route('lead-source.index')
                        ->with('success','Lead Source updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadSource $leadSource)
    {
        $leadSource->delete();
           
        return redirect()->route('lead-source.index')
                        ->with('success','Lead Source deleted successfully');
    }

    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = LeadSource::latest();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('details', 'LIKE', "%{$search}%");
            });
        }

        $data = $query->paginate(10);

        // Return data as JSON response
        return response()->json($data);
    }

    public function restDisable(DisableRequest $request, LeadSource $leadSource)
    {
        try {
            $validatedData = $request->validated();
    
            $dataToUpdate = array_filter(
                $validatedData,
                function ($value) {
                    return $value !== null;
                }
            );
    
            $leadSource->update($dataToUpdate);
    
        
            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'item' => $leadSource
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
