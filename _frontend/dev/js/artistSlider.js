import * as _ from './utils'

export default function () {
    let slideOpts = {

    }
    _.exist('.video-artist-slider')
        .then(_.toJqueryObject)
        .then(_.createSlider({
            dots: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: false,
            infinite: false,
            appendDots: '#videoSlideDots',
            responsive: [
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
                    slidesToScroll: 2
                }
            }]
        }))
        .catch(_.noop)

    _.exist('.photo-artist-slider')
        .then(_.toJqueryObject)
        .then(_.createSlider({
            dots: true,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            infinite: false,
            appendDots: '#photoSlideDots',
            responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }]
        }))
        .catch(_.noop)
}