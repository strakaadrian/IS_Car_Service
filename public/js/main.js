$(document).ready(function() {

    /*
     na uvod schovam warningy
    */
    $('.error-order-div').hide();


    /* toto tu je potrebne aby ajax POST fungoval spravne */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*
     *taham ID z service na ktore kliknu uzivatel a posielam ho orderService metode v ServiceController
    */
    $('.service-order-button').click(function() {
        if(confirm(" Prajete si pokračovať na objednácku služby ? Pozor musíte byť prihlásený! ")) {
            const $id = this.id;
            window.location.href = 'service/order-service/' + $id;
        }
    });


    /*Tato funkcia sluzi na zistenie ci sa uzivatel moze rezervovat do daneho autoservisu */
    $('#submit-order-button').click(function () {
        $id = $("#id").val();

        // zisti, ci mam technika na danu sluzbu
        $.ajax({
            type: "POST",
            url: "getEmployeeByWorkPosition",
            dateType: 'json',
            data: {id: $id},
            success: function (data) {
                if(data == '[]') {
                    $('.error-order-div').show();
                    $('#error-order-msg').text('Prepáčte, ale technik, ktorý vykonáva danú službu sa v tomto autoservise nenachádza');
                }
            }
        });


    });

});