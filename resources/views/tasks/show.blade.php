@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">Showing "{{$task->title}}"</span>
                        <span class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            @if($task->user_id === Auth::id())
                                <a href="{{route('tasks.edit',$task->id)}}" class="btn btn-outline-primary"
                                   data-toggle="tooltip" data-placement="top" title="Edit">
                            <span class="iconify" data-icon="simple-line-icons:note"
                                  data-inline="false"></span>
                                </a>
                            @endif
                            @if((!$task->is_compulsory??false) || $task->user_id === Auth::id())
                                <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top"
                                        title="Delete" form="delete-{{$task->id}}">
                                    <span class="iconify" data-icon="simple-line-icons:close"
                                      data-inline="false"></span>
                                </button>
                                <form action="{{route('tasks.destroy',$task->id)}}" method="post" id="delete-{{$task->id}}" hidden>
                                    @method('DELETE') @csrf
                                </form>
                            @endif
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
                            <table class="table">
                                <tr>
                                    <th scope="col">Title</th>
                                    <td>{{$task->title}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Description</th>
                                    <td>{{$task->description}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Start at</th>
                                    <td>{{$task->start_at?$task->start_at->format('d-m-Y'):null}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">End at</th>
                                    <td>{{$task->end_at?$task->end_at->format('d-m-Y'):null}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Author</th>
                                    <td>{{$task->author->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Status</th>
                                    <td>
                                        @php
                                            $badgeStatus=['pending'=>'warning', 'active'=>'primary','completed'=>'success'];
                                        @endphp
                                        <h4>
                                            <span class="badge badge-{{$badgeStatus[$task->meta->status]??"danger"}}">
                                                {{$task->meta->status}}
                                            </span>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Remarks</th>
                                    <td>
                                        <ul>
                                            <li>Task is {{$task->is_compulsory ? "compulsory" : "not compulsory"}}.</li>
                                            <li>Task is {{$task->meta->status}}</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
