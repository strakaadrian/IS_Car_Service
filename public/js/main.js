$(document).ready(function() {

    /*
     na uvod schovam warningy
    */
    $('.error-order-div').hide();
    $('.error-profile-div').hide();
    $('.error-facturation-div').hide();
    $('.contact-box').hide();
    $('.shopping-cart-error').hide();

    $('#car_type_select').hide();
    $('#car_part_select').hide();
    $('.error-products').hide();
    $('#submit-products-button').hide();

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


    // tato funkcia mi skontroluje mnozstvo v kosiku ktore menim ci je povoelene robit taku zmenu
    $(".shopping-cart-quantity").change(function() {

        $id = this.id;
        $valueOld  = parseInt(this.defaultValue);
        $value = parseInt(this.value);
        $max = parseInt($(this).attr('max'));
        $min = parseInt($(this).attr('min'));


        if($max == 0) {
            $('.shopping-cart-error').show();
            $('#shopping-cart-error-msg').text('Tovar je vypredaný.');
            return false;
        } else if($value > $max) {
            $('.shopping-cart-error').show();
            $('#shopping-cart-error-msg').text('Maximálny počet KS na sklade je : ' + $max);
            this.value = $valueOld;
            return false;
        } else if($value <= 0) {
            $('.shopping-cart-error').show();
            $('#shopping-cart-error-msg').text('Minimány počet, ktorý môžte zadate je: ' + $min + ' KS');
            this.value = $valueOld;
            return false;
        } else {
            $('.shopping-cart-error').hide();

            if(confirm('Prajete si zmenit množstvo na ' +  $value + ' ?')) {
                $.ajax({
                    type: "POST",
                    url: "cart/insertIntoShoppingCart",
                    dateType: 'json',
                    data: {car_part_id: $id, quantity: $value},
                    success: function (data) {
                        location.reload();
                    }
                });

            }
        }
    });

    // tato funckia nam zmaze produkt z nakupneho kosika
    $('.shopping-cart-delete-button').click(function() {
        $car_part_id = parseInt($(this).attr('value'));

        if(confirm('Prajete si daný produkt odstrániť z košíka ?')) {
            $.ajax({
                type: "POST",
                url: "cart/deleteItemFromCart",
                dateType: 'json',
                data: {car_part_id: $car_part_id},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });


    // funkcia, ktora nam zobrazi modely aut pre danu značku
    $("#car_brand").change(function() {
        $('#car_type').empty();
        $car_brand = this.value;

        $.ajax({
            type: "POST",
            url: "products/getCarModels",
            dateType: 'json',
            data: {car_brand: $car_brand},
            success: function (data) {
                $dataResult = JSON.parse(data);
                if($dataResult.length == 0) {
                    $('.error-products').show();
                    $('#error-products-not-found').text('Pre danú značku auta nemáme dostupné modely áut.');
                    $('#car_type_select').hide();
                    $('#car_part_select').hide();
                    $("#submit-products-button").hide();
                } else {
                    $('.error-products').hide();
                    $.each($dataResult, function () {
                        $("<option/>").val(this.car_type_id).text(this.car_type_name).appendTo("#car_type");
                    });
                    $('#car_type_select').show();
                    $('#submit-products-button').show();
                }
            }
        });
    });

    // funkcia, ktora nam zobrazi autodieli na zaklade daneho modelu
    $("#car_type").click(function() {
        $('#car_part').empty();
        $car_type = this.value;

        $.ajax({
            type: "POST",
            url: "products/getCarParts",
            dateType: 'json',
            data: {car_type: $car_type},
            success: function (data) {
                $dataResult = JSON.parse(data);

                if($dataResult.length == 0) {
                    $('.error-products').show();
                    $('#error-products-not-found').text('Pre daný model auta momentálne nemáme dostupné autosúčiastky.');
                    $('#car_part_select').hide();
                    $('#products-check-all').hide();
                    $("#submit-products-button").hide();
                } else {
                    $('.error-products').hide();
                    $.each($dataResult, function () {
                        $("<option/>").val(this.car_part_id).text(this.part_name).appendTo("#car_part");
                    });
                    $('#car_part_select').show();
                    $('#products-check-all').show();
                    $("#submit-products-button").show();
                }
            }
        });
    });

    // funkcia, ktorá na základe daných parametrov vyhľadá autosúčiastky

    $("#submit-products-button").click(function() {
        $brand_id = $('#car_brand').val();
        $car_type_id = $('#car_type').val();
        $car_part_id = $('#car_part').val();
        $all_parts = $('#products-check-all').is( ":checked" );

        if($car_part_id == "") {
            $all_parts = true;
        }
        $.ajax({
            type: "POST",
            url: "products/getCarPartsForSale",
            dateType: 'json',
            data: {brand_id: $brand_id, car_type_id: $car_type_id, car_part_id: $car_part_id, all_parts: $all_parts},
            success: function (data) {
                $('.products-items').html(data.html);
            }
        });
    });
});