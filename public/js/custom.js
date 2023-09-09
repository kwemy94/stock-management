function ControlRequiredFields(inputs = $('.required')) {
    let success = true;
    console.log('Nombre de champ requis : '+inputs.length);
    for (let i = 0; i < inputs.length; i++) {
        if ($(inputs[i]).val() == null || $(inputs[i]).val().trim() == '') { // trim permet d'enlever les tabulation inutile sur un champ
            $(inputs[i]).addClass('error');
            success = false;
        } else {
            $(inputs[i]).removeClass('error');
        }
    }

    return success;
}


async function postData(url = "", data, method = "POST") {
    // Default options are marked with *

    const response = await fetch(url, {
        method: method, // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-Token": $('input[name="_token"]').val(),
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data), // body data type must match "Content-Type" header
    });

    return response.json(); // parses JSON response into native JavaScript objects
}