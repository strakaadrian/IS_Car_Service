$(document).ready(function() {

    /*
     na uvod schovam warningy
    */
    $('.error-order-div').hide();
    $('.error-profile-div').hide();
    $('.error-facturation-div').hide();
    $('.contact-box').hide();


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

    // skontrolujeme ci uzivatel zadava spravne fakturacne udaje pri INSERTE
    $('#submit-facturation-button').click(function () {
        $town_id = $('#psc').val();
        $town_name = $('#town').val();
        $country_id = $('#country_id').val();


        if($('#town').val() == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Mesto');
            return false;
        } else if ($('#psc').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - PSČ');
            return false;
        } else if ($('#rc').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Rodné číslo');
            return false;
        } else if ($('#name').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Meno');
            return false;
        } else if ($('#surname').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Priezvisko');
            return false;
        } else if ($('#street').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Ulica');
            return false;
        } else if ($('#orientation_no').val()  == '') {
            $('.error-facturation-div').show();
            $('#error-facturation-msg').text('Zadajte hodnotu do pola - Číslo domu');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "../../profile/checkDataProfile",
                dateType: 'json',
                data: {town_id: $town_id, town_name: $town_name, country_id: $country_id },
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult[0].result == 0) {
                        $('.error-facturation-div').show();
                        $('#error-facturation-msg').text('Zadávate zlé hodnoty do polí ( Štát, Mesto alebo PSČ ).');
                        return false;
                    }
                    alert('Úspešne ste vytvorili svoje fakturačné údaje.');
                    $('#facturation-id').submit();
                }
            });
        }
        $('.error-facturation-div').hide();
    });



    // skontrolujeme ci uzivatel zadava spravne fakturacne udaje pri UPDATE
    $('#submit-profile-button').click(function () {
        $town_id = $('#psc').val();
        $town_name = $('#town').val();
        $country_id = $('#country_id').val();


        if($('#town').val() == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - Mesto');
            return false;
        } else if ($('#psc').val()  == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - PSČ');
            return false;
        } else if ($('#name').val()  == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - Meno');
            return false;
        } else if ($('#surname').val()  == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - Priezvisko');
            return false;
        } else if ($('#street').val()  == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - Ulica');
            return false;
        } else if ($('#orientation_no').val()  == '') {
            $('.error-profile-div').show();
            $('#error-profile-msg').text('Zadajte hodnotu do pola - Číslo domu');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "profile/checkDataProfile",
                dateType: 'json',
                data: {town_id: $town_id, town_name: $town_name, country_id: $country_id },
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult[0].result == 0) {
                        $('.error-profile-div').show();
                        $('#error-profile-msg').text('Zadávate zlé hodnoty do polí ( Štát, Mesto alebo PSČ ).');
                        return false;
                    }
                    alert('Úspešne ste aktualizovali svoje fakturačné údaje.');
                    $('#profile-id').submit();
                }
            });
        }
        $('.error-profile-div').hide();
    });


    // tato funckia sa spusti ak si uzivatel vyberie iny autoservis
    $("#car_service_contact").change(function() {

        $ico = $('#car_service_contact').val();

        $.ajax({
            type: "POST",
            url: "contact/getCarServiceByIco",
            dateType: 'json',
            data: {ico: $ico},
            success: function (data) {
                $dataResult = JSON.parse(data);
                $('.contact-box').show();
                $('#service-town').text($dataResult[0].town_name);
                $('#service-name').text($dataResult[0].service_name);
                $('#service-street').text($dataResult[0].street);
                $('#service-oc').text($dataResult[0].orientation_no);
                $('#service-phone').text($dataResult[0].phone_number);
                $('#service-email').text($dataResult[0].contact);
            }
        });
    });




});