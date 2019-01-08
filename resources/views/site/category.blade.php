@extends('layouts.catalog')
@section('content')

    <section class="container">
        <section class="catalog">
            <div class="container">
                <div class="category_description">
                    {{$data['category_description']}}
                </div>
                <div class="catalog__content">
                    <div class="items-line__items items-line__items--four">

                        @foreach($data['products'] as $product)
                            <div class="items-line__item">
                                <div class="product">
                                    <div class="product__block">
                                        <div class="product__inner">
                                            <a href="/product/{{$product->slug}}">
                                                <img src="{{$product->image}}" alt="">
                                            </a>
                                            <span class="cf-wishlist cf-wishlist_fill"></span>
                                        </div>
                                        <div class="product__description">
                                            <a href="/product/{{$product->slug}}"
                                               class="product__name main-text main-text--lg-sm link-hover"><span>{{$product->title}}</span></a>
                                            <br>
                                            <strong>Материал: {{$product->material}}</strong>
                                            <strong class="product__price">{{$product->price}} $</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{ $data['products']->render() }}
                </div>
            </div>
        </section>
    </section>

@endsection