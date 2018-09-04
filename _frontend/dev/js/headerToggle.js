import * as _ from './utils'

export default function () {
    const $header = $('.site-header')
    const $main   = $('.sticky-footer-container')
    const headerFixed = 'header-fixed'

    _.$win.scroll(e=> {
        let isTop   = $main.offset().top
        let readyTop= isTop + 100

        if(_.$win.scrollTop() > readyTop) {
            $header.addClass(_.classes.isActive)
            _.$body.addClass(headerFixed)
        } else if(_.$win.scrollTop() === isTop) {
            $header.removeClass(_.classes.isActive)
            _.$body.removeClass(headerFixed)
        }
    })
    
}