@extends('admin.layouts.app')
@section('title', 'Profile')
@section('plugins.Datatables', true)
@section('plugins.Validation', true)
@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ trans('common.users') }}</h1>
        @include('admin.partials.breadcrumbs', ['breadcrumbs' => [
            trans('common.users')=> route('admin.users.index'),
            trans('common.view'),
        ]])
    </div>
    <div class="col-md-6 text-right">
        <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}">{{ trans('common.edit') }}</a>&nbsp;
        <a class="btn btn-primary" href="{{ route('admin.users.index') }}">{{ trans('common.view') }}</a>&nbsp;
        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="list-inline-item item-delete-form">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
    </div>
</div>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">          
        @include('flash::message')
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 profile_container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('common.users') }}</h3>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ trans('auth.name') }}</label>
                                        <div>{{ $user->first_name }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}</label>
                                        <div>{{ $user->email }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile_number">{{ trans('auth.mobile') }}</label>
                                        <div>{{ $user->mobile_number }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile_number">{{ trans('auth.status') }}</label>
                                        @if ($user->status == App\Models\User::STATUS_ACTIVE)
                                            <div>{{ trans('common.active') }}</div>
                                        @elseif ($user->status == App\Models\User::STATUS_PENDING)
                                            <div>{{ trans('common.pending') }}</div>
                                        @else 
                                            <div>{{ trans('common.inactive') }}</div>   
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">{{ trans('auth.city') }}</label>
                                        <div>{{ $user->city }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">{{ trans('auth.state') }}</label>
                                        <div>{{ isset($user->states) ? $user->states->name: null }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">{{ trans('auth.postal_code') }}</label>
                                        <div>{{ $user->postal_code }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@stop
