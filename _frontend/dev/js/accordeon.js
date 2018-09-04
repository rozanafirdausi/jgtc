import * as _ from './utils'

export default function () {
    _.exist('.accordeon')
        .then(_.toJqueryObject)
        .then($accordeon => {
            let item            = '.accordeon__item'
            let content         = '.accordeon-content'
            $(`${item}.${_.classes.isActive} ${content}`).show()

        	$accordeon.on('click', '.btn-accordeon', e => {
                let $this       = $(e.currentTarget)
                let $item       = $this.parents(item)
                let $allItems   = $item.siblings()
                let $content    = $this.siblings(content)
                let $allContent = $allItems.find(content)

                $allItems.removeClass(_.classes.isActive)
                $allContent.slideUp()
                $item.toggleClass(_.classes.isActive)
                $content.slideToggle()
            })
        })
        .catch(_.noop)
}