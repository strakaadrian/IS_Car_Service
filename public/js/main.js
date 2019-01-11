$(document).ready(function() {

    /*
     *taham ID z service na ktore kliknu uzivatel a posielam ho orderService metode v ServiceController
    */
    $('.service-order-button').click(function() {
        if(confirm(" Prajete si pokračovať na objednácku služby ? Pozor musíte byť prihlásený! ")) {
            const $id = this.id;
            window.location.href = 'service/order-service/' + $id;
        }
    });

});