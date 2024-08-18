@extends("layouts.app")

@section("content")
    <div class="container" style="max-width: 800px">

        @if ($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error )
                    {{$error}}
                @endforeach
            </div>         
        @endif

        <form action="{{url("/articles/edit")}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$article->id}}">
            <input type="text" name="title" class="form-control mb-2" value="{{$article->title}}">
            <textarea name="body" class="form-control mb-2">{{$article->body}}</textarea>
            <select name="category_id" class="form-select">
                @foreach ($categories as $category)
                <option value="{{$category->id}}"{{$article->category->id == $category->id ? 'selected' : ''}}>
                    {{$category->name}}
                </option>                  
                @endforeach
            </select>
            <button class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
