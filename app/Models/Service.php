<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'description', 
    	'status',
        'is_featured',
        'position',
        'slug',
        'icon',
        'banner',
        'form_set',
    ];

    // Service status values
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const DEFAULT = 0;
    const IS_FEATURED = 1;

    // Service form types
    const FORM_SET_1 = 'form1';
    const FORM_SET_2 = 'form2';
    const FORM_SET_3 = 'form3';
    const FORM_SET_4 = 'form4';
    const FORM_SET_5 = 'form5';
    const FORM_SET_6 = 'form6';

    // Service provider dynamic form set
    static function formSet()
    {
        return [
            self::FORM_SET_1 => self::FORM_SET_1,
            self::FORM_SET_2 => self::FORM_SET_2,
            self::FORM_SET_3 => self::FORM_SET_3,
            self::FORM_SET_4 => self::FORM_SET_4,
            self::FORM_SET_5 => self::FORM_SET_5,
            self::FORM_SET_6 => self::FORM_SET_6,
        ];
    }

    static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => trans('common.active'),
            self::STATUS_INACTIVE => trans('common.inactive')
        ];
    }

    static function setFeatureList()
    {
        return [
            self::IS_FEATURED => trans('common.verified'),
            self::DEFAULT => trans('common.not_verified'),
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope('position', function (Builder $builder) {
            $builder->orderBy('position', 'asc');
        });
    }

}
