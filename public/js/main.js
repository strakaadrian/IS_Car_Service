$(document).ready(function() {

    $(document).keypress(function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    });


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
    $('.error-new-emp-div').hide();
    $('.update-emp').hide();
    $('.error-add-car-brand-div').hide();
    $('.error-add-car-type-div').hide();
    $('#car_type_parts_div').hide();
    $('.error-add-car-parts-div').hide();
    $('.error-add-new-service-div').hide();




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
                    } else if ($dataResult == "too far") {
                        $('.error-order-div').show();
                        $('#error-order-msg').text('Prepáčte, ale môžete si výbrať deň maximálne pol roka dopredu.');
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
        $rc =  $('#rc').val();


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
                url: "../../customer/checkDataCustomer",
                dateType: 'json',
                data: {town_id: $town_id, town_name: $town_name, country_id: $country_id,identification_no: $rc},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "wrong_location") {
                        $('.error-facturation-div').show();
                        $('#error-facturation-msg').text('Zadávate zlé hodnoty do polí ( Štát, Mesto alebo PSČ ).');
                        return false;
                    } else if($dataResult == "duplicate_customer") {
                        $('.error-facturation-div').show();
                        $('#error-facturation-msg').text('Zákazník už existuje.');
                        return false;
                    }
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
                    url: "cart/updateDataInShoppingCart",
                    dateType: 'json',
                    data: {car_part_id: $id, quantity: $value},
                    success: function (data) {
                        location.reload();
                    }
                });

            }
        }
    });


    // zabranuje stlačeniu enter na zmenu množstva
    $('.shopping-cart-quantity').keypress(function (event) {
        if (event.keyCode === 10 || event.keyCode === 13) {
            event.preventDefault();
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


    // táto funkcia nám skontroluje množstvo produktu, ktoré môžme dať do košíka na základe množstva na sklade
    $('body').on('change','.product-quantity',function(){
        $id = this.id;
        $valueOld  = parseInt(this.defaultValue);
        $value = parseInt(this.value);
        $max = parseInt($(this).attr('max'));
        $min = parseInt($(this).attr('min'));

        if($value > $max) {
            $('#error-product-quantity-' + $id).show();
            $('#error-product-quantity-' + $id).text("Zadávate zlé množstvo!");
            this.value = $valueOld;
            return false;
        } else if ($value <= 0) {
            $('#error-product-quantity-' + $id).show();
            $('#error-product-quantity-' + $id).text("Zadávate zlé množstvo!");
            this.value = $valueOld;
            return false;
        } else {
            $('#error-product-quantity-' + $id).hide();
            return false;
        }
    });

    // funkcia ktorá prídá produkt do košíka
    $('body').on('click','.product-item-to-cart',function(){
        $car_part_id = this.id;
        $quantity = $('#' + this.id).val();

        $.ajax({
            type: "POST",
            url: "cart/addItemToShoppingCart",
            dateType: 'json',
            data: {car_part_id: $car_part_id, quantity: $quantity},
            success: function (data) {
                confirm("Pridali ste súčiastku do košíka.");
            }
        });
    });


    // funkcia, ktorá sa spustí ak chce užívateľ potvrdiť obsah košíka
    $("#confirm-shopping-cart").click(function() {

        $order_id = $('#order_id_form').val();

        if(confirm("Prajete si zaplatiť obsah košíka ?")) {
            $.ajax({
                type: "POST",
                url: "cart/confirmShoppingCart",
                dateType: 'json',
                data: {order_id: $order_id},
                success: function () {
                    confirm("Úspešne ste potvrdili obsah košíka.");
                    window.location.href = "/";
                }
            });
        }
    });

    // Funkcia, ktorá odstráni danú zákazníkovu rezerváciu

    $(".reservation-delete-button").click(function() {

        $reservation_id = this.id;

        if(confirm("Prajete si odstrániť danú rezerváciu ?")) {
            $.ajax({
                type: "POST",
                url: "reservation/delete-reservation",
                dateType: 'json',
                data: {reservation_id: $reservation_id},
                success: function () {
                    location.reload();
                }
            });
        }
    });

    // skontrolujeme ci administrator zadave spravne udaje pri pridavani zamestnanca
    $('#submit-new-emp-button').click(function () {
        $town_id = $('#psc').val();
        $town_name = $('#town').val();
        $country_id = $('#country_id').val();

            $.ajax({
                type: "POST",
                url: "../profile/checkDataProfile",
                dateType: 'json',
                data: {town_id: $town_id, town_name: $town_name, country_id: $country_id},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult[0].result == 0) {
                        $('.error-new-emp-div').show();
                        $('#error-new-emp-msg').text('Zadávate zlé hodnoty do polí ( Štát, Mesto alebo PSČ ).');
                        return false;
                    }
                    alert('Úspešne ste vytvorili nového zamestnanca.');
                    $('#new-employee-id').submit();
                }
            });
        $('.error-new-emp-div').hide();
    });

    // dotiahnem zamestnanca na zaklade RC aby ho administrator mohol updatnut
    $('#update-rc').change(function () {
        $rc = $('#update-rc').val();
        $haha = $('#town').val();

        if($rc != "") {
            $.ajax({
                type: "POST",
                url: "update-employee/getEmployeeData",
                dateType: 'json',
                data: {rc: $rc},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    $('#country_id').val($dataResult[0].country_id);
                    $('#town').val($dataResult[0].town_name);
                    $('#psc').val($dataResult[0].town_id);
                    $('#name').val($dataResult[0].first_name);
                    $('#surname').val($dataResult[0].last_name);
                    $('#street').val($dataResult[0].street);
                    $('#orientation_no').val($dataResult[0].orientation_no);
                    $('#position').val($dataResult[0].work_position);
                    $('#hour_start').val($dataResult[0].working_hour_start);
                    $('#hour_end').val($dataResult[0].working_hour_end);
                    $('#price_per_hour').val($dataResult[0].price_per_hour);

                    $('.update-emp').show();
                }
            });
        } else {
            $('.update-emp').hide();
        }
    });


    // funkcia, ktora zobrazi absencie daneho zamestnanca
    $("#absence-employee").change(function() {

        $rc = $('#absence-employee').val();

        if($rc != "") {
            $.ajax({
                type: "POST",
                url: "absence/employee/employeeAbsence",
                dateType: 'json',
                data: {rc: $rc},
                success: function (data) {
                    $('#absence-extension').html(data.html);
                }
            });
        }
    });

    // funkcia, ktora zmaze danu absenciu zamestnanca
    $('body').on('click','.absence-delete-button',function(){
        $absence_id = parseInt($(this).attr('value'));

        if(confirm('Prajete si zrušiť absenciu zamestnancovi ?')) {
            $.ajax({
                type: "POST",
                url: "absence/employee/deleteEmployeeAbsence",
                dateType: 'json',
                data: {absence_id: $absence_id},
                success: function (data) {
                    $("#absence-employee").trigger("change");
                }
            });
        }
    });

    // funkcia, ktora zmaze danu absenciu zamestnanca
    $('body').on('click','#submit-absence-button',function(){
        $rc = $('#absence-employee').val();
        $absence_from = $('#absence_from').val();
        $absence_to = $('#absence_to').val();

        $dateFrom = new Date($absence_from);
        $dateTo = new Date($absence_to);

        if( ($absence_from == "") || ($absence_to == "") ) {
            $('#error-absence-msg').text('Prosím vyplnte oba formuláre dátum absencie.');
            $('.error-absence-div').show();
            return false;
        } else if($dateFrom > $dateTo) {
            $('#error-absence-msg').text('Dátum začiatku absencie musí býť menši alebo rovný ako dátum ukončenia absencie.');
            $('.error-absence-div').show();
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "absence/employee/addAbsence",
                dateType: 'json',
                data: {identification_no: $rc, absence_from: $absence_from, absence_to: $absence_to},
                success: function (data) {
                    $("#absence-employee").trigger("change");
                    $('.error-absence-div').hide();
                }
            });

        }
    });

    // prida noveho zakaznika
    $('#submit-new-cust-button').click(function () {
        $town_id = $('#psc').val();
        $town_name = $('#town').val();
        $country_id = $('#country_id').val();
        $rc = $('#rc').val();

        if($('#town').val() == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Mesto');
            return false;
        } else if ($('#psc').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - PSČ');
            return false;
        } else if ($('#rc').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Rodné číslo');
            return false;
        } else if ($('#name').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Meno');
            return false;
        } else if ($('#surname').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Priezvisko');
            return false;
        } else if ($('#street').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Ulica');
            return false;
        } else if ($('#orientation_no').val()  == '') {
            $('.error-new-cust-div').show();
            $('#error-new-cust-msg').text('Zadajte hodnotu do pola - Číslo domu');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "add-customer/checkData",
                dateType: 'json',
                data: {town_id: $town_id, town_name: $town_name, country_id: $country_id, rc: $rc},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "bad town") {
                        $('.error-new-cust-div').show();
                        $('#error-new-cust-msg').text('Zadávate zlé hodnoty do polí ( Štát, Mesto alebo PSČ ).');
                        return false;
                    } else if ($dataResult == "duplicate") {
                        $('.error-new-cust-div').show();
                        $('#error-new-cust-msg').text('Zákazník už existuje. ');
                        return false;
                    } else {
                        alert('Úspešne ste pridali zákazníka.');
                        $('#new-customer-id').submit();
                    }
                }
            });
        }
        $('.error-new-cust-div').hide();
    });


    // zmažeme danu rezerváciu
    $('.reservation-delete-admin').click(function () {
        $reservation_id = this.id;

        if(confirm('Prajete si zmazať rezerváciu ?')) {
            $.ajax({
                type: "POST",
                url: "admin-reservations/deleteReservation",
                dateType: 'json',
                data: {reservation_id: $reservation_id},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });


    // funkcia, ktora dotiahne pocet hodin na danej rezervacii
    $(".complete-reservation-id").change(function() {
        $reservation_id = parseInt($('#reservation_id').val());

            if(!isNaN($reservation_id)) {
                $.ajax({
                    type: "POST",
                    url: "admin-reservations/getWorkHours",
                    dateType: 'json',
                    data: {reservation_id: $reservation_id},
                    success: function (data) {
                        $dataResult = JSON.parse(data);
                        $('.complete-reservation-hours').val($dataResult[0].work_hours);
                    }
                });
            } else {
                $('.complete-reservation-hours').val("");
            }
    });

    // funkcia, ktora dotiahne pocet kusov danej suciastky na sklade
    $(".car-part-id-update").change(function() {
        $car_part_id = parseInt($('#car_part_id').val());

        if(!isNaN($car_part_id)) {
            $.ajax({
                type: "POST",
                url: "watch-car-parts/getCarPartStock",
                dateType: 'json',
                data: {car_part_id: $car_part_id},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    $('.stock-car-part').val($dataResult[0].stock);
                }
            });
        } else {
            $('.stock-car-part').val("");
        }
    });

    // skontrolujem a pridam novu car brand
    $('#button-add-car-brand').click(function (e) {
        $brand_name = $('#car_brand').val();

        if($('#car_brand').val() == "") {
            $('.error-add-car-brand-div').show();
            $('#error-add-car-brand-msg').text('Zadajte hodnotu do pola - Značka auta.');
            return false;
        } else if($('#car_brand').val().length > 30) {
            $('.error-add-car-brand-div').show();
            $('#error-add-car-brand-msg').text('Dĺžka značky, ktorú ste zadali je príliš dlhá, prosím zadajte kratšiu.');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "administrate-car-parts/checkCarBrandByName",
                dateType: 'json',
                data: {brand_name: $brand_name},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "duplicate") {
                        $('.error-add-car-brand-div').show();
                        $('#error-add-car-brand-msg').text('Značka auta už existuje.');
                        return false;
                    } else {
                        alert('Úspečne ste pridali novú značku auta.');
                        $('#submit-add-car-brand').submit();
                    }
                }
            });
        }
        $('.error-add-car-brand-div').hide();
    });

    // skontrolujem a pridam novy car type
    $('#button-add-car-type').click(function (e) {
        $car_type_name = $('#car_type_add').val();
        $brand_id = $('#car_brand_all').val();

        if($('#car_brand_all').val() == "") {
            $('.error-add-car-type-div').show();
            $('#error-add-car-type-msg').text('Zadajte hodnotu do pola - Značka auta.');
            return false;
        } else if($('#car_type_add').val() == "") {
            $('.error-add-car-type-div').show();
            $('#error-add-car-type-msg').text('Zadajte hodnotu do pola - Model auta.');
            return false;
        } else if($('#car_type_add').val().length > 100) {
            $('.error-add-car-type-div').show();
            $('#error-add-car-type-msg').text('Dĺžka modelu, ktorú ste zadali je príliš dlhá, prosím zadajte kratší názov.');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "administrate-car-parts/checkCarType",
                dateType: 'json',
                data: {brand_id: $brand_id, car_type_name: $car_type_name},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "duplicate") {
                        $('.error-add-car-type-div').show();
                        $('#error-add-car-type-msg').text('Model auta už existuje.');
                        return false;
                    } else {
                        alert('Úspečne ste pridali nový model auta.');
                        $('#submit-add-car-type').submit();
                    }
                }
            });
        }
        $('.error-add-car-type-div').hide();
    });


    // funkcia, ktora nam zobrazi modely aut pre danu značku
    $("#car_brand_parts").change(function() {
        $('#car_type_parts').empty();
        $car_brand_parts = this.value;

        $.ajax({
            type: "POST",
            url: "administrate-car-parts/getCarTypes",
            dateType: 'json',
            data: {car_brand_parts: $car_brand_parts},
            success: function (data) {
                $dataResult = JSON.parse(data);
                if($dataResult.length == 0) {
                    $('.error-add-car-parts-div').show();
                    $('#error-add-car-parts-msg').text('Pre danú značku nemáme žiadne modely áut. Prosím najskvôr vytvorte model pre danú značku.');
                    $('#car_type_parts_div').hide();
                    return false;
                } else {
                    $('.error-products').hide();
                    $.each($dataResult, function () {
                        $("<option/>").val(this.car_type_id).text(this.car_type_name).appendTo("#car_type_parts");
                    });
                    $('#car_type_parts_div').show();
                    $('.error-add-car-parts-div').hide();
                }
            }
        });
    });


    // skontrolujem a pridam novu autosuciastku

    $('#button-add-car-parts').click(function (e) {

        $car_type_parts = $('#car_type_parts').val();
        $car_part_name  = $('#car_part_name').val();

        if($('#car_brand_parts').val() == "") {
            $('.error-add-car-parts-div').show();
            $('#error-add-car-parts-msg').text('Zadajte hodnotu do pola - Značka auta.');
            return false;
        } else if( ($('#car_type_parts').val() == "") || ($('#car_type_parts').val() == null)) {
            $('.error-add-car-parts-div').show();
            $('#error-add-car-parts-msg').text('Zadajte hodnotu do pola - Model auta.');
            return false;
        } else if($('#car_part_name').val() == "") {
            $('.error-add-car-parts-div').show();
            $('#error-add-car-parts-msg').text('Zadajte hodnotu do pola - Názov autosúčiastky.');
            return false;
        } else if($('#part_price').val() == "") {
                $('.error-add-car-parts-div').show();
                $('#error-add-car-parts-msg').text('Zadajte hodnotu do pola - Cena.');
                return false;
        } else if($('#stock').val() == "")  {
            $('.error-add-car-parts-div').show();
            $('#error-add-car-parts-msg').text('Zadajte hodnotu do pola - Počet KS na sklade.');
            return false;
        } else if ($('#image').val() == "") {
            $('.error-add-car-parts-div').show();
            $('#error-add-car-parts-msg').text('Prosím vložte obrázok.');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "administrate-car-parts/checkCarPart",
                dateType: 'json',
                data: {car_type_parts: $car_type_parts, car_part_name: $car_part_name},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "duplicate") {
                        $('.error-add-car-parts-div').show();
                        $('#error-add-car-parts-msg').text('Autosúčiastka už existuje.');
                        return false;
                    } else{
                        $('#submit-add-car-part').submit();
                        $('.error-add-car-parts-div').hide();
                    }
                }
            });
        }
        $('.error-add-car-parts-div').hide();
    });


    // funkcia, ktora dotiahne pocet hodin a cenu prace za sluzbu
    $(".service_update").change(function() {
        $service_update_id = parseInt($('#service_update_id').val());

        if(!isNaN($service_update_id)) {
            $.ajax({
                type: "POST",
                url: "admin-services/getServiceHours",
                dateType: 'json',
                data: {service_update_id: $service_update_id},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    $('#hour_duration').val($dataResult[0].hour_duration);
                    $('#price_per_hour').val($dataResult[0].price_per_hour);
                }
            });
        } else {
            $('#hour_duration').val("");
            $('#price_per_hour').val("");
        }
    });





    // funkcia ci sa dany servic uz v systeme nenachadza
    $('.add-new-service-button').click(function (e) {

        $name = $('#service_name').val();
        $hour_duration = $('#hour_duration').val();
        $price_per_hour = $('#price_per_hour').val();


        if($('#service_name').val() == "") {
            $('.error-add-new-service-div').show();
            $('#error-add-new-service-msg').text('Zadajte hodnotu do pola - Názov služby.');
            return false;
        } else if( ($('#hour_duration').val() == "")) {
            $('.error-add-new-service-div').show();
            $('#error-add-new-service-msg').text('Zadajte hodnotu do pola - Počet hodín práce.');
            return false;
        } else if($('#price_per_hour').val() == "") {
            $('.error-add-new-service-div').show();
            $('#error-add-new-service-msg').text('Zadajte hodnotu do pola - Cena za hodinu.');
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "addService/checkNewService",
                dateType: 'json',
                data: {name: $name, hour_duration: $hour_duration, price_per_hour: $price_per_hour},
                success: function (data) {
                    $dataResult = JSON.parse(data);
                    if($dataResult == "duplicate") {
                        $('.error-add-new-service-div').show();
                        $('#error-add-new-service-msg').text('Služba s rovnakým názvom sa v systéme už nachádza.');
                        return false;
                    } else{
                        $('#add-new-service-submit').submit();
                        $('.error-add-new-service-div').hide();
                    }
                }
            });
        }
        $('.error-add-new-service-div').hide();
    });





});