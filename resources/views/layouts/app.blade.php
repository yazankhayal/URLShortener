<!doctype html>
<html lang="en">
<head>
    @include("layouts.css")
</head>
<body>

@include("layouts.header")

@yield("content")

@include("layouts.footer")
@include("layouts.js")
<script>
    $(document).ready(function () {
        "use strict";
        //Code here.
        $(document).ajaxStart(function () {
            NProgress.start();
        });
        $(document).ajaxStop(function () {
            NProgress.done();
        });
        $(document).ajaxError(function () {
            NProgress.done();
        });

    });
</script>
@yield("js")

</body>
</html>
