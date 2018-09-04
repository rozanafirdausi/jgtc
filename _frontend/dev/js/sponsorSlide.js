import * as _ from './utils'

export default function () {
    _.exist('.sponsor-slider')
        .then(_.toJqueryObject)
        .then(_.createSlider({
            lazyLoad: 'progressive',
            dots: true,
            slidesToShow: 5,
            slidesToScroll: 5,
            prevArrow: _.slickPrev,
            nextArrow: _.slickNext,
            infinite: false,
            responsive: [
            {
                breakpoint: 1280,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: false
                }
            }]
        }))
        .catch(_.noop)
}