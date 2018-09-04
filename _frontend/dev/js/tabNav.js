import * as _ from './utils'

export default function () {
    _.exist('.tab-container')
        .then(_.toJqueryObject)
        .then($tabNav => {
        	let tabNav     = '.tab-nav__item > a:not([data-filter])'
            let tabFilter  = '.tab-nav__item > [data-filter]'
            

        	$tabNav.on('click', tabNav, (e)=> {
        		let $this 		= $(e.currentTarget)
        		let tabTarget 	= $this.attr('href')
        		let $tabTarget  = $(tabTarget)
        		let $parent 	= $this.parent()
        		e.preventDefault()

        		$tabTarget.siblings().removeClass(_.classes.isActive)
        		$tabTarget.addClass(_.classes.isActive)
        		$parent.siblings().removeClass(_.classes.isActive)
        		$parent.addClass(_.classes.isActive)
        	})

            $tabNav.on('click', tabFilter, e=> {
                let $this           = $(e.currentTarget)
                let targetFilter    = $this.data('filter')
                let $targetFilter   = $(`[data-filterlist="${targetFilter}"]`)
                e.preventDefault()

                $this.parent().siblings().removeClass(_.classes.isActive)
                $this.parent().addClass(_.classes.isActive)
                $targetFilter.siblings().hide()
                $targetFilter.show()
            })

            for (var i = 0; i < $tabNav.length; i++) {
                let $thisTab = $tabNav.eq(i)
                let firstTab = $thisTab.attr('data-first-tab')
                let navFilter  = `[data-filter="${firstTab}"]`
                let $nav     = $thisTab.find(navFilter)
                let $panel   = $thisTab.find(`[data-filterlist="${firstTab}"]`)

                $nav.parent().addClass(_.classes.isActive)
                $panel.show()
            }
        })
        .catch(_.noop)
}