@extends('layouts.main')

@section('title', 'Add a Gallery Image')
@section('description', '')
@section('keywords', '')

@section('content')

    <div class="row">
        <div class="col-md-5 col-md-offset-3">

            <h2>
                Add an Image to {{ $gallery->name }}
            </h2>

            @include('errors.list')

            {!! Form::open(['route' => ['gallery.gallery_image.store', $gallery], 'class' => 'form', 'files' => true]) !!}

                <div class="form-group">
                    {!! Form::rawLabel('image', 'Image File <span class="small">(.jpg, .png, .gif, .bmp)</span>') !!}
                    {!! Form::file('image', null, ['required', 'class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::rawLabel('name', 'File Name <span class="small">(May only contain letters, numbers, and dashes.)</span>') !!}
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('caption', 'Caption') !!}
                    {!! Form::text('caption', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('alt_text', 'Alt Text') !!}
                    {!! Form::text('alt_text', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description', 'Description:') !!}
                    {!! Form::textarea('description', null, ['class' => 'tinymce']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('credit', 'Credit') !!}
                    {!! Form::text('credit', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('source', 'Source') !!}
                    {!! Form::text('source', null, ['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>
                        {!! Form::hidden('active', 0) !!}
                        {!! Form::checkbox('active', 1, null, []) !!} Active
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        {!! Form::hidden('featured', 0) !!}
                        {!! Form::checkbox('featured', 1, null, []) !!} Featured
                    </label>
                </div>

                <div class="form-group">

                    {!! Form::submit('Upload Image', array('class'=>'btn btn-primary')) !!}

                </div>

            {!! Form::close() !!}

        </div>
    </div>

@stop