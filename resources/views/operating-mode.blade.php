@php
    $list = [];
@endphp

@if($value)
    @foreach ($value as $item)
        @php
            $list[] = "<div>{$item['name']}: {$item['value']}</div>";
        @endphp
    @endforeach
@endif

@php echo implode('', $list) @endphp
