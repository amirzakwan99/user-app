<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

/**
 * @OA\Info(
 *     title="User Management API",
 *     version="1.0.0",
 *     description="API documentation for managing users",
 *     @OA\Contact(email="support@example.com")
 * )
 *
 * @OA\Server(
 *     url="/",
 *     description="Local server"
 * )
 *
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for managing users"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     description="Returns list of users with optional status filter",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter users by status (0 = inactive, 1 = active, 2 = deleted)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
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
     * @OA\Get(
     *     path="/user/create",
     *     tags={"Users"},
     *     summary="Show form to create a new user",
     *     @OA\Response(response=200, description="Form returned")
     * )
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * @OA\Post(
     *     path="/user",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","phone_number","email","status","password"},
     *             @OA\Property(property="name", type="string", maxLength=50),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
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
     * @OA\Get(
     *     path="/user/{id}/edit",
     *     tags={"Users"},
     *     summary="Show form to edit a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of user to edit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User data returned"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function edit(int $id)
    {
        // $user = User::withTrashed()->findOrFail($id);
        $user = User::findOrFail($id);
        
        return view('user.edit', compact('user'));
    }

    /**
     * @OA\Put(
     *     path="/user/{id}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="User ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","phone_number","email","status","password"},
     *             @OA\Property(property="name", type="string", maxLength=50),
     *             @OA\Property(property="phone_number", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="status", type="integer"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User updated successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
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
     * @OA\Delete(
     *     path="/user/{id}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of user to delete"
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
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
     * @OA\Delete(
     *     path="/user/destroy-bulk",
     *     tags={"Users"},
     *     summary="Bulk delete users",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="ids", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(response=200, description="Users deleted successfully"),
     *     @OA\Response(response=422, description="No users selected")
     * )
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

    /**
     * @OA\Get(
     *     path="/user/export",
     *     tags={"Users"},
     *     summary="Export users to Excel",
     *     @OA\Response(response=200, description="Excel file download")
     * )
     */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
