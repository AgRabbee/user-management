function customAlertBox(icon, title, msg, showCancel, confirmBtnText) {
    return Swal.fire({
        icon: icon,
        title: title,
        text: msg,
        showCancelButton: showCancel,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmBtnText,
        reverseButtons: true,
        showCloseButton: true,
    });
}

function toaster(icon, msg, timer = 1000) {
    Toast.fire({
        icon: icon,
        text: ' '+msg,
        timer: timer,
    });
}


function convert2Bangla(engVal) {
    engVal = engVal.toString();
    engVal = engVal.replaceAll("0", "০");
    engVal = engVal.replaceAll("1", "১");
    engVal = engVal.replaceAll("2", "২");
    engVal = engVal.replaceAll("3", "৩");
    engVal = engVal.replaceAll("4", "৪");
    engVal = engVal.replaceAll("5", "৫");
    engVal = engVal.replaceAll("6", "৬");
    engVal = engVal.replaceAll("7", "৭");
    engVal = engVal.replaceAll("8", "৮");
    engVal = engVal.replaceAll("9", "৯");
    return engVal;
}

function convert2English(banVal) {
    banVal = banVal.toString();
    banVal = banVal.replaceAll("০", "0");
    banVal = banVal.replaceAll("১", "1");
    banVal = banVal.replaceAll("২", "2");
    banVal = banVal.replaceAll("৩", "3");
    banVal = banVal.replaceAll("৪", "4");
    banVal = banVal.replaceAll("৫", "5");
    banVal = banVal.replaceAll("৬", "6");
    banVal = banVal.replaceAll("৭", "7");
    banVal = banVal.replaceAll("৮", "8");
    banVal = banVal.replaceAll("৯", "9");
    banVal = banVal.replaceAll("|", ".");
    return banVal;
}

function convert2BanglaMonth(engVal) {
    engVal = engVal.toString();
    engVal = engVal.replaceAll("1", "জানুয়ারী");
    engVal = engVal.replaceAll("2", "ফেব্রুয়ারি");
    engVal = engVal.replaceAll("3", "মার্চ");
    engVal = engVal.replaceAll("4", "এপ্রিল");
    engVal = engVal.replaceAll("5", "মে");
    engVal = engVal.replaceAll("6", "জুন");
    engVal = engVal.replaceAll("7", "জুলাই");
    engVal = engVal.replaceAll("8", "আগস্ট");
    engVal = engVal.replaceAll("9", "সেপ্টেম্বর");
    engVal = engVal.replaceAll("10", "অক্টোবর");
    engVal = engVal.replaceAll("11", "নভেম্বর");
    engVal = engVal.replaceAll("12", "ডিসেম্বর");
    return engVal;
}

function isInArray(value, array) {
    return array.indexOf(value) > -1;
}

function encryption(givenData) {
    let urlCrypt = require('url-crypt')('~{ry*I)==yU/]9<7DPk!Hj"R#:-/Z7(hTBnlRS=4CXF');
    return urlCrypt.cryptObj(givenData);
}

function decryption(givenData) {
    let urlCrypt = require('url-crypt')('~{ry*I)==yU/]9<7DPk!Hj"R#:-/Z7(hTBnlRS=4CXF');
    return urlCrypt.decryptObj(givenData);
}

function sweetAlertToastNotification(thisObj, position, timer, showProgressBar, icon, title) {

    const Toast = thisObj.$swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        showCloseButton: true,
        allowEscapeKey: true,
        allowOutsideClick: true,
        timerProgressBar: showProgressBar,
        icon: icon,
        title: title,
        /*showClass: {
            popup: 'animate__animated animate__fadeOutLeft'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutRight'
        }*/
        customClass: {
            title: 'text-sm',
        }
    })

    let customObj = {};
    if (timer == true) {
        customObj = {
            timer: 2500,
        }
    }
    Toast.fire(customObj);
}

function sweetAlertBox(thisObj, title) {
    return thisObj.$swal.fire({
        text: title,
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'হ্যাঁ',
        cancelButtonText: 'না',
        customClass: {
            /*container: 'your-container-class',
            popup: 'your-popup-class',
            header: 'your-header-class',
            closeButton: 'your-close-button-class',
            icon: 'your-icon-class',
            image: 'your-image-class',
            content: 'your-content-class',
            input: 'your-input-class',
            actions: 'your-actions-class',
            confirmButton: 'your-confirm-button-class',
            cancelButton: 'your-cancel-button-class',
            footer: 'your-footer-class',*/
            confirmButton: 'bg-success px-3 py-1',
            cancelButton: 'bg-danger px-3 py-1'
        }
    });
}

function customSweetAlertBox(thisObj, title) {
    return thisObj.$swal.fire({
        html: title,
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonText: 'বাতিল',
        confirmButtonText: 'পরবর্তী',
        customClass: {
            /*container: 'your-container-class',
            popup: 'your-popup-class',
            header: 'your-header-class',
            closeButton: 'your-close-button-class',
            icon: 'your-icon-class',
            image: 'your-image-class',
            content: 'your-content-class',
            input: 'your-input-class',
            actions: 'your-actions-class',
            confirmButton: 'your-confirm-button-class',
            cancelButton: 'your-cancel-button-class',
            footer: 'your-footer-class',*/
            cancelButton: 'bg-danger px-3 py-1',
            confirmButton: 'bg-success px-3 py-1'

        }

    });
}

function sweetAlertInformativeBox(thisObj, text, confirmButtonText = null) {
    return thisObj.$swal.fire({
        text: text,
        confirmButtonText: (confirmButtonText == null) ? 'হ্যাঁ' : confirmButtonText,
        customClass: {
            confirmButton: 'bg-success px-3 py-1',
        }
    })
}

function sweetAlertForRemoveButton(thisObj, title) {
    return thisObj.$swal.fire({
        html: title,
        confirmButtonText: 'ওকে',
        customClass: {
            confirmButton: 'bg-success px-3 py-1',
        }

    });
}

function sweetAlertWithInput(thisObj, title) {
    return thisObj.$swal.fire({
        title: title,
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: false,
        confirmButtonText: 'সাবমিট',
        showLoaderOnConfirm: true,
        width: '400px',
        customClass: {
            cancelButton: 'bg-danger px-3 py-1',
            confirmButton: 'bg-success px-3 py-1',
            title: 'm-0',
            actions: 'm-0',
            input: 'input_bangla',
        },
        inputValidator: function (value) {
            if (value === '') {
                return 'জমির বাজার মূল্য দিতে হবে'
            } else {
                var format = /^(\d*\.)?\d+$/;
                if (!format.test(value)) {
                    return 'বাজার মূল্য সংখ্যায় হতে হবে'
                }
            }
        }

    });
}


