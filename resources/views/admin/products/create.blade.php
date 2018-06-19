@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.products.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.products.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', trans('quickadmin.products.fields.name').'', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.products.fields.description').'', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            @if(Auth::user()->isAdmin())
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('created_by_team_id', trans('quickadmin.qa_team-management-singular').'', ['class' => 'control-label']) !!}
                        {!! Form::select('created_by_team_id', $created_by_teams, old('created_by_team_id'), ['class' => 'form-control select2']) !!}
                        <p class="help-block"></p>
                        @if($errors->has('created_by_team_id'))
                            <p class="help-block">
                                {{ $errors->first('created_by_team_id') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
            @can('assign_item_to_member')
                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('created_by_id', trans('quickadmin.qa_user').'', ['class' => 'control-label']) !!}
                        @if(Auth::user()->isAdmin())
                            {!! Form::select('created_by_id', ['Select team'], old('created_by_id'), ['class' => 'form-control select2', 'disabled']) !!}
                        @else
                            {!! Form::select('created_by_id', $created_by_ids, old('created_by_id'), ['class' => 'form-control select2']) !!}
                        @endif
                        <p class="help-block"></p>
                        @if($errors->has('created_by_user_id'))
                            <p class="help-block">
                                {{ $errors->first('created_by_user_id') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endcan
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @if(Auth::user()->isAdmin())
        <script src="{{ asset('js/custom/TeamMembersSelect.js') }}"></script>
    @endif
@endsection
