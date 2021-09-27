<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Models\AdminUser;
use Illuminate\Http\Request;
//use App\DataTables\AdminDatatable;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Validator;
use Flash;
use Excel;


class UserController extends Controller
{
    protected $guard = 'admin';

    /**
     * @param AdminDatatable $datatable
     *
     * @return mixed
     */
    public function index(Datatables $datatable, Request $request)
    {
        $userStatus = User::getStatuses();
        $cities = City::all();
        $states = State::all();
        $created_form = isset($request->created_from) ? mysqlDateFormat($request->created_from) : null;
        $created_to   = isset($request->created_to) ? mysqlDateFormat($request->created_to) : null;
        $updated_from = isset($request->updated_from) ? mysqlDateFormat($request->updated_from) : null;
        $updated_to   = isset($request->updated_to) ? mysqlDateFormat($request->updated_to) : null;
        $users = User::where('type', User::TYPE_USER);
        if ($request->ajax()) {
            if($created_form && $created_to) {
                $from = $created_form;
                $to   = $created_to;
            } else if ($created_form) {
                $from = $created_form;
                $to   = $created_form;
            } else if ($created_to) {
                $from = $created_to;
                $to   = $created_to;
            }

            if(isset($from) && isset($to)) {
                $whereDate ='DATE(created_at) BETWEEN  "'.$from.'"  AND  "'.$to.'"';
                $users = $users->whereRaw($whereDate);
            }

            if ($updated_from && $updated_to) {
                $update_from = $updated_from;
                $update_to   = $updated_to;
            } else if($updated_from) {
                $update_from = $updated_from;
                $update_to   = $updated_from;
            } else if($updated_to) {
                $update_from = $updated_to;
                $update_to   = $updated_to;
            }

            if (isset($update_from) && $update_to) {
                $whereUpdatedDate ='DATE(updated_at) BETWEEN  "'.$update_from.'"  AND  "'.$update_to.'"';
                $users = $users->whereRaw($whereUpdatedDate);
            }
            if ($request->name) {
                $users = $users->where('first_name', 'LIKE', '%'.$request->name.'%');
            }
            if ($request->email) {
                $users = $users->where('email', $request->email);
            }
            if ($request->mobile_number) {
                $users = $users->where('mobile_number', $request->mobile_number);   
            }
            if ($request->state) {
                $users = $users->where('state', 'LIKE', '%'.$request->state.'%');
            }
            if ($request->city) {
                $users = $users->where('city', 'LIKE', '%'.$request->city.'%');
            }
            if ($request->postal_code) {
                $users = $users->where('postal_code', $request->postal_code);
            }
            if (($request->status || $request->status == 0) && $request->status!='') {
                $users = $users->where('status', $request->status);   
            }
            $users = $users->get();
            return $this->datatable($users, $request);
        }

        return view('admin.users.index', compact('userStatus', 'cities', 'states'));
    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('first_name', function ($query) {
                return $query->first_name;
            })->addColumn('email', function ($query) {
                return $query->email;
            })->addColumn('mobile_number', function ($query) {
                return $query->mobile_number;
            })->addColumn('city', function ($query) {
                return $query->city;
            })->addColumn('state', function ($query) {
                $state = isset($query->states) ? $query->states->name : null;
                return $state;
            })->addColumn('postal_code', function ($query) {
                return $query->postal_code;
            })->addColumn("status", function ($query) {

                if ($query->status == User::STATUS_ACTIVE) {
                    return $query->status = trans('common.active');   
                } elseif ($query->status == User::STATUS_PENDING) {
                    return $query->status = trans('common.pending');   
                } else {
                    return $query->status = trans('common.inactive');   
                }

            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('updated_at', function ($query) {
                return $query->updated_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'users',
                    'disabled' => false,
                    'show'=> true,
                ]);
            })
            ->rawColumns(['action', 'checkbox', 'status', 'email'])
            ->make(true);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $userStatus = User::getStatuses();

        return view('admin.users.create', [
            'userStatus' => $userStatus 
            ]);
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator->errors());
        }
        try {
                $userData = User::create([
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'password'      => !empty($request->password) ? bcrypt($request->password) : '',
                    'type'          => 'user',
                    'status'        => $request->status
                ]);

                Flash::success(trans('messages.user_success'));

                return redirect()->route('admin.users.index');

        } catch (\Exception $e) {
                Flash::error(trans('messages.user_error'));

                return redirect()->back()
                    ->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.view', compact('user'));
    }

    /**
     * @param AdminUser $admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $userStatus = User::getStatuses();
        $users = User::find($id);
        $states = State::all();
        $cities = City::where('state', $users->state)->get();
        return view('admin.users.edit', compact('users', 'userStatus', 'states', 'cities'));
    }

    /**
     * @param UpdateRequest $request
     * @param AdminUser $admin
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $input  = $request->all();
        $validator = $this->validator($input, $id);
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($input)
                ->withErrors($validator->errors());
        }
        
        $user = User::find($id);
        $user->first_name = $input['first_name'];
        $user->last_name  = $input['last_name'];
        $user->email  = $input['email'];
        $user->mobile_number  = $input['mobile_number'];
        $user->state  = $input['state'];
        $user->city  = $input['city'];
        $user->postal_code  = $input['postal_code'];
        if ($input['password'] != null) {
            $user->password = bcrypt($input['password']);
        }
        $user->save();

        Flash::success(trans('messages.user_update'));

        return redirect()->route('admin.users.index');

    }

    /**
     * @param Request $request
     * @param AdminUser $admin
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $service = User::where('id',$id)->delete();
        Flash::success(trans('messages.user_delete'));
        return redirect()->route('admin.users.index');
    }

    protected function validator(array $data, $id="")
    {
        $rules = [
            'email'     => 'nullable|email|max:255|unique:users,email,'.$id,
            'first_name' => 'required|max:32',
            'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'city'=>'required',
            'state'=>'required',
            'postal_code'=>'required',
            'status'=> 'required'
        ];
        if($data['password'] != '') {
            $passwordValidation = [
                'confirm_password' => 'required_with:password|same:password',
                'password'  => 'required|min:6',
            ]; 
            $rules = array_merge($rules , $passwordValidation);
        }
            

        return Validator::make($data, $rules);
    }

    public function usersExport()
    {
        return Excel::download(new UsersExport, trans('admin.users').'.xlsx');
    }
}
