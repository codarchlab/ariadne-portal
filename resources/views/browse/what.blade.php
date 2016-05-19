@extends('app')
@section('content')
            
<div class="whatBlock">
  
  <!-- START WORD CLOUD -->
  <div id="wordCloud" class="wordCloudContainerWhat">
    @include('shared._word_cloud')
  </div>
  <!-- END WORD CLOUD -->
</div> 

@endsection