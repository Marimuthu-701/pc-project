<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\PartnerService;
use App\Models\User;


class PartnerServiceExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {	
    	$col_data = array();
     	$partner_service = PartnerService::get();
     	if( count($partner_service) > 0) {
     		foreach ($partner_service as $key => $value) {
     			$col_data[$key]['emal'] = isset($value->user) ? $value->user->email : null;
     			$col_data[$key]['mobile_number'] = isset($value->user) ? $value->user->mobile_number : null;
     			$col_data[$key]['name'] = $value->name;
     			$col_data[$key]['service_type'] = isset($value->service) ? $value->service->name : null;
     			$col_data[$key]['registration_number'] = $value->registration_number;
     			$col_data[$key]['contact_person'] = $value->contact_person;
     			$col_data[$key]['contact_phone'] = $value->contact_phone;
     			$col_data[$key]['contact_email'] = $value->contact_email;
     			$dobConvert = null;
			    if(isset($value->dob) && !empty($value->dob)) {
			        $dobConvert = date('d-m-Y',strtotime($value->dob));
			    }
     			$col_data[$key]['dob'] = $dobConvert;
     			$col_data[$key]['gender'] = $value->gender ? ucfirst($value->gender) : null;
     			$col_data[$key]['id_proof'] = $value->id_proof ? ucfirst(str_replace('_', ' ', $value->id_proof)) : null;
     			$col_data[$key]['qualification'] = $value->qualification;
     			$col_data[$key]['working_at'] = $value->working_at;
     			$col_data[$key]['specialization_area'] = $value->specialization_area;
     			$col_data[$key]['total_experience'] = $value->total_experience;
     			
			    $fees_type = null;
			    $fees_amount = null;
			    if(isset($value->fees_per_shift) && !empty($value->fees_per_shift)) {
			        $fees_type = PartnerService::FEE_PER_SHIFT;
			        $fees_amount = $value->fees_per_shift;
			    } else if (isset($value->fees_per_day) && !empty($value->fees_per_day)) {
			        $fees_type = PartnerService::FEE_PER_DAY;
			        $fees_amount = $value->fees_per_day;
			    }
     			$col_data[$key]['fees'] = $fees_amount.' '.$fees_type;
     			$col_data[$key]['no_of_rooms'] = $value->no_of_rooms;
     			$col_data[$key]['room_rent'] = $value->room_rent;
     			$facilities = '';
     			if(!empty($value->partnerServiceFacilities)) {
     				foreach ($value->partnerServiceFacilities as $facility) {
                		$facilities .= $facility['name'].', ';
            		}
     			}
     			$facilities = trim($facilities,', ');
     			$col_data[$key]['available_facility'] = $facilities;
     			$col_data[$key]['other_facilities'] = $value->other_facilities;
     			$col_data[$key]['additional_info'] = $value->additional_info;
     			$col_data[$key]['website_link'] = $value->website_link;
     			$col_data[$key]['services_provided'] = $value->services_provided;
     			$col_data[$key]['tests_provided'] = $value->tests_provided;
     			$col_data[$key]['project_name'] = $value->project_name;
     			if ($value->status == User::STATUS_ACTIVE) {
     				$status = 'Approved';
     			} else if ($value->status == User::STATUS_PENDING) {
     				$status = 'Not Approved';
     			}
     			$col_data[$key]['status'] = $status;
     			$featured = '';
     			$featureFrom = null;
     			$featureTo = null;

                if (isset($value->featured_from) && !empty($value->featured_from)) {
                    $featureFrom = date('d-m-Y', strtotime($value->featured_from));
                }
                if (isset($value->featured_to) && !empty($value->featured_to)) {
                    $featureTo = date('d-m-Y', strtotime($value->featured_to));
                }
                if ($featureFrom && $featureTo) {
                	$featured = $featureFrom.' to '.$featureTo;
                } else if ($featureFrom) {
                	$featured = $featureFrom;
                } else if($featureTo) {
                	$featured = $featureTo;
                }

     			$col_data[$key]['featured'] = $featured;
     			$col_data[$key]['verified'] = $value->verified == User::VERIFIED ? trans('common.verified') : trans('common.not_verified');
     			$col_data[$key]['address'] = $value->address;
     			$col_data[$key]['city'] = $value->city;
     			$col_data[$key]['state'] = isset($value->states) ? $value->states->name : null;
     			$col_data[$key]['postal_code'] = $value->postal_code;
     			$col_data[$key]['created_at'] =  formatDateTime($value->created_at);
     		}
     	}
     	return collect($col_data);
    }

    public function headings(): array
    {
        return [
            'Email',
			'Mobile Number',
			'Name',
			'Service Type',
			'Registration Number',
			'Contact Person',
			'Contact Phone No',
			'Contact Email',
			'Date Of Birth',
			'Gender',
			'Id Proof',
			'Qualification',
			'Currently Working At',
			'Area of Specialization',
			'Years of experience',
			'Fees (Rs.)',
			'Number Of Rooms',
			'Room Rent (Rs.)',
			'Facilities Available',
			'Other Facilities Available',
			'Additional Information',
			'Website Link',
			'Service Provided',
			'List of Tests Provided',
			'Project Name',
			'Approved Status',
			'Featured',
			'Verified',
			'Address',
			'City',
			'State',
			'Postal Code',
			'Created',
        ];
    }
}
