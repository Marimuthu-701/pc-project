<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\AdminUser;
use App\Models\Testimonial;
use App\Models\User;
use DataTables;
use Validator;
use Flash;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Datatables $datatable)
    {
        if ($request->ajax()) {
            $services = Testimonial::get();
            return $this->datatable($services, $request);
        }
        return view('admin.testimonials.index');
    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('name', function ($query) {
                return $query->name;
            })->addColumn('email', function ($query) {
                return $query->email;   
            })->addColumn('description', function ($query) {
                return Str::limit($query->description, 100, '...');
            })->addColumn('rating', function ($query) {
                return $query->rating;
            })->addColumn('address', function ($query) {
                return $query->address;
            })->addColumn('status', function ($query) {
                $approval_status = $query->status;
                $view_path = 'approve';
                if ($approval_status == User::STATUS_PENDING) {
                        return view('admin.partials.action', [
                        'item' => $query,
                        'source' => 'testimonials',
                        'approval' => true,
                        'approval_path'=> $view_path,
                    ]);
                } elseif($approval_status == User::STATUS_ACTIVE){
                    return 'Approved';
                }else {
                    return '-';
                }
            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'testimonials',
                    'disabled' => false,
                    'show'=> true,
                ]);
            })
            ->rawColumns(['action', 'status', 'name'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        try {
            $ServiceData = Testimonial::create([
                'name' => $request->name,
                'description'=> $request->description,
                'email' => $request->email,
                'address'=>$request->address,
                'rating' => $request->rating,
                'status' => 2,
            ]);
            Flash::success(trans('messages.testimonials_success'));
            return redirect()->route('admin.testimonials.index');
        } catch (\Exception $e) {
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back()->withInput($request->all());
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
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.view', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input  = $request->all();
        $validator = $this->validator($input, $id);
        if ($validator->fails()) {
            return redirect()->back()->withInput($input)->withErrors($validator->errors());
        }
        try {
            $testimonial = Testimonial::find($id);
            $testimonial->name = $request->name;
            $testimonial->description = $request->description;
            $testimonial->email = $request->email;
            $testimonial->address = $request->address;
            $testimonial->rating = $request->rating;
            $testimonial->save();
            Flash::success(trans('messages.testimonials_update'));
            return redirect()->route('admin.testimonials.index');

        } catch (\Exception $e) {
            Flash::error(trans('messages.something_wrong'));
            return redirect()->back()->withInput($request->all());
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id',$id)->delete();
        Flash::success(trans('messages.testimonials_delete'));
        return redirect()->route('admin.testimonials.index');
    }

    public function validator(array $data)
    {
        $rules = [
            'name'=>'required',
            'description'=> 'required',
            'address'=> 'required',
        ];
        return Validator::make($data, $rules);
    }

    public function testmonialApproval($id)
    {
        $testmonial = Testimonial::find($id);
        $testmonial->status = User::STATUS_ACTIVE;
        if ($testmonial->save()) {
            Flash::success(trans('messages.testimonial_approvel_msg'));
            return redirect()->route('admin.testimonials.index');
        }
        return redirect()->back()->withInput($input);
    }
}
