@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h3>List of Tasks</h3></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div>
                            @include('components.tasks_table',['tasks'=>Auth::user()->tasks])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
