@extends('app')

@section('title', 'Domov')

@section('content')

    <div class="container-fluid bg-1 text-center home-block">
        <div class="sectionHeader">
            <h2> O nás </h2>
            <hr class="whiteHR">
        </div>
        <div class="sectionBody ">
            <p>
                Car world je súkromná spoločnosť, ktorá ponúka široký sortiment služieb pre našich zákazníkov.Naša spoločnosť je na trhu od roku 2012 ako súkromný podnik fyzickej osoby, ktorá si stihla za čas strávený na trhu vybudovať silné miesto, ktoré je zárukou kvalitných výrobkov a služieb. V našej firme si môžete vopred zarezervovať  termín pre lakýrnické, elektroinštalačné, mechanické a karosárske práce.
            </p>
            <a href="{{url('about')}}" class="btn btn-warning btn-lg">
                <span class="glyphicon glyphicon-search"></span> Zistite viac
            </a>
        </div>
    </div>

    <div class="container-fluid bg-2 text-center home-block">
        <div id="mainCarousel" class="carousel slide" data-ride="carousel" data-interval="12000">
            <ul class="carousel-indicators">
                <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#mainCarousel" data-slide-to="1"></li>
                <li data-target="#mainCarousel" data-slide-to="2"></li>
                <li data-target="#mainCarousel" data-slide-to="3"></li>
                <li data-target="#mainCarousel" data-slide-to="4"></li>
                <li data-target="#mainCarousel" data-slide-to="5"></li>
                <li data-target="#mainCarousel" data-slide-to="6"></li>
                <li data-target="#mainCarousel" data-slide-to="7"></li>
                <li data-target="#mainCarousel" data-slide-to="8"></li>
                <li data-target="#mainCarousel" data-slide-to="9"></li>
            </ul>
            <div class="carousel-inner">
                <div class="item active">
                    <div class="carousel-item-show">
                        <h2> 1. Kontrolujte a mente pravidelne olej </h2>
                        <p>Priemerný interval výmeny minerálnych olejov je 12 – 15 000 km a pri syntetických je to zväčša 15 – 17 000 km alebo raz ročne. A to aj vtedy, ak najazdíte menej, lebo olej podlieha aj oxidácii, čo tiež znižuje jeho životnosť. Moderné motory majú uvedený interval výmeny oleja 20 000, dokonca až 30 000 km a niektoré aj viac.</p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 2. Raz za čas premerajte tlak v pneumatikách </h2>
                        <p>Len správne nahustená letná pneumatika alebo zimná pneumatika zaisťuje optimálny kontakt celého behúňa s vozovkou. Treba brať ohľad na parametre a rozmery pneumatík.Tlak má tiež vplyv na dĺžku brzdnej dráhy, stabilitu a ovládateľnosť. Nadmerné hustenie má negatívny dopad na tlmiče a taktiež klesá jazdný komfort. Naopak pri podhustených pneumatikách sa zvyšuje riziko defektu a klesá kilometrický výkon pneumatiky (klesá jej životnosť).</p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 3. Vymienajte vzduchový filter </h2>
                        <p> Vzduchový filter je dôležitou súčasťou automobilu (systém nasávania), pretože cez filter vzduchu motor "dýcha". Motor vyžaduje presnú zmes paliva a vzduchu, vzduchový filter, ktorého úlohou je odfiltrovanie nečistôt a iných cudzích častíc vo vzduchu, zabraňuje týmto nečistotám vo vstupe do systému a tým zabraňuje poškodeniu motora. Každý výrobca má iný výmenný cyklus, ale v priemere je to po 30 000 kilometroch. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 4. Venujte zvýšenú pozornosť brzdovej kvapaline </h2>
                        <p> Brzdová kvapalina by sa mala meniť asi raz za dva až tri roky. V prípade pochybností je možné ju otestovať na obsah vody. Ak jej množstvo prekročí istú hranicu, výmena je nevyhnutná. Úkon si vyžaduje návštevu servisu, napríklad pri automobiloch s ABS sa mechanik bez špeciálneho zariadenia prakticky nezaobíde. Nie je však náročný na čas, trvá asi pol hodinu, ani na materiál.  </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 5. Dôkladne čistenie </h2>
                        <p> Nestačí len raz za čas prejsť cez umývaciu linku. Aspoň jedenkrát za sezónu, najlepšie po zime, treba vyčistiť aj podbehy, prahy, miesta okolo dverí a podobne. V dutinách sa ukrýva nalepený posypový materiál, ktorý rýchlo spôsobuje hrdzavenie. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 6. Vyhnite sa studeným štartom </h2>
                        <p> Najsilnejšie sa motor opotrebováva na prvom kilometri po studenom štarte. Olej zriedený benzínom, vysoké trenie a vysoká teplota namáhajú komponenty motora. Vyhnite sa preto, ak sa to dá, opakovaným krátkym jazdám, pri ktorých sa motor nestihne zohriať. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 7. Obmedzte vysoké otáčky </h2>
                        <p> Diaľkoví vodiči to vedia: vysoké otáčky znamenajú vyššie opotrebovanie. Trecie plochy sa viac namáhajú, olej rýchlejšie degraduje, teplotné namáhanie je výraznejšie. Optimálne otáčky sú do 3 500 za minútu. Viac pretáčať motor sa odporúča len pri predbiehaní či prudkom stúpaní. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 8. Opatrné zohrievanie </h2>
                        <p> Ohrev komponentov motora po studenom štarte neprebieha rovnomerne. Olej potrebuje istý čas, aby sa dostal na všetky mazacie miesta. Preto platí, že po naštartovaní prejdite prvých desať kilometrov na nižších otáčkach ako 3 000. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 9. Dostatočné odvetranie </h2>
                        <p> Obvykle sa garážované jazdené vozidlo považuje za lepšie zachovalé. Nemusí to platiť všeobecne. Individuálna garáž býva slabo vetraná. Auto sa suší pomaly a v dutinách zostáva vlhkosť, čo spôsobuje hrdzavenie. Odporúčame preto garáž dobre vetrať, alebo parkovať len pod prístreškom. </p>
                    </div>
                </div>

                <div class="item">
                    <div class="carousel-item-show">
                        <h2> 10. Ochladenie turba </h2>
                        <p> Pri turbomotoroch platí, že po využití ich plného výkonu sa nesmú okamžite vypnúť. Treba ich nechať vychladiť v behu naprázdno po dobu asi dvoch minút. Inak by mohol olej zuhoľnatieť na hriadeli rotora turbíny a upchať mazacie kanáliky. Oprava je drahá. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid bg-1 text-center home-block">
        <h3 class="margin">Zopár fotiek z naších firiem od spokojných zákazníkov</h3><br>
        <div class="row">
            <div class="col-sm-4">
                <p>Výborný prístup, milý personál a rýchle vybavenie. </p>
                <p class="text-right">Fotku poslal: Ján Hlavatý</p>
                <img src="{{ asset('img/inside1.jpg') }}" class="img-responsive margi home-img"  alt="Image">
            </div>
            <div class="col-sm-4">
                <p>Komunikatívny personál a rýchle dojednanie opravy.</p>
                <p class="text-right">Fotku poslal: Marcel Koniarik</p>
                <img src="{{ asset('img/inside2.jpg') }}" class="img-responsive margin home-img"  alt="Image">
            </div>
            <div class="col-sm-4">
                <p>Skvelé pohostenie, káva a taxik v cene služby.</p>
                <p class="text-right">Fotku poslal: Jaroslav Janus</p>
                <img src="{{ asset('img/inside3.jpg') }}" class="img-responsive margin home-img"  alt="Image">
            </div>
        </div>
    </div>

@endsection
