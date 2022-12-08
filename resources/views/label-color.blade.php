@if($value)
    @php
        echo sprintf(
            '<div style="%s"><span style="%s"></span>%s</div>',
            'display: flex; align-items: center',
            'background-color: ' . $value . '; width: 20px; height: 20px; display: block; margin-right: 8px; border-radius: 3px; border: 1px solid #f4f4f4;',
            $value
        )
        @endphp
    @endif
