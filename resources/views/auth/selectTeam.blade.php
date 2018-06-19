@extends('layouts.auth')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('quickadmin.teams.actions.select')</div>
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'url' => route('admin.team-select.select'), 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label class="col-md-4 control-label">@lang('quickadmin.teams.title')</label>

                            <div class="col-md-6">
                                {!! Form::select('team_id', $teams, old('team_id'), ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit(trans('quickadmin.qa_select'), ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection