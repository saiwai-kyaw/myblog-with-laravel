@extends("layouts.app")

@section("content")
  <div class="container" style="max-width: 800px">

    @if (session('info'))
      <div class="alert alert-info">
          {{ session("info") }}    
      </div>    
    @endif

      <div class="card mb-4">
        <div class="card-body">
          <h3 class="h4">
            {{$article->title}}
          </h3>
          <div class="text-muted">
            <b class="text-success">{{ $article->user->name}}</b>,
            Category:<b>{{$article->category->name}}</b>,
            {{$article->created_at->diffForHumans()}}
          </div>
          <div>
            {{$article->body}}
          </div>
          @auth
            @can("delete-article", $article)
              <div class="mt-3">
                <a href="{{url("articles/delete/$article->id")}}" class="btn btn-sm btn-outline-danger">
                  Delete
                </a>
                <a href="{{url("articles/edit/$article->id")}}" class="btn btn-sm btn-outline-warning">
                  Edit
                </a>
              </div>
            @endcan
          @endauth
        </div>
      </div>

      <ul class="list-group mt-4">
        <li class="list-group-item active">
            <b>Comments ({{ count($article->comments) }})</b>
        </li>
        @foreach($article->comments as $comment)
            <li class="list-group-item">
                @auth
                  @can('delete-comment', $comment)
                  <a href="{{url("/comments/delete/$comment->id")}}" class="btn-close float-end"></a>
                  @endcan
                @endauth
                {{ $comment->content }}
                <div class="mt-2">
                  <b class="text-success">{{$comment->user->name}}</b> -
                  {{ $comment->created_at->diffForHumans() }}
                </div>
            </li>
        @endforeach
      </ul>
    
      @auth
      <form action="{{url("/comments/add")}}" method="POST">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <textarea name="content" class="form-control my-2" placeholder="Type a new comment"></textarea>
        <button class="btn btn-secondary">Add Comment</button>
      </form>
      @endauth
  </div>
@endsection