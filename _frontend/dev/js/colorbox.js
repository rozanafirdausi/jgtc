import * as _ from './utils'

export default function () {
    _.exist('.colorbox')
        .then(_.toJqueryObject)
        .then($colorbox => {
            let $video   = $('.video-colorbox')
            let $photo   = $('.photo-colorbox')
            let isMedium = 768
            let isLarge  = 1024
            let boxFrame = '#cboxLoadedContent, #cboxMiddleLeft, #cboxMiddleRight, #cboxTopCenter'
            let inWidth,inHeight
            let opts     = {
                fixed: true,
                width: '100%',
                height: '100%',
                close: '',
                next: '',
                previous: '',
                transition: 'fade'
            }

            // innerSize()

            let videoColorbox = $video.colorbox({
                ...opts,
                iframe: true,
                rel: 'video-colorbox',
                current: 'video {current} of {total}'

            })

            let photoColorbox = $photo.colorbox({
                ...opts,
                rel: 'photo-colorbox',
                current: 'photo {current} of {total}'
            })

            $('#colorbox').on('click', boxFrame, e => {
                photoColorbox.colorbox.close()
                videoColorbox.colorbox.close()
            })

            $('#colorbox').on('click', '#cboxLoadedContent > *', e => {
                e.stopPropagation()
            })

            function innerSize() {
                let myWindow = _.$win.width()
                if (myWindow >= isLarge) {
                    inWidth = 720
                    inHeight = 402 
                } else if(myWindow >= isMedium && myWindow < isLarge) {
                    inWidth = 560
                    inHeight = 315
                } else if(myWindow < isMedium) {
                    inWidth = 320
                    inHeight = 180
                } else {
                    inWidth = 240
                    inHeight = 135
                }
            }
        })
        .catch(_.noop)
}