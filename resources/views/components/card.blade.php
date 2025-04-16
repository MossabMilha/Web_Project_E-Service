<div class="card">
    <!-- Card Image (optional) -->
{{--    <img src="" alt="Image Description" class="card-img-top">--}}
    {{-- TODO: remember to add an img--}}

    <!-- Card Header (optional) -->
    <div class="card-header">
        <h5 class="card-title">{{$cardTitle}}</h5>
    </div>

    <!-- Card Body -->
    <div class="card-body">
        <p class="card-text">{{$slot}}</p>
        <a href="{{$cardLink}}" class="btn btn-primary">manage</a>
    </div>
</div>
