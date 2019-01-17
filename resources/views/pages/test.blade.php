@php
    $doc = new DOMDocument();
    $doc->loadHTML($page->content);
    echo $doc->saveHTML();
@endphp
