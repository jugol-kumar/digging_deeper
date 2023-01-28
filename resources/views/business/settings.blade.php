@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Business Settings') }}</div>
                {{ $errors->login->first('email') }}
                <div class="card-body">
                    <form method="POST" action="{{ route('business.update') }}">
                        @csrf

                        <input type="hidden" name="types[]" value="business_name">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Business Name') }}</label>
                            <div class="col-md-6">
                                <input id="email"
                                       type="text"
                                       class="form-control"
                                       name="business_name"
                                       value="{{ old('business_name') }}"
                                       required
                                       autocomplete="business_name"
                                       autofocus>
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
