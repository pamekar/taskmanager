@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><span class="font-weight-bold">Editing "{{$task->title}}"</span></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
                            @include('components.tasks_form',['route'=>route('tasks.update',$task->id),'is_update'=>true])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
