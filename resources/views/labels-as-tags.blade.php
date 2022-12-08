@php
    $list = []
    @endphp

@foreach ($value as $label)
    @php
        $color = 'background-color: ' . $label['color'];
        $list[] = sprintf(
            '<div class="product-label"><span class="product-label-color" style="%s"></span>%s</div>',
            $color,
            $label['name']
        );
        @endphp
    @endforeach

@php echo implode('<br/>', $list) @endphp
