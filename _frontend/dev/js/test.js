import * as _ from './utils'

export default function () {
    const postData = (url = ``, data = {}) => {
        return $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: data,
        })
        .done(function() {
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    };

    
    navigator.geolocation.getCurrentPosition(function(position) {
        let coords = position.coords
        console.log(coords.latitude)

        postData(`http://www.mocky.io/v2/5b69656c3200006e00af5bc6`, coords)
          .then(data => console.log(coords)) // JSON from `response.json()` call
          .catch(error => console.error(error));
    })
    
}