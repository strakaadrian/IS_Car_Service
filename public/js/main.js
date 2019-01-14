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
        $ico = $('#car_service').val();
        $date = $('#date').val();
        $hour = $('#hour').val();


        if($date == "") {
            $('.error-order-div').show();
            $('#error-order-msg').text('Prosím, zadajte dátum!');
            return false;
        } else {
            // overi nam podmienky, potrebne na to aby sme mohli pridat rezervaciu
            $.ajax({
                type: "POST",
                url: "checkInsertReservCond",
                dateType: 'json',
                data: {ico: $ico ,id: $id, date: $date, hour: $hour},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "bad emp") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale technik, ktorý vykonáva danú službu sa v tomto autoservise nenachádza. Vyberte si iný autoservis.');
                        return false;
                    } else if($dataResult == "wrong day") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale deň, ktorý ste si vybrali je neplatný. Prosím vyberte dátum PO aktuálnom dátume.');
                        return false;
                    } else if ($dataResult == "weekend") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale deň, ktorý ste si vybrali je víkend. Vyberte si prosím iný deň.');
                        return false;
                    } else if ($dataResult == "absence") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale technik sa v tento deň nenachádza v práci.');
                        return false;
                    } else if ($dataResult == "work time") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale na danú hodinu sa nedá objednať, zadajte inú hodinu.');
                        return false;
                    } else if ($dataResult == "reserved") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale daná hodina je už rezervovaná, prosím zvolte inú.');
                        return false;
                    } else {
                        alert('Úspešne ste vytvorili rezerváciu.')
                        $('#order-service-id').submit();
                    }
                }
            });
        }
        $('.error-order-div').hide();
    });
});