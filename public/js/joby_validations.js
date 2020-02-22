/**
 * JQUERY FORMVALIDATION AND USEFULL TOOLS
 * @AUTHOR AND REWRTTEN BY JOBY JOSEPH
 * 
 */

errorElementClass = 'error'; // Class that will be put on elements which value is invalid
successElementClass = 'valid'; // Class that will be put on elements that has been validated with success
borderColorOnError = '#b94a48'; // Border color of elements which value is invalid, empty string to not change border color
errorMessageClass = 'form-error'; // class name of div containing error messages when validation fails
validationRuleAttribute = 'data-validation'; // name of the attribute holding the validation rules
validationErrorMsgAttribute = 'data-validation-error-msg'; // define custom err msg inline with element
errorMessagePosition = 'inline'; // Can be either "top" or "inline"

scrollToTopOnError = true;
dateFormat = 'yyyy-mm-dd';
addValidClassOnAll = false; // whether or not to apply class="valid" even if the input wasn't validated
decimalSeparator = '.';
inputParentClassOnError = 'has-error'; // twitter-bootstrap default class name
inputParentClassOnSuccess = 'has-success'; // twitter-bootstrap default class name
validateHiddenInputs = false; // whether or not hidden inputs should be validated
inlineErrorMessageCallback = false;
submitErrorMessageCallback = false;
$win = $(window);


function validate($form, fv_button, auto_submit_form = true, handler_function = '') {

    if ($form.prop("tagName").toLowerCase() == 'form') {


        $form.on('submit', function (evt) {
            evt.stopImmediatePropagation();

            let syncValidations = new Promise(resolve => {
                var error = 0;
                $form.find('[data-validation]').each(function () {
                    var $input = $(this);

                    var result = validateInput($input, $form);
                    if (result['isValid'] == true) {
                        removeInputStylingAndMessage($input);
                    } else {
                        if (error == 0) {
                            $input.focus();
                        }
                        error++;
                        applyInputErrorStyling($input);
                        setInlineMessage($input, result['errorMsg']);
                    }
                });
                if (error > 0) {
                    resolve(false);
                } else {
                    resolve(true);
                }

            });
            syncValidations.then(function (validated) {

                if (validated)
                {
                    if (auto_submit_form == false) {

                        if (typeof window[handler_function] === "function") {
                            window[handler_function]();
                        } else {
                            initiateAjaxCall();
                        }

                    } else {
                        $('form').unbind('submit').submit();
                    }
                }
            });
            return false;
        });
    } else {
        //the user didnt give us a form so we route another algorithm
        //this case we demand a button

        $($form).on('click', fv_button, function (evt) {


            var error = 0;
            $form.find('[data-validation]').each(function () {
                var $input = $(this);

                var result = validateInput($input, $form);
                if (result['isValid'] == true) {
                    removeInputStylingAndMessage($input);
                } else {
                    error++;
                    applyInputErrorStyling($input);
                    setInlineMessage($input, result['errorMsg']);
                }
            });
            if (error > 0) {
                return false;
            } else {
                return true;
            }
        });

    }
    /*
     * fired on input and textarea
     */
    $form.on('blur', 'textarea[data-validation],input[data-validation]', function (evt) {
        //evt.stopImmediatePropagation();
        var $input = $(evt.target);
        var result = validateInput($input, $form);
        if (result['isValid'] == true) {
            removeInputStylingAndMessage($input);
        } else {
            applyInputErrorStyling($input);
            setInlineMessage($input, result['errorMsg']);
        }

    });
    /*
     * fired on selectbox and checkboxes and radios
     */
    $form.on('change', 'select[data-validation],checkbox[data-validation],radio[data-validation]', function (evt) {
        // evt.stopImmediatePropagation();
        var $input = $(evt.target);
        var result = validateInput($input, $form);
        if (result['isValid'] == true) {
            removeInputStylingAndMessage($input);
        } else {
            applyInputErrorStyling($input);
            setInlineMessage($input, result['errorMsg']);
        }
    });
    /*
     * fire on every change to input or textarea
     */
//    $form.on('input', 'input[data-validation],textarea[data-validation]', function (evt) {
//        // evt.preventDefault();
//        //evt.stopImmediatePropagation();
//        var $input = $(evt.target);
//        var result = validateInput($input, $form);
//        if (result['isValid'] == true) {
//            removeInputStylingAndMessage($input);
//        } else {
//            applyInputErrorStyling($input);
//            setInlineMessage($input, result['errorMsg']);
//        }
//    });
}


/*
 * 
 * @param {type} $elem
 * @param {type} $form
 * @returns {validateInput.result}
 * function to validate input
 */


function validateInput($elem, $form) {



    var validationRules = $elem.attr('data-validation');
    var isValid = true;
    var errorMsg = 'required';
    var result = {isValid: true, shouldChangeDisplay: true, errorMsg: ''};

    if ($elem.is(":hidden") || $elem.hasClass("ignoreMe")) {
        return result;
    }



    var rules_array = split(validationRules);


    $.each(rules_array, function (index, validation_function) {

        if (validation_function.indexOf('validate_') !== 0) {
            validation_function = 'validate_' + validation_function;
        }

        if (typeof window[validation_function] === "function") {
            isValid = window[validation_function]($elem, $form);

        } else {

        }


        if (!isValid) {

            errorMsg = resolveErrorMessage($elem, validation_function);
            return false; // break iteration
        }
    });


    if (isValid === false) {
        $elem.trigger('validation', false);
        result.errorMsg = errorMsg;
        result.isValid = false;
        result.shouldChangeDisplay = true;
    } else if (isValid === null) {
        // A validatorFunction returning null means that it's not able to validate
        // the input at this time. Most probably some async stuff need to gets finished
        // first and then the validator will re-trigger the validation.
        result.shouldChangeDisplay = false;
    } else {
        // $elem.trigger('validation', true);
        result.shouldChangeDisplay = true;
    }

    return result;
}


/*
 * 
 * @param {type} val
 * @param {type} callback
 * @param {type} allowSpaceAsDelimiter
 * @returns {Array|$.split.values|Object.values}
 * to retrieve validations to applied from inputs data-validation field
 */

function split(val, callback, allowSpaceAsDelimiter) {

    // default to true
    allowSpaceAsDelimiter = allowSpaceAsDelimiter === undefined || allowSpaceAsDelimiter === true;
    var pattern = '[,|' + (allowSpaceAsDelimiter ? '\\s' : '') + '-]\\s*',
            regex = new RegExp(pattern, 'g');

    // return array
    if (!val) {
        return [];
    }
    var values = [];
    $.each(val.split(callback ? callback : regex),
            function (i, str) {
                str = $.trim(str);
                if (str.length) {
                    values.push(str);
                }
            }
    );

    return values;

}
/*
 * 
 * @param {type} $elem
 * @param {type} validatorName
 * @returns {String}
 * describes the error messages
 */

function resolveErrorMessage($elem, validatorName) {
    var errorMsgAttr = 'data-validation-error-msg' + '-' + validatorName.replace('validate_', ''),
            validationErrorMsg = $elem.attr(errorMsgAttr);

    if (!validationErrorMsg) {
        validationErrorMsg = $elem.attr('data-validation-error-msg');
        if (!validationErrorMsg) {

            validationErrorMsg = 'This field is required';

        }
    }
    return validationErrorMsg;
}

/*
 * 
 * @param {type} $elem
 * @returns {getParentContainer.$parent}
 * function retrieves parent element of an input
 */
function getParentContainer($elem) {

    var $parent = $elem.parent();

    if ($elem[0].hasAttribute('data-validation-useCustomMessageDiv')) {
        let custom_message_div = $($elem).attr('data-validation-useCustomMessageDiv');
        if ($elem.closest(custom_message_div).length > 0) {
            var $parent = $elem.closest(custom_message_div);
        } else {
            if ($elem.attr('type') === 'checkbox' && $elem.closest('.checkbox').length) {
                $parent = $elem.closest('.checkbox').parent();
            } else if ($elem.attr('type') === 'radio' && $elem.closest('.radio').length) {
                $parent = $elem.closest('.radio').parent();
            }
            if ($parent.closest('.input-group').length) {
                $parent = $parent.closest('.input-group').parent();
            }
        }

    } else {
        if ($elem.closest("div.form-group").length > 0) {
            var $parent = $elem.closest("div.form-group");
        }
        if ($elem.attr('type') === 'checkbox' && $elem.closest('.checkbox').length) {
            $parent = $elem.closest('.checkbox').parent();
        } else if ($elem.attr('type') === 'radio' && $elem.closest('.radio').length) {
            $parent = $elem.closest('.radio').parent();
        }
        if ($parent.closest('.input-group').length) {
            $parent = $parent.closest('.input-group').parent();
        }
    }




    return $parent;
}


/*
 * 
 * @param {type} $input
 * @returns {undefined}
 * this will add classes and styles to errors
 */

function applyInputErrorStyling($input) {

    $input
            .addClass(errorElementClass)
            .removeClass(successElementClass);

    getParentContainer($input)
            .addClass(inputParentClassOnError)
            .removeClass(inputParentClassOnSuccess);

    if (borderColorOnError !== '') {
        $input.css('border-color', borderColorOnError);
        if ($($input).is("select") && $input.closest("div.form-group").find("div.selectric").length > 0) {
            $input.closest("div.form-group").find("div.selectric").css('border-color', borderColorOnError);
        }
    }
}

/*
 * 
 * @param {type} $input
 * @returns {undefined}
 * this will remove all classes messages and styles applied to a input
 */
function removeInputStylingAndMessage($input) {

    $input
            .removeClass(errorElementClass)
            .removeClass(successElementClass)
            .css('border-color', '');

    if ($($input).is("select") && $input.closest("div.form-group").find("div.selectric").length > 0) {
        $input.closest("div.form-group").find("div.selectric").removeClass(errorElementClass)
                .removeClass(successElementClass)
                .css('border-color', '');
        ;
    }


    var $parentContainer = getParentContainer($input);


    // Reset parent css
    $parentContainer
            .removeClass(inputParentClassOnError)
            .removeClass(inputParentClassOnSuccess)
            .css('border-color', '');

    //remove message
    $parentContainer.find('.' + errorMessageClass).remove();

}
/*
 * 
 * @param {type} $form
 * @returns {undefined}
 * destroys plugin
 */
function destroy($form) {

    // Remove input css/messages
    $form.find('.' + errorElementClass + ',.' + successElementClass).each(function () {
        removeInputStylingAndMessage($(this));
    });
}
/*
 * add error message
 */
function setInlineMessage($input, errorMsg) {

    var $parent = getParentContainer($input);
    $message = $parent.find('.' + errorMessageClass + '.help-block');

    if ($message.length === 0) {
        $message = $('<span>' + errorMsg + '</span>').addClass('help-block').addClass(errorMessageClass);
        $message.appendTo($parent);
    } else {
        $message.remove();
        $message = $('<span>' + errorMsg + '</span>').addClass('help-block').addClass(errorMessageClass);
        $message.appendTo($parent);
    }
}

function applyInputSuccessStyling($input) {
    $input.addClass(successElementClass);
    if ($($input).is("select") && $input.closest("div.form-group").find("div.selectric").length > 0) {
        $input.closest("div.form-group").find("div.selectric").addClass(successElementClass);
    }

    getParentContainer($input)
            .addClass(inputParentClassOnSuccess);
}
/*
 * validation functions begins
 */
function validate_required($el, $form) {


    switch ($el.prop("tagName").toLowerCase()) {
        case 'input':
            switch ($el.prop("type").toLowerCase()) {
                case 'text':
                    return $.trim($el.val()) !== '';
                    break;
                     case 'password':
                    return $.trim($el.val()) !== '';
                    break;
                     case 'email':
                    return $.trim($el.val()) !== '';
                    break;
                case 'checkbox':
                    return $el.is(':checked');
                    break;
                case 'radio':
                    return $form.find('input[name="' + $el.attr('name') + '"]').filter(':checked').length > 0;
                    break;
                default:
                    return false;
                    break;
            }
            break;
        case 'select':
            return $.trim($el.val()) !== '';
            break;
        case 'textarea':
            return $.trim($el.val()) !== '';
            break;
        default:
            return false;
            break;
    }


}
/**
 * 
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */

function validate_email($el, $form) {
    var email = $($el).val();
    if ($.trim(email) != '') {

        var re = /\S+@\S+\.\S+/;
        return re.test(email);

//        if (/^\w+([\.+\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
//        {
//            return true;
//        }
//        return false;
//        if (window.Worker) {
//
//            let promised = new Promise(function (resolve, reject) {
//                var my_worker = new Worker(base_url + "assets/plugins/jqueryValidate/email_validation_worker.js");
//                my_worker.postMessage(email);
//
//                my_worker.onmessage = function (e) {
//                    isfinished = true;
//                    status = e.data;
//                    resolve(e.data);
//                }
//            });
//
//        } else {
//
//            //if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
//            if (/^\w+([\.+\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
//            {
//                return true;
//            }
//            return false;
//
//        }
    } else {
        return true;
    }


}
/**
 * 
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */
function validate_onlyNumber($el, $form) {
    var number = $($el).val();
    if (number != '' && isNaN(number)) {
        return false;
    }
    return true;

}
/**
 * 
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */
function validate_domain($el, $form) {
    return val.length > 0 &&
            val.length <= 253 && // Including sub domains
            !(/[^a-zA-Z0-9]/.test(val.slice(-2))) && !(/[^a-zA-Z0-9]/.test(val.substr(0, 1))) && !(/[^a-zA-Z0-9\.\-]/.test(val)) &&
            val.split('..').length === 1 &&
            val.split('.').length > 1;
}
/**
 * Date should be passed as yyyy/mm/dd or yyyy-mm-dd
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */
function validate_date($el, $form) {
    let date = $el.val();
    if (date != '') {
        var isDate = function (date) {
            return (new Date(date) !== "Invalid Date") && !isNaN(new Date(date));
        }
        if (!isDate) {
            return false;
        }
    }
    return true;
}
/**
 * 
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */
function validate_number($el, $form) {
    let value = $el.val();
    if (value != '') {
        if (value.match(/^[0-9]+$/) != null) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}

/**
 * 
 * @param {type} $el
 * @param {type} $form
 * @return {Boolean}
 */
function validate_url($el, $form) {
    let value = $el.val();
    if (value != '') {
        var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        if (!pattern.test(value)) {
            return false;
        }
    }
    return true;
}
/**
 * UK POSTCODE VALIDATOR
 * @param {type} value
 * @return {Boolean}
 */
function postcode_valid_check(value) {

    var test = value;
    size = test.length
    test = test.toUpperCase(); //Change to uppercase

    while (test.slice(0, 1) == " ") {
        test = test.substr(1, size - 1);
        size = test.length
    }
    while (test.slice(size - 1, size) == " ") {
        test = test.substr(0, size - 1);
        size = test.length
    }
    if (size < 6 || size > 8) { //Code length rule
        return false;
    }
    if (!(isNaN(test.charAt(0)))) { //leftmost character must be alpha character rule
        return false;
    }
    if (isNaN(test.charAt(size - 3))) { //first character of inward code must be numeric rule
        return false;
    }
    if (!(isNaN(test.charAt(size - 2)))) { //second character of inward code must be alpha rule
        return false;
    }
    if (!(isNaN(test.charAt(size - 1)))) { //third character of inward code must be alpha rule
        return false;
    }
    // if (!(test.charAt(size-4) == " ")){//space in position length-3 rule
    //    return false;
    // }
    count1 = test.indexOf(" ");
    count2 = test.lastIndexOf(" ");

    if (count1 != count2) {//only one space rule
        return false;
    }
    return true;
}
/**
 * 
 * @param {type} evt
 * @param {type} object
 * @return {Boolean}
 */
function latlongKey(evt, object)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if ((String.fromCharCode(charCode) == "-" && object.value.indexOf("-") == -1) || (String.fromCharCode(charCode) == "+" && object.value.indexOf("+") == -1) || (String.fromCharCode(charCode) == "." && object.value.indexOf(".") == -1) || (/\d/g).test(String.fromCharCode(charCode)) || charCode == 8)
    {
        return true;
    } else
    {
        return false;
    }
}

/**
 * 
 * @param {type} evt
 * @param {type} object
 * @return {Boolean}
 */

function isNumberKey(evt, object)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if ((/\d/g).test(String.fromCharCode(charCode)) || charCode == 8)
    {
        return true;
    } else
    {
        return false;
    }
}

function validate_postcode($el, $form) {

    var test = $el.val();
    size = test.length
    test = test.toUpperCase(); //Change to uppercase

    while (test.slice(0, 1) == " ") {
        test = test.substr(1, size - 1);
        size = test.length
    }
    while (test.slice(size - 1, size) == " ") {
        test = test.substr(0, size - 1);
        size = test.length
    }
    if (size < 6 || size > 8) { //Code length rule
        return false;
    }
    if (!(isNaN(test.charAt(0)))) { //leftmost character must be alpha character rule
        return false;
    }
    if (isNaN(test.charAt(size - 3))) { //first character of inward code must be numeric rule
        return false;
    }
    if (!(isNaN(test.charAt(size - 2)))) { //second character of inward code must be alpha rule
        return false;
    }
    if (!(isNaN(test.charAt(size - 1)))) { //third character of inward code must be alpha rule
        return false;
    }
    // if (!(test.charAt(size-4) == " ")){//space in position length-3 rule
    //    return false;
    // }
    count1 = test.indexOf(" ");
    count2 = test.lastIndexOf(" ");

    if (count1 != count2) {//only one space rule
        return false;
    }
    return true;
}