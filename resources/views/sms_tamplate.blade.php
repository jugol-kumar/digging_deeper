@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
{{--                <form method="post" action="{{ route('storepost') }}" class="p-5" enctype="multipart/form-data">--}}

{{--                </form>                    --}}
                <form action="https://api.mobireach.com.bd/SendTextMessage" method="post">
                    <input type="text" name="Username" value="amma"/>
                    <input type="text" name="Password" value="Amj@32320112"/>
                    <input type="text" name="From" value="8801855884477"/>
                    <input type="text" name="To" value="8801723717933" />
                    <input type="text" name="Message" value="please send me this message"/>
                    <input type="submit" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@endsection
