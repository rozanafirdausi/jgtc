import * as _ from './utils'

export default function () {
    _.exist('.item-heavy')
        .then(_.toJqueryObject)
        .then($itemHeavy => {
        	$itemHeavy.lazyload({
                threshold : 200,
                skip_invisible  : false
            })
        })
        .catch(_.noop)
}