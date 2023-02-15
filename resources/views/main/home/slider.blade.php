
<div class="hide-766">
    <div id="js_setSlick" class="sliderBox js_setSlick">
        <img src="{{ Storage::url('images/slider-1.jpg') }}" alt="" title="" />
        <img src="{{ Storage::url('images/slider-1.jpg') }}" alt="" title="" />
        <img src="{{ Storage::url('images/slider-1.jpg') }}" alt="" title="" />
    </div>
</div>
<div class="show-766">
    <div class="sliderBox js_setSlick">
        <img src="/storage/images/upload/slider_1_mobile-type-manager-upload.webp" alt="" title="" />
        <img src="/storage/images/upload/slider_1_mobile-type-manager-upload.webp" alt="" title="" />
    </div>
</div>
@push('scriptCustom')
    <script type="text/javascript">
        $(document).ready(function(){
            setSlick();
        })
        $(window).resize(function(){
            setSlick();
        })
        function setSlick(){
            $('.js_setSlick').slick({
                dots: true,
                arrows: true,
                prevArrow: '<button class="slick-arrow slick-prev" aria-label="Slide trước"><i class="fa-solid fa-arrow-left-long"></i></button>',
                nextArrow: '<button class="slick-arrow slick-next" aria-label="Slide tiếp theo"><i class="fa-solid fa-arrow-right-long"></i></button>',
                autoplay: true,
                infinite: true,
                autoplaySpeed: 5000,
                lazyLoad: 'ondemand',
                responsive: [
                    {
                        breakpoint: 567,
                        settings: {
                            arrows: false,
                        }
                    }
                ]
            });
        }
    </script>
@endpush