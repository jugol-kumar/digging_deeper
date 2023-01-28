@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('message'))
                <h3 class="alert alert-success">{{ Session::get('message') }}</h3>
            @endif

            <h2>Welcome Admin ~~ {{ Auth::user()->name }} ~~</h2>

            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <nav>

                        <li class="nav-item">
                            <a class="nav-link"  href="{{ route('infinityloop') }}">Infinity Loops</a>
                        </li>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Create Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">All Post</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form method="post" action="{{ route('storepost') }}" class="p-5" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control mb-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <textarea rows="10" name="description" class="form-control" placeholder="Description"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Publication status</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Save post</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="p-5">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <th scope="row">{{ $post->id }}</th>
                                            <td>{{ $post->title }}</td>
                                            <td><span class="{{ $post->user->role->slug == 'admin' ? 'text-danger' : 'text-success' }} ">{{ $post->user->role->slug }}</span></td>
                                            <td>
                                                <a href=""><i class="fa fa-pencil"></i></a>
                                                <a href=""><i class="fa fa-trash"></i></a>
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
        </div>
    </div>
</div>
@endsection
