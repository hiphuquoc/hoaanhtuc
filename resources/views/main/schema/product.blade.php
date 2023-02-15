@php
    /* lấy ảnh đại diện */
    $image      = !empty($item->seo->image) ? '"'.env('APP_URL').Storage::url($item->seo->image).'"' : null;
    /* trường hợp có gallery thì lấy gallery */
    /* chưa có trường hợp nên chưa xử lý */
    /* trường hợp có gallery sản phẩm thì lấy gallery sản phẩm */
    $flagHaveImage          = false;
    if(!empty($item->prices)&&$item->prices->isNotEmpty()){
        foreach($item->prices as $price){
            if(!empty($price->files)&&$price->files->isNotEmpty()){
                $flagHaveImage  = true;
                break;
            }
        }
    }
    if($flagHaveImage==true){
        $image          = null;
        $i              = 0;
        foreach($item->prices as $price){
            foreach($price->files as $file){
                if($i!=0) $image .= ', ';
                $image  .= '"'.env('APP_URL').Storage::url($file->file_path).'"';
                ++$i;
            }
        }
    }
@endphp
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $item->seo->seo_title ?? $item->seo->title ?? null }}",
        "url": "{{ URL::current() }}",
        "image":
            [
                {!! $image !!}
            ],
        "description": "{{ $item->seo->seo_description ?? $item->seo->description ?? null }}",
        "sku": "WW122023M{{ !empty($item->seo->created_at) ? strtotime($item->seo->created_at) : 00 }}YK/VN",
        "brand": {
            "@type": "Brand",
            "name": "{{ config('main.company_name') }}"
        },
        "review":
            {
                "@type": "Review",
                "reviewRating":
                    {
                        "@type": "Rating",
                        "ratingValue": "5"
                    },
                "author": {
                    "@type": "Thing",
                    "name": "{{ $item->seo->rating_author_name ?? null }}"
                }
            },
        "aggregateRating":
            {
                "@type": "AggregateRating",
                "ratingValue": "{{ $item->seo->rating_aggregate_star ?? '4.8' }}",
                "reviewCount": "{{ $item->seo->rating_aggregate_count ?? '172' }}",
                "bestRating": "5"
            },
        "offers":
            {
                "@type": "AggregateOffer",
                "url": "{{ URL::current() }}",
                "offerCount": "1",
                "priceCurrency": "VND",
                "lowPrice": "{{ $lowPrice ?? '500000' }}",
                "highPrice": "{{ $highPrice ?? '5000000' }}",
                "itemCondition": "https://schema.org/UsedCondition",
                "availability": "https://schema.org/InStock",
                "seller":
                    {
                        "@type": "Organization",
                        "name": "{{ $item->seo->rating_author_name ?? config('main.author_name') }}",
                        "url": "{{ env('APP_URL') }}"
                    }
            }
    }
</script>
