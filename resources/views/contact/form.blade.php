@extends('app')
@section('title', 'Contact us - Ariadne portal')

<div class="container content">

  <div class="row">

    <div class="col-md-8 col-md-offset-2">

      <h1>Contact</h1>

      @if(session('message'))
        <div class="alert alert-success">
          {{ session('message') }}
        </div>
      @endif

      @if($errors->has())
          @foreach($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
          @endforeach
      @endif

      {!! Form::open(array('route' => 'contact.store', 'class' => 'form')) !!}

      <div class="form-group">
          {!! Form::label('Your Name') !!}
          {!! Form::text('name', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Your name')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Your E-mail Address') !!}
          {!! Form::text('email', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Your e-mail address')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Subject') !!}
          {!! Form::text('subject', Request::input('subject'), 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Subject')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Your Message') !!}
          {!! Form::textarea('message', null, 
              array('class'=>'form-control', 
                    'placeholder'=>'Your message')) !!}
      </div>

      <div class="form-group">
          {!! Form::button('<span class="glyphicon glyphicon-send"></span> Send', 
            array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
      </div>
      {!! Form::close() !!}

    </div>

  </div>

</div>