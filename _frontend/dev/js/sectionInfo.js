import * as _ from './utils'

export default function () {
    _.exist('.section-info')
        .then(_.toJqueryObject)
        .then($sectionInfo => {
        	$sectionInfo.next().addClass('next-info')
        })
        .catch(_.noop)
}