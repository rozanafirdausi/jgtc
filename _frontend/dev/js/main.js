import activeStateMobile from './activeStateMobile'
import WPViewportFix from './windowsPhoneViewportFix'
import objectFitPolyfill from './objectFitPolyfill'
import formValidation from './formValidation'
import mainNav from './mainnav'
import lineupSlider from './lineupSlider'
import tabNav from './tabNav'
import headerToggle from './headerToggle'
import lazyLoadImage from './lazyLoadImage'
import accordeon from './accordeon'
import sectionInfo from './sectionInfo'
import sponsorSlide from './sponsorSlide'
import countdown from './countdown'
import artistSlider from './artistSlider'
import colorbox from './colorbox'
import toggleNav from './toggleNav'

const App = {
    activeStateMobile,
    WPViewportFix,
    objectFitPolyfill,
    formValidation,
    mainNav,
    lineupSlider,
    tabNav,
    headerToggle,
    lazyLoadImage,
    accordeon,
    sectionInfo,
    sponsorSlide,
    countdown,
    artistSlider,
    colorbox,
    toggleNav
}

for (let fn in App) {
    App[fn]()
}

export default App
