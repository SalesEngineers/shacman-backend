@php
    $list = [];
    @endphp

    @if($value)
        @foreach ($value as $item)
            @php
                $list[] = "<span class='label label-info'>{$item['name']}</span>";
                @endphp
            @endforeach
        @endif

@php echo implode('<br/>', $list) @endphp
