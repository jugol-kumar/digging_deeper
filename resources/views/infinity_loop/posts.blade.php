@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" id="postdata">
                @include("infinity_loop.load_data")
            </div>
        </div>
        <div class="ajax-loding text-center" style="display: none">
            <img src="{{ asset('giphy.gif') }}" alt="">
        </div>
    </div>
@endsection


@push("js")
    <script>
        function loadMore(page){
            $.ajax({
                url: '?page=' + page,
                type: "get",
                beforeSend(){
                    $(".ajax-loding").show()
                }
            }).done(function(res){
                if (res.view == ""){
                    $(".ajax-loding").html("No Record Found.....!")
                }
                $(".ajax-loding").hide()
                $("#postdata").append(res.view);
            }).fail(function (jqXHR, ajaxOptions, thrownError){
                alert("server not response");
            })
        }

        var page = 1;
        $(window).scroll(function (){
           if( $(window).scrollTop() + $(window).height() >= $(document).height() - 400){
               page++;
               loadMore(page);
           }
        })

    </script>
@endpush
