@foreach($value as $key => $item)
    @php
        $name = $model->labels[$key] ?? $key
        @endphp
        <div><strong>{{$name}}</strong>: {{$item}}</div>
    @endforeach
