<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;
use Validator;
use Flash;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Service;
use App\Models\User;

class ServiceController extends Controller
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
            $services = Service::get();
            return $this->datatable($services, $request);
        }

        return view('admin.services.index');
    }

    protected function datatable($query, $request)
    {
        return Datatables::of($query)
            ->addColumn('id', function ($query) {
                return $query->id;
            })->addColumn('name', function ($query) {
                return $query->name;
            })->addColumn('description', function ($query) {
                return $query->description;
            })->addColumn('status', function ($query) {
                return ($query->status == Service::STATUS_ACTIVE) ? trans('common.active') : trans('common.inactive');   
            })->addColumn('is_featured', function ($query) {
                return ($query->is_featured == Service::IS_FEATURED) ? trans('common.verified') : trans('common.not_verified');
            })->addColumn('position', function ($query) {
                return $query->position;
            })->addColumn('slug', function ($query) {
                return $query->slug;
            })->addColumn('icon', function ($query) {
                $image = '';
                if ($query->icon) {
                    $orgiconUrl = storage_url(User::ICON_MEDIA_PATH.$query->icon);
                    $imageUlr = storage_url(User::ICON_MEDIA_PATH_SMALL.$query->icon);
                    $image ='<a href="'.$orgiconUrl.'" target="_blank"><img src="'.$imageUlr.'" alt="'.$query->icon.'"></a>';
                }
                return $image;
            })->addColumn('banner', function ($query) {
                $bannerImagurl = '';
                if ($query->banner) {
                    $orgbannerUrl = storage_url(User::BANNER_MEDIA_PATH_LARGE.$query->banner);
                    $bannerimage = storage_url(User::BANNER_MEDIA_PATH_SMALL.$query->banner);
                    $bannerImagurl ='<a href="'.$orgbannerUrl.'" target="_blank"><img src="'.$bannerimage.'" alt="'.$query->banner.'" width="100px"></a>';
                }
                return $bannerImagurl;
            })->addColumn('form_set', function ($query) {
                return $query->form_set;
            })->addColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('action', function ($query) {
                return view('admin.partials.action', [
                    'item' => $query,
                    'source' => 'services',
                    'delete' => false,
                    'show'=>true,
                ]);
            })
            ->rawColumns(['action', 'checkbox', 'status', 'name', 'icon', 'banner'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $servicesStatus = Service::getStatuses();
        $setFeatureList = Service::setFeatureList();
        $formset = Service::formSet();

        return view('admin.services.create', compact('servicesStatus', 'setFeatureList', 'formset'));
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
            return redirect()->back()->withInput($request->all())->withErrors($validator->errors());
        }
        try {
            $position  = $request->position ? $request->position : 0;
            $slug      = Str::slug($request->name, '-');
            $iconDir   = User::ICON_MEDIA_PATH;
            $bannerDir = User::BANNER_MEDIA_PATH;
            $icon_name = $this->imageUpload($request->icon_image, $iconDir);
            $banner_name = $this->imageUpload($request->banner_image, $bannerDir);
            $ServiceData = Service::create([
                'name'   => $request->name,
                'description'=> $request->description,
                'status' => $request->status,
                'is_featured'=>$request->featured,
                'position' => $position,
                'slug' => $slug,
                'icon'=> $icon_name,
                'banner'=> $banner_name,
                'form_set' => $request->form_set,
            ]);
            Flash::success(trans('messages.service_success'));

            return redirect()->route('admin.services.index');

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
        $service = Service::find($id);
        $bannerImage = storage_url(User::BANNER_MEDIA_PATH_SMALL . $service->banner);
        $iconImage = storage_url(User::ICON_MEDIA_PATH_SMALL . $service->icon);
        $largeBanner = storage_url(User::BANNER_MEDIA_PATH_LARGE . $service->banner);
        return view('admin.services.view', compact('service', 'bannerImage', 'iconImage', 'largeBanner'));
    }

    /**
     * @param AdminUser $admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $service = Service::find($id);
        $servicesStatus = Service::getStatuses();
        $setFeatureList = Service::setFeatureList();
        $formset = Service::formSet();
        $bannerImage = storage_url(User::BANNER_MEDIA_PATH_SMALL . $service->banner);
        $iconImage = storage_url(User::ICON_MEDIA_PATH_SMALL . $service->icon);
        $largeBanner = storage_url(User::BANNER_MEDIA_PATH_LARGE . $service->banner);
        return view('admin.services.edit',compact('service','servicesStatus', 'setFeatureList', 'bannerImage', 'iconImage', 'largeBanner', 'formset'));

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
            return redirect()->back()->withInput($input)->withErrors($validator->errors());
        }

        $position  = $input['position'] ? $input['position'] : 0;
        $slug      = Str::slug($input['name']);
        $service = Service::find($id);
        $service->name        = $request->name;
        $service->description = $request->description;
        $service->status      = $request->status;
        $service->is_featured = $request->featured;
        $service->position = $position;
        $service->slug = $slug;
        $service->form_set = $request->form_set;
        if($request->icon_image) {
            $icon_name = $this->imageUpload($request->icon_image, User::ICON_MEDIA_PATH, $service->icon);
            $service->icon = $icon_name;
        }
        if($request->banner_image) {
            $banner_name = $this->imageUpload($request->banner_image, User::BANNER_MEDIA_PATH, $service->banner);
            $service->banner = $banner_name;
        }
        $service->save();
        Flash::success(trans('messages.service_update'));

        return redirect()->route('admin.services.index');
        
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
        
        $service = Service::where('id',$id)->delete();
        Flash::success(trans('messages.service_delete'));
        return redirect()->route('admin.services.index');
    }

    public function validator(array $data, $id="")
    {
        $formset = Service::formSet();
        $rules = [
            'name'=>'required|unique:services,name,'.$id,
            'status'=> 'required',
            'form_set' => 'required|in:'.implode(',', $formset),
        ];
        return Validator::make($data, $rules);
    }

    public function imageUpload($filename, $storageDir, $old_file = null)
    {
        if ($filename) {
            $mediaTitle  = pathinfo($filename->getClientOriginalName(),PATHINFO_FILENAME);
            $mediaType   = getFileType($filename);
            $image_name  = getRandomFileName($filename);
            $compress    = $mediaType == 'image' ? true : false;
            $imageUpload = User::uploadFile($filename, $image_name, $storageDir, $compress);
            if ($old_file) {
                $oldimageName = $old_file;
                Storage::delete($storageDir.$oldimageName);
            }
            if ($imageUpload) {
                return $image_name;
            }
        }
    }
}
