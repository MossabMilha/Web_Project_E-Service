<div class="info-card">
    <h2 class="title">{{$title}}</h2>
    <div class="table-container">
        <table>
            @foreach($data as $key => $value)
                <tr class="flex ">
                    <th class="text-left flex-2/5">{{$key}}</th>
                    <td class="text-left flex-3/5">{{$value}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
