@if($value)
    @php
        echo sprintf(
            '<a href="%s" title="Редактировать категорию">%s</a>',
            route('.categories.edit', ['category' => $value['id']]),
            $value['name']
        )
        @endphp
    @endif
