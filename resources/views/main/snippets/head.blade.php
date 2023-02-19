
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
@php
    $follow = 'index,follow';
    if(URL::current()==(env('APP_URL').'/cong-tac-vien')) $follow = 'noindex,nofollow';
@endphp
<meta name="robots" content="{{ $follow }}">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="fragment" content="!" />
<link rel="shortcut icon" href="/storage/images/upload/hoaanhtuc-favicon-type-manager-upload.webp" type="image/x-icon">
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('/sources/main/ring.css?'.time()) }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/sources/main/loading.css?'.time()) }}">
@vite(['resources/sources/main/style.scss'])
<!-- END: Custom CSS-->

<!-- BEGIN: FONT AWESOME -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
<!-- END: FONT AWESOME -->

<style type="text/css">
    /* font */
    @font-face{
        font-family:'SVN-Gilroy Bold';
        font-style:normal;
        font-weight:700;
        src:url("/fonts/svn-gilroy_semibold.ttf")
    }
    @font-face{
        font-family:'SVN-Gilroy';
        font-style:normal;
        font-weight:500;
        src:url("/fonts/svn-gilroy_medium.ttf")
    }
</style>

@stack('headCustom')

<!-- BEGIN: SLICK -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<!-- END: SLICK -->

<!-- BEGIN: Jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- END: Jquery -->

<!-- BEGIN: Google Analytics -->
@php
    if(!empty(env('GOOGLE_ANALYTICS'))) echo env('GOOGLE_ANALYTICS');
@endphp
<!-- END: Google Analytics -->