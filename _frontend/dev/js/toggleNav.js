import * as _ from './utils'

export default function () {
    _.exist('.toggle-nav')
        .then(_.toJqueryObject)
        .then($toggleNav => {
        	let $toggleBtn = $('[data-toggle]')

            $toggleBtn.on('click', e => {
                let $this        = $(e.currentTarget)
                let targetToggle = $this.data('toggle')
                let $targetToggle= $(`#${targetToggle}`)
                let isActive     = $this.hasClass(_.classes.isActive)

                if(isActive) {
                    $this.removeClass(_.classes.isActive)
                    $targetToggle.removeClass(_.classes.isActive)
                } else {
                    $this.addClass(_.classes.isActive)
                    $targetToggle.addClass(_.classes.isActive)
                }
            })
        })
        .catch(_.noop)
}