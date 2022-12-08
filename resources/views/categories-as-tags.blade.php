@php
    $list = []
    @endphp

@foreach ($value as $category)
    @php
        $list[] = sprintf(
            '<a href="%s" title="Редактировать категорию">%s</a>',
            route('.categories.edit', ['category' => $category['id']]),
            $category['name']
        )
        @endphp
    @endforeach

@php echo implode(', ', $list) @endphp
