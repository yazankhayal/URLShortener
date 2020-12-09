@extends("layouts.app")

@section("content")

    <div class="hero">

        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 intro">
                    <h1 class="text-white font-weight-bold mb-4" data-aos="fade-up" data-aos-delay="0">
                        Create URL Shorter
                    </h1>

                    <form method="POST" action="{{ route('generate.shorten.link.post') }}"
                          class="sign-up-form d-flex ajaxForm shorten" data-name="shorten" data-aos="fade-up"
                          data-aos-delay="200">
                        @csrf
                        <input name="code" id="code" class="cls" type="hidden">
                        <input type="text" name="name" id="name" class="cls form-control" placeholder="Name">
                        <input type="text" name="link" id="link" class="cls form-control" placeholder="URL">
                        <input type="submit" class="btn btn-primary" value="Save IT">
                    </form>

                </div>


            </div>

            <div class="hero_img" data-aos="fade-up" data-aos-delay="300">
                <img src="{{url('/')}}/files/images/hero_img.png" alt="Image" class="img-fluid">
            </div>
        </div>

        <div class="slant" style="background-image: url('{{url('/')}}/files/images/slant.svg');"></div>
    </div>

    <div class="post-entries">
        <div class="container">
            <div class="section-title text-center mb-5" data-aos="fade-up" data-aos-delay="0">
                <strong class="subtitle d-block">Urls</strong>
                <h2 class="heading font-weight-bold mb-3">All Data Urls</h2>
            </div>
            <div class="row align-items-stretch" id="tag_container">
                @include('data.shortenLink')
            </div>
        </div>
    </div>

@endsection

@section("js")
    <script type="text/javascript">
        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    Render_Data(page);
                }
            }
        });

        $(document).ready(function () {

            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                Render_Data(page);
            });

            $(document).on('click', '.btn_delete', function () {
                var myurl = $(this).data('id');
                $.ajax({
                    url: "{{ route('shorten.delete') }}",
                    method: "get",
                    data: {
                        "code": myurl,
                    },
                    dataType: "json",
                    success: function (result) {
                        if(result.success){
                            Render_Data(1);
                        }
                        else{
                            toastr.error(result.error);
                        }
                    }
                });
            });

            $(document).on('click', '.btn_edit', function () {
                var myurl = $(this).data('id');
                $.ajax({
                    url: "{{ route('shorten.show') }}",
                    method: "get",
                    data: {
                        "code": myurl,
                    },
                    dataType: "json",
                    success: function (result) {
                        if(result.success){
                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;
                            $("#code").val(result.success.code);
                            $("#name").val(result.success.name);
                            $("#link").val(result.success.link);
                        }
                        else{
                            toastr.error(result.error);
                        }
                    }
                });
            });

        });

        function Render_Data(page) {
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html"
                }).done(function (data) {
                $("#tag_container").empty().html(data);
                location.hash = page;
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }
    </script>
@endsection
