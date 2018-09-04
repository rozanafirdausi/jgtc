import * as _ from './utils'

export default function () {
    const $mainNav 		= $('.main-nav')
    const $primaryNav 	= $('.primary-nav')
    let btnTrigger 		= '.btn-mainnav'
    let onePage 		= '.one-page'

    $mainNav.on('click', btnTrigger, e=> {
    	e.preventDefault()
        $mainNav.toggleClass(_.classes.isActive)
        _.$body.toggleClass(_.classes.noScroll)
    })

    $mainNav.on('click', onePage, e=> {
    	e.preventDefault()
    	$mainNav.removeClass(_.classes.isActive)
        _.$body.removeClass(_.classes.noScroll)
    })

    $primaryNav.onePageNav({

    })
}
