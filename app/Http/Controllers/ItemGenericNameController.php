<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemGenericNameStoreRequest;
use App\Models\ItemGenericName;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemGenericNameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $itemGenericName = ItemGenericName::latest()->paginate(5);
          
        return view('itemGenericName.index', compact('itemGenericName'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('itemGenericName.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemGenericNameStoreRequest $request):RedirectResponse
    {
        ItemGenericName::create($request->validated());
           
        return redirect()->route('item-generic-name.index')
                         ->with('success', 'Item Generic Name created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemGenericName $itemGenericName):View
    {
        return view('itemGenericName.show',compact('itemGenericName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemGenericName $itemGenericName):View
    {
        return view('itemGenericName.edit',compact('itemGenericName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemGenericNameStoreRequest $request, ItemGenericName $itemGenericName):RedirectResponse
    {
        $itemGenericName->update($request->validated());
          
        return redirect()->route('item-generic-name.index')
                        ->with('success','Item Generic Name updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemGenericName $itemGenericName)
    {
        $itemGenericName->delete();
           
        return redirect()->route('item-generic-name.index')
                        ->with('success','Item Generic Name deleted successfully');
    }

    // api
    public function getAllData(Request $request)
    {
        $search = $request->input('search');

        $query = ItemGenericName::latest();

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
}
