import * as _ from './utils'

export default function () {
    _.exist('.countdown')
        .then(_.toJqueryObject)
        .then($countdown => {
        	let endDate        = $countdown.data('enddate')
            let countDownDate = new Date(endDate).getTime()
            let $countTimer     = $('.countdown__timer')

            // Update the count down every 1 second
            let x = setInterval(function() {

                // Get todays date and time
                let now = new Date().getTime();

                // Find the distance between now and the count down date
                let distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // console.log(distance, days, hours, minutes, seconds)

                if (distance < 0) {
                    days = 0
                    hours = 0
                    minutes = 0
                    seconds = 0
                    clearInterval(x);
                }

                let ui = `<div class="countdown__item">
                    <div class="time">${days}</div>
                    <div class="label">Days</div>
                </div>
                <div class="countdown__item">
                    <div class="time">${hours}</div>
                    <div class="label">Hours</div>
                </div>
                <div class="countdown__item">
                    <div class="time">${minutes}</div>
                    <div class="label">Minutes</div>
                </div>
                <div class="countdown__item">
                    <div class="time">${seconds}</div>
                    <div class="label">Seconds</div>
                </div>`

                // Display the result in the element with id="demo"
                $countTimer.html(ui)

            }, 1000);
        })
        .catch(_.noop)
}