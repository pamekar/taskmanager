<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Start at</th>
        <th scope="col">End at</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        @php
            $badgeStatus=['pending'=>'warning', 'active'=>'primary','completed'=>'success'];
        @endphp
        <tr class="{{$task->is_compulsory?'table-warning':""}}">
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$task->title}}</td>
            <td>{{Str::limit($task->description, 100, ' (...)')}}</td>
            <td>{{$task->start_at?$task->start_at->format('d-m-Y'):null}}</td>
            <td>{{$task->end_at?$task->end_at->format('d-m-Y'):null}}</td>
            <td>
                <span class="badge badge-pill badge-{{$badgeStatus[$task->meta->status]??"danger"}}">
                    {{$task->meta->status}}
                </span>
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a href="{{route('tasks.show',$task->id)}}" type="button" class="btn btn-outline-dark"
                       data-toggle="tooltip" data-placement="top" title="View">
                        <span class="iconify" data-icon="simple-line-icons:eye" data-inline="false"></span>
                    </a>
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
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>