@extends('rb28dett::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('rb28dett_permissions::general.create_permission'))
@section('subtitle', __('rb28dett_permissions::general.create_permission_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('rb28dett::index') }}">@lang('rb28dett_permissions::general.home')</a></li>
        <li><a href="{{ route('rb28dett::permissions.index') }}">@lang('rb28dett_permissions::general.permission_list')</a></li>
        <li><span>@lang('rb28dett_permissions::general.create_permission')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l uk-width-1-3@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('rb28dett_permissions::general.create_permission') }}
                    </div>
                    <div class="uk-card-body">
                        <form method="POST" action="{{ route('rb28dett::permissions.store') }}" class="uk-form-stacked">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('rb28dett_permissions::general.name')</label>
                                    <input value="{{ old('name', isset($permission) ? $permission->name : '') }}" name="name" class="uk-input" type="text" placeholder="@lang('rb28dett_permissions::general.name')">
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('rb28dett_permissions::general.slug')</label>
                                    <input value="{{ old('slug', isset($permission) ? $permission->slug : '') }}" name="slug" class="uk-input" type="text" placeholder="@lang('rb28dett_permissions::general.slug')">
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('rb28dett_permissions::general.description')</label>
                                    <div class="uk-form-controls">
                                        <textarea name="description" class="uk-textarea" rows="5" placeholder="@lang('rb28dett_permissions::general.description')">{{ old('description', isset($permission) ? $permission->description : '') }}</textarea>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <a href="{{ route('rb28dett::permissions.index') }}" class="uk-button uk-button-default">@lang('rb28dett_permissions::general.cancel')</a>
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; {{ __('rb28dett_permissions::general.create') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-1-5@l uk-width-1-3@xl"></div>
        </div>
    </div>
@endsection
