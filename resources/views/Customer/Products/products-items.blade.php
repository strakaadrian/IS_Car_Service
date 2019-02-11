@if(!$car_parts_by_model->isEmpty())
    <div class="row products-row" >
        {{ Form::open() }}
        @foreach($car_parts_by_model as $car_part)
            <div class=" product-item" >
                <img class="products-image" src="{{ asset('storage/'. $car_part->image) }}" alt="/">
                <div class="product-name text-center"><strong> {{ $car_part->part_name }} </strong> </div>
                @if($car_part->stock > 0)
                    <div class="product-stock col-sm-6 text-center"><p>Na sklade: <strong>  {{ $car_part->stock }} </strong>  </p>  </div>
                    <div class="product-price col-sm-6 text-center"><p>Cena/ks: <strong>  {{ $car_part->part_price }} €</strong>  </p> </div>
                    <div class="col-sm-3 text-center"> <p> Množstvo: </p> </div>
                    <div class="col-sm-4  product-quantity-box"> {{ Form::number('quantity', $value = 1, ['class' => 'form-control product-quantity', 'id' => $car_part->car_part_id ,'min' => 1, 'max' => $car_part->stock]) }}</div>
                    <div class="col-sm-12 error-product-quantity" id="error-product-quantity-{{$car_part->car_part_id}}"> </div>
                    <div class="col-sm-12 text-center"><button type="button" id="{{$car_part->car_part_id}}" class="btn btn-warning btn-lg product-item-to-cart" name="product-item-to-cart"  value=""> <i class="fa fa-shopping-cart"></i> Do košíka</button></div>
                @else
                    <div class="col-sm-12 text-center product-out-of-stock"> <p> Tovar je momentálne nedostupný.</p>  </div>
                @endif
            </div>
        @endforeach
        {{ Form::close() }}
    </div>
@endif



