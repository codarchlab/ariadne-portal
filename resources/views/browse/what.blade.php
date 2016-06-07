@extends('app')
@section('content')
            

<style>
  html, body {
    height: 100%;
  }
  .wordCloudContainerWhat {
    height: 95%;
  }
  .whatBlock {
    position: relative;
    height: 95%;
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