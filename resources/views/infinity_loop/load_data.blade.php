@foreach($posts as $post)
    <div class="card mb-4">
        <div class="card-header">
            <h2>Post Id : {{ $post->id }}</h2>
        </div>
        <div class="card-body">
            <h3>{{ $post->title }}</h3>
            {{ $post->slug }}
        </div>
    </div>
@endforeach
