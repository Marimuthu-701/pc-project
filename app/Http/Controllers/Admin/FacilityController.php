<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Facility;
use Flash;

class FacilityController extends Controller
{
    protected $guard = 'admin';

    /**
     * @param Datatables $datatable
     *
     * @return mixed
     */
    public function index(Request $request, Datatables $datatable)
    {
        if ($request->ajax()) {
            $facilities = Facility::get();
            return $this->datatable($facilities, $request);
        }

        return view('admin.facilities.index');
    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('name', function ($query) {
                return $query->name;
            })->addColumn('status', function ($query) {
                return ($query->status == Facility::STATUS_ACTIVE) ? trans('common.active') : trans('common.inactive');   
            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'facilities',
                    'disabled' => false,
                ]);
            })
            ->rawColumns(['action', 'checkbox', 'status', 'name'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $facilitiesStatus = Facility::getStatuses();
       
        return view('admin.facilities.create', compact('facilitiesStatus'));
    
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
            $ServiceData = Facility::create([
                'name' => $request->name,
                'status' => $request->status
            ]);
            Flash::success(trans('messages.facilities_success'));

            return redirect()->route('admin.facilities.index');

        } catch (\Exception $e) {
                Flash::error(trans('messages.facilities_error'));

                return redirect()->back()
                    ->withInput($request->all());
        }

    }

    /**
     * @param AdminUser $admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $facility = Facility::find($id);
        $facilitiesStatus = Facility::getStatuses();

        return view('admin.facilities.edit', compact('facility','facilitiesStatus'));
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
        $facility = Facility::find($id);
        $facility->name = $input['name'];
        $facility->status  = $input['status'];
        $facility->save();
        Flash::success(trans('messages.facilities_update'));

        return redirect()->route('admin.facilities.index');

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
        $service = Facility::where('id',$id)->delete();
        Flash::success(trans('messages.facilities_delete'));

        return back();
    }
    public function validator(array $data, $id="")
    {
        $rules = [
            'name'=>'required|unique:facilities,name,'.$id,
            'status'=> 'required',
        ];
        return Validator::make($data, $rules);
    }

}
