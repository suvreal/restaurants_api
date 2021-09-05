/*Initialize variables of environment*/
var returnDataRawBtn = document.getElementById("api-rec-all-toggle");
var returnDataRawCont = document.getElementById("api-return-data-raw");
var returnDataRawBtnVisOff = document.getElementById("visibility-off-maticon");
var returnDataRawBtnVisOn = document.getElementById("visibility-on-maticon");

/*Catch & perform tasks according to event call*/
if (returnDataRawBtn) {
    returnDataRawBtn.onclick = function() {
        if (returnDataRawCont.classList.contains("display-none")) {
            returnDataRawCont.classList.remove("display-none");
            returnDataRawBtnVisOn.classList.add("display-none");
            returnDataRawBtnVisOff.classList.remove("display-none");
        } else {
            returnDataRawCont.classList.add("display-none");
            returnDataRawBtnVisOn.classList.remove("display-none");
            returnDataRawBtnVisOff.classList.add("display-none");
        }
    };
}