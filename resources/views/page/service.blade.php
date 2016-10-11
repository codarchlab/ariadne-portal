<div class="row service {{ $type }}">
    <div class="col-md-4">
        <a href="{{ $service['url'] }}">
            <img class="img-thumbnail" src="{{ asset("img/services/" . $service['image']) }}" alt="{{ $service['title'] }}" />
        </a>                      
    </div>

    <div class="col-md-8">
        <h4>{{ $service['title'] }}</h4>
        <p>
          {!! Utils::makeClickableLinks($service['description']) !!}
        </p>

        <p>
            <a href="{{ $service['url'] }}">{{ $service['url'] }} <span class="glyphicon glyphicon-new-window" data-toggle="tooltip" data-placement="bottom" title="{{ $service['title'] }}"></span></a>
        </p>            
    </div>
</div>