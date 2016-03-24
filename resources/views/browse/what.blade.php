@extends('app')
@section('content')
            
<style>
.whatBlock {
  margin-top: 80px;
  margin-left: 20px;
  margin-right: 20px;
  height: 100%;
}
#wordCloud{
  height: 500px;
}
</style>

<div class="whatBlock">
  
  <!-- START WORD CLOUD -->
  <div id="wordCloud" class="wordCloudContainerWhat">
    @include('shared._word_cloud')
  </div>
  <!-- END WORD CLOUD -->
    
</div> 

@endsection