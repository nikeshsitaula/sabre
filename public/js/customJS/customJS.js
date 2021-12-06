function hideErrorMessage() {
    setTimeout(function(){
        $('span[aria-hidden="true"]').trigger('click');
    }, 3000);
}
