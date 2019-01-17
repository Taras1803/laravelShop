<h1>{{$page->content1_header}}</h1>
@php
    $doc = new DOMDocument();
    $doc->loadHTML($page->content1);
    echo $doc->saveHTML();
@endphp
<img src="{{$page->image}}" alt="">
