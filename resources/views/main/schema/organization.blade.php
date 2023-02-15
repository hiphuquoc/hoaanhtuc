@php
    use \App\Helpers\Words;
@endphp
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('main.company_name') }}",
        "description": "{{ config('main.company_description') }}",
        "founder": "{{ config('main.founder_name') }}",
        "foundingDate": "{{ date('c', strtotime(config('main.founding'))) }}",
        "address": "{{ config('main.founder_address') }}",
        "url": "{{ env('APP_URL') }}",
        "logo": "{{ env('APP_URL').Storage::url(config('main.logo_750x460')) }}",
        "contactPoint": [
            @foreach(config('main.contacts') as $contact)
                @if($loop->index!=0) 
                    ,
                @endif
                {
                    "@type": "ContactPoint",
                    "telephone": "{{ $contact['phone'] }}",
                    "contactType": "{{ $contact['type'] }}",
                    "areaServed": ["VN"],
                    "availableLanguage": ["Vietnamese"]
                }
            @endforeach
        ],

        {{-- "productSupported": [{
            "@type": "Product",
            "name": "Thiết Kế Website Chuyên Nghiệp",
            "description": "Dịch vụ thiết kế website chuyên nghiệp tại Kiên Giang, giúp doanh nghiệp tối ưu hóa hiệu quả kinh doanh trực tuyến và xây dựng thương hiệu 4.0 thành công.",
            "sku": "TKW-001",
            "brand": {
              "@type": "Brand",
              "name": "Thiết Kế Website Kiên Giang"
            }
        }], --}}

        "sameAs": [
            @foreach(config('main.socials') as $social)
                @if($loop->index!=0) 
                    ,
                @endif
                "{{ $social }}"
            @endforeach
        ]
      }
</script>
