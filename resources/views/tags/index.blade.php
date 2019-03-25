@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                    <div class="btn-group pull-right">
                        <a href="/tags/create" class="btn btn-default btn-xs">
                            <i class="fas fa-plus"></i> New Tag
                        </a>
                    </div>
					
					<div class="btn-group pull-right">&nbsp;&nbsp;
                        <a href="/home" class="btn btn-default btn-xs">
                            <i class="fa fa-sticky-note"></i> Posts
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Tags</h3>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tag Name</th>
                                <th>Created</th>   
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->tag }}</td>
                                    <td>{{ $tag->created_at }}</td>
                                    
                                    <td>
                                        <a href="/tags/{{ $tag->id }}/edit" class="btn btn-info btn-xs"> 
                                            <i class='fas fa-edit'></i> Edit Tag
                                        </a>
                                    </td>
                                    
                                    <td>
                                        {!! Form::open(['action'=>['TagsController@destroy', $tag->id], 'method'=>'Tag' ]) !!}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="fas fa-trash"></i> Delete Tag
                                            </button>

                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
