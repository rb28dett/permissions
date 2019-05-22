<?php

namespace RB28DETT\Permissions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use RB28DETT\Permissions\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Cache::forget('rb28dett_permissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rb28dett_permissions::index', ['permissions' => Permission::paginate(50)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Permission::class);

        return view('rb28dett_permissions::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        if (str_replace(' ', '', $request->slug) != $request->slug) {
            return redirect()->back()->withInput()->with('error', __('rb28dett_permissions::general.slug_cannot_contain_spaces'));
        }
        $this->validate($request, [
            'name'        => 'required|max:255',
            'slug'        => 'required|max:255|unique:rb28dett_permissions',
            'description' => 'required|max:500',
        ]);

        Permission::create($request->all());

        return redirect()->route('rb28dett::permissions.index')->with('success', __('rb28dett_permissions::general.permission_added'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \RB28DETT\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $this->authorize('update', Permission::class);

        return view('rb28dett_permissions::edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request              $request
     * @param \RB28DETT\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->authorize('update', Permission::class);

        if (str_replace(' ', '', $request->slug) != $request->slug) {
            return redirect()->back()->withInput()->with('error', __('rb28dett_permissions::general.slug_cannot_contain_spaces'));
        }
        $this->validate($request, [
            'name'        => 'required|max:255',
            'slug'        => 'required|max:255|unique:rb28dett_permissions,slug,'.$permission->id,
            'description' => 'required|max:500',
        ]);

        $permission->update($request->all());

        return redirect()->route('rb28dett::permissions.index')->with('success', __('rb28dett_permissions::general.permission_updated', ['id' => $permission->id]));
    }

    /**
     * Displays a view to confirm delete.
     *
     * @param \RB28DETT\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Permission $permission)
    {
        $this->authorize('delete', Permission::class);

        return view('rb28dett::pages.confirmation', [
            'method' => 'DELETE',
            'action' => route('rb28dett::permissions.destroy', ['permission' => $permission->id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request              $request
     * @param \RB28DETT\Permission\Models\Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Permission $permission)
    {
        $this->authorize('delete', Permission::class);
        $permission->delete();

        return redirect()->route('rb28dett::permissions.index')->with('success', __('rb28dett_permissions::general.permission_deleted', ['id' => $permission->id]));
    }
}
