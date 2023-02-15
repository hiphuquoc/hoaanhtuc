<div class="blogHomeBox">
    <div class="blogHomeBox_title">
        <h2>Blog làm đẹp</h2>
    </div>
    <div class="blogHomeBox_description">
        Là phụ nữ, nhất định phải xinh đẹp và tự tin. Hãy cùng Cỏ mềm HomeLab khám phá những bí quyết làm đẹp thú vị nhé!
    </div>
    <div class="blogHomeBox_box js_setSlickBlogHomeBox">
        @for($i=0;$i<10;++$i)
            <div class="blogHomeBox_box_item">
                <img src="https://static.comem.vn/uploads/December2022/serum-ha_m.png" alt="" title="" />
                <div class="blogHomeBox_box_item_content">
                    <div class="blogHomeBox_box_item_content_title">
                        <h3 class="maxLine_2">25+ Biểu tượng Giáng sinh cute 99% đã biết "nhưng chưa hiểu</h3>
                    </div>
                </div>
                <div class="blogHomeBox_box_item_background"></div>
            </div>
        @endfor
    </div>
</div>
@push('scriptCustom')
    <script type="text/javascript">
        $(document).ready(function(){
            setSlickBlogHomeBox();
        })
        $(window).resize(function(){
            setSlickBlogHomeBox();
        })
        function setSlickBlogHomeBox(){
            $('.js_setSlickBlogHomeBox').each(function(){
                if ($(this).length <= 0) return;
                $(this).slick({
                    infinite: false,
                    slidesToShow: 5,
                    slidesToScroll: 5,
                    dots: false,
                    arrows: true,
                    prevArrow: '<button class="slick-arrow slick-prev" aria-label="Slide trước"><i class="fa-solid fa-angle-left"></i></button>',
                    nextArrow: '<button class="slick-arrow slick-next" aria-label="Slide tiếp theo"><i class="fa-solid fa-angle-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 1199,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4
                            }
                        },
                        {
                            breakpoint: 990,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1.5,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 419,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        }
    </script>
@endpush