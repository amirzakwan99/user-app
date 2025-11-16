<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = User::withTrashed();
            $query = User::query();

            $status = $request->input('status');

            if ($status !== null && $status !== '') {
                $query->where('status', (int) $status);
            }
            // else {
            //     $query->withTrashed();
            // }

            return DataTables::of($query)
                ->addColumn('action', function ($user) {
                    $editUrl = route('user.edit', $user->id);
                    $deleteUrl = route('user.destroy', $user->id);
                    return view('partials.actions-buttons', compact('editUrl', 'deleteUrl'))->render();
                })
                ->addColumn('status_string', function ($user) {
                    switch ($user->status) {
                        case User::STATUS_ACTIVE:
                            return 'Active';
                            break;
                        case User::STATUS_INACTIVE:
                            return 'Inactive';
                            break;
                        case User::STATUS_DELETED:
                            return 'Deleted';
                            break;
                        default:
                            return 'Undefined';
                            break;
                    }
                })
                ->addColumn('checkbox', function ($user) {
                    $userId = $user->id;
                    return view('partials.checkbox', compact('userId'))->render();
                })
                ->editColumn('password', function ($user) {
                    return '••••••••••';
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone_number' => 'required|string|unique:users,phone_number',
            'email' => "required|email|unique:users,email",
            'status' => 'required|integer',
            'password' => 'required|string',
        ]);

        User::create($validated);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        // $user = User::withTrashed()->findOrFail($id);
        $user = User::findOrFail($id);
        
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone_number' => 'required|string|max:50',
            'email' => 'required|email',
            'status' => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'status' => User::STATUS_DELETED
        ]);

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    
    /**
     * Remove the specified resources from storage (bulk delete).
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->route('user.index')->with('error', 'No users selected for deletion.');
        }

        User::whereIn('id', $ids)->update(['status' => User::STATUS_DELETED]);
        User::whereIn('id', $ids)->delete();

        return redirect()->route('user.index')->with('success', 'Selected users deleted successfully.');
    }
}
