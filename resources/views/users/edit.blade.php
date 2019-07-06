@extends('layouts.app')

@section('footer-js')

@endsection

@section('content')
<div>
    <form id="form" class="form-horizontal" action="{{ route('users.update', $user->id) }}" method="post" novalidate="">
        <input type="hidden" name="_method" value="PUT">
        @csrf
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('Redaguoti vartotoją') }}: <strong>{{ $user->name }}</strong>
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <user-fields
                    :user="{{ $user }}"
                    :user_role="{{ json_encode(auth()->user()->roles) }}"
                    :is_admin="{{ auth()->user()->hasRole('Admin') ? 1 : 0 }}"
                    :roles="{{ $roles }}">
                </user-fields>
            </div>
            <div class="kt-portlet__foot">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success">{{ __('Atnaujinti') }}</button>
                        @hasrole('Admin')
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Nutraukti</a>
                        @endhasrole
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
