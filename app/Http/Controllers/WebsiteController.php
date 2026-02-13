<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Website;
use Illuminate\Validation\Rule;

class WebsiteController extends Controller
{
    public function index()
    {
        $website = Website::all();
        // dd($website);
        return view('admin.website.index', compact('website') );
    }

    // public function getdata() // Changed from getUsers() to getdata()
    // {
    //     $website =  Website::with('user')->select(['id', 'name', 'domain']);

    //     return DataTables::of($website)
    //         ->addIndexColumn()
    //         ->addColumn('actions', function ($website) {
    //             return view('admin.website.partials.actions', compact('website'))->render();
    //         })
    //         ->rawColumns(['actions', 'logo'])
    //         ->make(true);
    // }

    public function getdata()
    {
        $websites = Website::select(['id', 'name', 'domain', 'created_at']);

        return DataTables::of($websites)
            ->addIndexColumn()
            ->addColumn('actions', function ($website) {
                return '
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="' . route('admin.website.edit', $website->id) . '">
                                <i class="bx bx-edit me-2"></i> Edit
                            </a>
                            <form action="' . route('admin.website.destroy', $website->id) . '" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure?\')">
                                    <i class="bx bx-trash me-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:websites,domain',
        ], [
            'domain.unique' => 'This domain name is already taken. Please choose a different one.'
        ]);

        // Format domain (add https:// if not present)
        $domain = $request->domain;
        // if (!preg_match('/^https?:\/\//', $domain)) {
        //     $domain = 'https://' . $domain;
        // }
        $validated['domain'] = $domain;

        Website::create($validated);

        return redirect()->route('admin.website')
            ->with('success', 'Website created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $website = Website::findOrFail($id);
        return view('admin.website.edit', compact('website'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $website = Website::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => [
                'required',
                'string',
                'max:255',
                Rule::unique('websites', 'domain')->ignore($website->id),
            ],
        ], [
            'domain.unique' => 'This domain name is already taken. Please choose a different one.'
        ]);

        // Format domain
        $domain = $request->domain;
        // if (!preg_match('/^https?:\/\//', $domain)) {
        //     $domain = 'https://' . $domain;
        // }
        $validated['domain'] = $domain;

        $website->update($validated);

        return redirect()->route('admin.website')
            ->with('success', 'Website updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $website = Website::findOrFail($id);
        $website->delete();

        return redirect()->route('admin.website')
            ->with('success', 'Website deleted successfully!');
    }
}
