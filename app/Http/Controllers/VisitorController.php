<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Visitor;
use App\Models\Website;
use App\Models\User;
use Illuminate\Validation\Rule;

class VisitorController extends Controller
{

    public function index()
    {
        $visitor = Visitor::with(['user', 'website'])->get();
        // dd($visitor);
        return view('admin.visitor.index', compact('visitor'));
    }

    public function getdata()
    {
        // Relationships ke saath data lao - YAHAN 'user' hai na ke 'users'
        $visitors = Visitor::with(['user', 'website'])
            ->select(['id', 'website_id', 'created_at']); // visitor_id hata diya kyunki exist nahi karta

        return DataTables::of($visitors)
            ->addIndexColumn()

            // Website name from relationship
            ->addColumn('website_name', function ($visitor) {
                if ($visitor->website) {
                    return '<strong>' . e($visitor->website->name) . '</strong>';
                }
                return '<span class="text-muted">N/A</span>';
            })

            // Email from user relationship
            ->addColumn('email', function ($visitor) {
                return $visitor->user->email ?? '<span class="text-muted">N/A</span>';
            })

            // Phone from user relationship
            ->addColumn('phone', function ($visitor) {
                return $visitor->user->phone ?? '<span class="text-muted">N/A</span>';
            })

            // Actions column
            ->addColumn('actions', function ($visitor) {
                return '
                <div class="dropdown">
                    <button type="button"
                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="' . route('admin.visitor.edit', $visitor->id) . '">
                            <i class="bx bx-edit me-2"></i> Edit
                        </a>
                        <form action="' . route('admin.visitor.destroy', $visitor->id) . '" method="POST" style="display:inline;">
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

            // Make sure HTML columns are raw
            ->rawColumns(['website_name', 'email', 'phone', 'actions'])
            ->make(true);
    }


    public function destroy($id)
    {
        try {
            $visitor = Visitor::findOrFail($id);

            // Optional: Delete related data if needed
            // $visitor->delete(); // Agar permanently delete karna hai

            $visitor->delete(); // Soft delete agar use kar rahe hain to

            return redirect()->route('admin.visitor')
                ->with('success', 'Visitor deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.visitor')
                ->with('error', 'Error deleting visitor: ' . $e->getMessage());
        }
    }

    /**
     * Alternative: API response ke liye (agar AJAX se delete kar rahe hain)
     */
    public function destroyAjax($id)
    {
        try {
            $visitor = Visitor::findOrFail($id);
            $visitor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Visitor deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting visitor: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $visitor = Visitor::with(['user', 'website'])->findOrFail($id);
        $users = User::all();
        $websites = Website::all();

        return view('admin.visitor.edit', compact('visitor', 'users', 'websites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $visitor = Visitor::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id',
        ]);

        try {
            $visitor->update([
                'user_id' => $validated['user_id'],
                'website_id' => $validated['website_id'],
            ]);

            return redirect()->route('admin.visitor')
                ->with('success', 'Visitor updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating visitor: ' . $e->getMessage())
                ->withInput();
        }
    }
}
