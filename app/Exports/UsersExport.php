<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $col_data = array();
        $user = User::select('first_name', 'email', 'mobile_number', 'city', 'state','postal_code', 'status', 'created_at')
        		->whereType(User::TYPE_USER)->get();
        		if (count($user) > 0) {
            	foreach ($user as $key => $value) {
	                $col_data[$key]['first_name'] = $value->first_name;
	                $col_data[$key]['email'] = $value->email;
	                $col_data[$key]['mobile_number'] = $value->mobile_number;
	                $col_data[$key]['city'] = $value->city;
	                $col_data[$key]['state'] = $value->states ? $value->states->name : null ;
	                if ($value->status == User::STATUS_ACTIVE) {
	                    $status = trans('common.active');
	                } else if($value->status == User::STATUS_PENDING) {
	                    $status = trans('common.pending');
	                } else {
	                    $status = trans('common.inactive');
	                } 
	                $col_data[$key]['postal_code'] = $value->postal_code;
	                $col_data[$key]['status'] = $status;
	                $col_data[$key]['created_at'] = formatDateTime($value->created_at);
            }
       }
       return collect($col_data);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Mobile Number',
            'City',
            'State',
            'Postal Code',
            'Status',
            'Created'
        ];
    }
}
