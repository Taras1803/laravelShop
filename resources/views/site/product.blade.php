@extends('layouts.catalog')
@section('content')

    <section class="container">
        <section class="catalog">
            <div class="container">
                <div class="catalog__content">
                    <div class="items-line__items items-line__items--four">


                            <div class="items-line__item">
                                <div class="product">
                                    <div class="product__block">
                                        <div class="product__inner">
                                            <a href="">
                                                <img src="{{$data['product']->image}}" alt="">
                                            </a>
                                            <span class="cf-bag"></span>
                                            <span class="cf-wishlist cf-wishlist_fill"></span>
                                        </div>
                                        <div class="product__description">
                                            <a href="" class="product__name main-text main-text--lg-sm link-hover"><span>{{$data['product']->title}}</span></a>
                                            <br>
                                            <strong>Материал: {{$data['product']->material}}</strong>
                                            <strong class="product__price">{{$data['product']->price}} $</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="product_description">
                                    {{$data['product']->product_description}}
                                </div>

                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection