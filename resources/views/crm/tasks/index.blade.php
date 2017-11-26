@extends('layouts.base')

@section('caption', 'List of tasks')

@section('title', 'List of tasks')

@section('lyric', '')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- will be used to show any messages -->
            @if(session()->has('message_success'))
                <div class="alert alert-success">
                    <strong>Well done!</strong> {{ session()->get('message_success') }}
                </div>
            @elseif(session()->has('message_danger'))
                <div class="alert alert-danger">
                    <strong>Danger!</strong> {{ session()->get('message_danger') }}
                </div>
            @endif
            {!! Form::open(array('route' => 'tasks/search', 'class'=>'form navbar-form navbar-right searchform')) !!}
            {!! Form::text('search', null,
                                   array('required',
                                        'class'=>'form-control',
                                        'placeholder'=>'Write name of tasks...')) !!}
            {!! Form::submit('Search',
                                       array('class'=>'btn btn-default')) !!}
            {!! Form::close() !!}
            <a href="{{ URL::to('tasks/create') }}">
                <button type="button" class="btn btn-primary btn-lg active">Add tasks</button>
            </a>
            <br>
            <!-- Advanced Tables -->
            <h4 class="page-header">
                <i class="fa fa-code-fork" aria-hidden="true"></i> List of uncompleted tasks
            </h4>
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="table">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Assigned employee</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Completed</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $key => $value)
                                @if($value->completed == 0)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $value->name }}</td>
                                        <td class="text-center"><a
                                                    href="{{ URL::to('employees/' . $value->employees->id) }}">{{ $value->employees->full_name }}</a>
                                        </td>
                                        <td class="text-center">
                                            @if($value->is_active == TRUE)
                                                <input type="checkbox" data-on="Active" checked data-toggle="toggle"
                                                       onchange='window.location.assign("{{ URL::to('tasks/set-active/' . $value->id . '/0') }}")'/>
                                            @else
                                                <input type="checkbox" data-off="Deactivate" data-toggle="toggle"
                                                       onchange='window.location.assign("{{ URL::to('tasks/set-active/' . $value->id . '/1') }}")'/>
                                            @endif
                                        </td>
                                        <td class="text-right">{{ $value->completed ? 'Yes' : 'No' }}</td>
                                        <td class="text-right">
                                            @if($value->completed == FALSE)
                                                <a href="{{ URL::to('tasks/completed/' . $value->id) }}">
                                                    <button type="button" class="btn btn-completed">Mark as completed</button>
                                                </a>
                                            @else
                                                <a href="{{ URL::to('tasks/uncompleted/' . $value->id) }}">
                                                    <button type="button" class="btn btn-completed">Mark as uncompleted</button>
                                                </a>
                                            @endif
                                            <a class="btn btn-small btn-success"
                                               href="{{ URL::to('tasks/' . $value->id) }}">More information</a>
                                            <a class="btn btn-small btn-info"
                                               href="{{ URL::to('tasks/' . $value->id . '/edit') }}">Edit</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $tasksPaginate->render() !!}
                </div>
            </div>
            <!--End Advanced Tables -->

            <!-- Advanced Tables -->
            <h4 class="page-header">
                <i class="fa fa-code-fork" aria-hidden="true"></i> List of completed tasks
            </h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table" style="color: grey;">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Assigned employee</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tasks as $key => $values)
                                @if($values->completed == 1)
                                    <tr class="odd gradeX">
                                        <td class="text-center">{{ $values->name }}</td>
                                        <td class="text-center">{{ $values->employees->full_name }}</td>
                                        <td class="text-right">
                                            @if($values->completed == FALSE)
                                                <a href="{{ URL::to('tasks/completed/' . $values->id) }}">
                                                    <button type="button" class="btn btn-completed" style="background-color: grey !important; border-color: grey">Mark as completed</button>
                                                </a>
                                            @else
                                                <a href="{{ URL::to('tasks/uncompleted/' . $values->id) }}">
                                                    <button type="button" class="btn btn-completed" style="background-color: grey !important; border-color: grey">Mark as uncompleted</button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $tasksPaginate->render() !!}
                </div>
            </div>
            <!--End Advanced Tables -->

        </div>
    </div>
@endsection