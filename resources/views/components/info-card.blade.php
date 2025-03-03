<div class="bg-amber-200 w-2xs">
    <h2>{{$title}}</h2>
    <div>
        <table>
            @foreach($data as $key => $value)
                <tr>
                    <th>{{$key}}</th>
                    <td>{{$value}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
