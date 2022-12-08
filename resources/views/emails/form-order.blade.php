<h2>{{$order->subject}}</h2>

@foreach($fields as $field)
    <p><strong>{{$field['name']}}:</strong> {{$field['value']}}</p>
    @endforeach
