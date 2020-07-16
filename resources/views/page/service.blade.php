<div class="row service {{ $type }}" itemscope="" itemtype="https://schema.org/SoftwareApplication">
    <div class="col-md-4">
        <a href="{{ $service['url'] }}">
            <img class="img-thumbnail" src="/img/services/{{$service['image']}}" alt="{{ $service['title'] }}" itemprop="image" />
        </a>                      
    </div>

    <div class="col-md-8">
        <h4 itemprop="name">{{ $service['title'] }}</h4>
        <p itemprop="description">
          {!! Utils::makeClickableLinks($service['description']) !!}
        </p>

        <p>
            <a href="{{ $service['url'] }}" title="{{ $service['title'] }}" itemprop="sameAs">{{ $service['url'] }} <span class="glyphicon glyphicon-new-window" data-toggle="tooltip" data-placement="bottom" title="{{ $service['title'] }}"></span></a>
        </p>            
    </div>
</div>