<form action="{{$route}}" method="post">
    @if($is_update??false)
        @method('PUT')
    @endif
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
               placeholder="Give your task a title :)" required autofocus value="{{$task->title??null}}">
        @error('title')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                  placeholder="Describe your task here :)">{{$task->description??null}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="start_at">Start date</label>
            <input type="date" class="form-control @error('start_at') is-invalid @enderror" name="start_at"
                   id="start_at" value="{{$task->start_at?$task->start_at->format('Y-m-d'):null}}">
            @error('start_at')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="status">Status</label>
            <select class="form-control @error('start_at') is-invalid @enderror" name="status" id="status">
                <option>pending</option>
                <option>active</option>
                <option>completed</option>
            </select>
            @error('status')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="end_at">End date</label>
            <input type="date" class="form-control @error('end_at') is-invalid @enderror" name="end_at"
                   id="end_at" value="{{$task->end_at?$task->end_at->format('Y-m-d'):null}}">
            @error('end_at')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>