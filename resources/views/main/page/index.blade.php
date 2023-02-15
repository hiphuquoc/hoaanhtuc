@extends('layouts.main')
@push('headCustom')
<!-- ===== START:: SCHEMA ===== -->
    <!-- STRAT:: Title - Description - Social -->
    @include('main.schema.social', compact('item'))
    <!-- END:: Title - Description - Social -->

    <!-- STRAT:: Organization Schema -->
    @include('main.schema.organization')
    <!-- END:: Organization Schema -->


    <!-- STRAT:: Article Schema -->
    @include('main.schema.article', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: Article Schema -->
    @include('main.schema.creativeworkseries', compact('item'))
    <!-- END:: Article Schema -->

    <!-- STRAT:: FAQ Schema -->
    @include('main.schema.faq', ['data' => $item->faqs])
    <!-- END:: FAQ Schema -->
<!-- ===== END:: SCHEMA ===== -->
@endpush
@section('content')
    {{-- <div style="overflow:hidden;"> --}}
        <!-- === START:: Header Top === -->
        @include('main.snippets.headerTop')
        <!-- === END:: Header Top === -->

        <!-- === START:: Header Main === -->
        @include('main.snippets.headerMain')
        <!-- === END:: Header Main === -->
        
        @include('main.template.breadcrumb', compact('breadcrumb'))

        <div class="contentBox">
            <!-- Gallery và Product detail -->
            <div class="container">
                <div class="pageContentWithSidebar">
                    <div class="pageContentWithSidebar_content">
                        <h1>{{ $item->name ?? $item->seo->title ?? null }}</h1>
                        {!! $content ?? null !!}
                    </div>
                    <div class="pageContentWithSidebar_sidebar">
                        <!-- trang liên quan (nhiều loại) -->
                        @if(!empty($typePages)&&$typePages->isNotEmpty())
                            @foreach($typePages as $typePage)
                                <div class="sidebarSectionBox">
                                    <div class="sidebarSectionBox_title">
                                        <h2>{{ $typePage[0]->type->name }}</h2>
                                    </div>
                                    <div class="sidebarSectionBox_box">
                                    @foreach($typePage as $page)
                                        @php
                                            $selected       = null;
                                            $urlPageFull    = env('APP_URL').'/'.$page->seo->slug_full;
                                            if($urlPageFull==URL::current()) $selected = 'selected';
                                        @endphp
                                        <a href="/{{ $page->seo->slug_full ?? null }}" title="{{ $category->name ?? $category->seo->title ?? null }}" class="sidebarSectionBox_box_item {{ $selected }}">
                                            <i class="fa-solid fa-chevron-right"></i><h3>{{ $page->name ?? $page->seo->title ?? null }}</h3>
                                        </a>
                                    @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection
@push('modal')

@endpush
@push('bottom')
    <!-- === START:: Zalo Ring === -->
    {{-- @include('main.snippets.zaloRing') --}}
    <!-- === END:: Zalo Ring === -->
@endpush
@push('scriptCustom')
    <script type="text/javascript">
        
    </script>
@endpush