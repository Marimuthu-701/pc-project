<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;
//use App\DataTables\AdminDatatable;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    protected $guard = 'admin';

    /**
     * @param AdminDatatable $datatable
     *
     * @return mixed
     */
    public function index(Datatables $datatable)
    {
        //$users = AdminUser::get();
        //return Datatables::of($posts)->make();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $admin = new AdminUser;
        $admin = $admin->fill($request->validated());
        $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect()->route('admin.admins.index');
    }

    /**
     * @param AdminUser $admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AdminUser $admin)
    {
        $admin_user = Auth::guard($this->guard)->user();
        return view('admin.auth.edit', [
            'user' => $admin_user,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param AdminUser $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AdminUser $admin)
    {
        $input  = $request->all();
        $validator = $this->updateValidator($input);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($input)
                ->withErrors($validator->errors());
        }
        $admin = Auth::guard($this->guard)->user();
        $admin->first_name = $input['first_name'];
        $admin->last_name  = $input['last_name'];
        $admin->email      = $input['email'];

        if ($request->password != null) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        flash(trans('messages.admin_update'))->success();

        return redirect()->route('admin.profile.edit');
    }

    /**
     * @param Request $request
     * @param AdminUser $admin
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, AdminUser $admin)
    {
        $this->authorize('delete', $admin);
        $admin->delete();
        return back();
    }

    public function getProfile()
    {
        $user_id = Auth::user()->id;
        $user = AdminUser::find($user_id);
        return view('admin.profile', compact('user'));
    }

    protected function updateValidator(array $data)
    {
        $messages = [
            'prayer_category_id.required' => trans('auth.prayer_category_required'),
            'description.required'        => trans('auth.description_required'),
        ];
        $rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email',
        ];
        if ($data['password']) {
            $rules['password']         = 'min:5';
            $rules['confirm_password'] = 'required_with:password|same:password|min:5';
        }
        return Validator::make($data, $rules);
    }
}
