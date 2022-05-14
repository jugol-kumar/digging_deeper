@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <nav>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Create Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">All Post</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="tab-content" id="myTabContent">
                        @if(count($errors) > 0 )
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="p-0 m-0" style="list-style: none;">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="tab-pane fade  " id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form class="p-5" method="post" action="{{ route('post.store') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control mb-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Title">
                                    @error("title")

                                    @enderror
                                </div>
                                <div class="form-group">
                                    <textarea rows="10" name="description" class="form-control" placeholder="Description"></textarea>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Publication status</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save post</button>
                            </form>
                        </div>
                        <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="p-5">
                                <table class="table" >
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                    </tr>
                                    </thead>
                                    <tbody id="post_data">
                                    @foreach($posts as $post)
                                        <tr>
                                            <th scope="row">{{ $post->id}}</th>
                                            <td>{{ $post->title }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-dark" id="loadMore" data-id="{{ $posts->last()->id }}">Load more {{ $posts->last()->id }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        var _token = $('input[name="_token"]').val();


        $(document).on('click', '#loadMore', function (e) {
            var fruitCount = $(this).data('id');

            load_data(fruitCount, _token);
            console.log(fruitCount);
        })



        function load_data(id="", _token)
        {
            $.ajax({
                url:"{{ route('loadmore.load_data') }}",
                method:"POST",
                data:{id:id, _token:_token},
                beforeSend:function(){
                    $('#loadMore').html('Loding.........'); //s
                },
                success:function(data)
                {
                    $('#loadMore').html('Load more');
                    var len = data.length;
                    data.forEach(function (value, id) {
                        console.log(id);

                        if (id === (len - 1)){
                            $('#loadMore').data('id', value.id); //setter
                        }

                        $('#post_data').append(`
                        <tr>
                            <th scope="row">${value.id}</th>
                            <td>${value.title}</td>
                        </tr>
                    `);
                    })
                }
            })
        }
    </script>
@endpush
