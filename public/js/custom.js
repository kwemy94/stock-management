function ControlRequiredFields(inputs = $('.required')) {
    let success = true;

    for (let i = 0; i < inputs.length; i++) {
        if ($(inputs[i]).val().trim() == '') { // trim permet d'enlever les tabulation inutile sur un champ
            $(inputs[i]).addClass('error');
            success = false;
        } else {
            $(inputs[i]).removeClass('error');
        }
    }

    return success;
}