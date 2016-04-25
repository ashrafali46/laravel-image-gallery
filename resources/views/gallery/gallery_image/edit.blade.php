@extends('layouts.main')

@section('title', 'Edit a Gallery Image')
@section('description', '')
@section('keywords', '')

@section('content')

    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <h2>
                Edit an Image for {{ $gallery->name }}
                <div class="btn-group pull-right">

                    {!! link_to_route('gallery.show', 'Cancel', [$gallery], ['class' => 'btn btn-primary']) !!}

                </div>
            </h2>

            @include('errors.list')

        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-md-offset-1">

            {!! Form::model($galleryImage, ['method' => 'PATCH', 'action' => ['GalleryController@galleryImageUpdate', $gallery, $galleryImage]]) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'disabled']) !!}
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

                    {!! Form::submit('Update Image', array('class'=>'btn btn-primary')) !!}

                </div>

            {!! Form::close() !!}

        </div>

        <div class="col-md-5">

            <div class="col-sm-6 col-md-4">
                    <a href="{{ $galleryImage->getUrl() }}?time={{ time() }}" target="_blank">
                        <img src="{{ $galleryImage->getUrl() }}?time={{ time() }}" alt="{{ $galleryImage->alt_text }}">
                    </a>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="{{ $galleryImage->getOriginalUrl() }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Original: {{ $galleryImage->original_width }}x{{ $galleryImage->original_height }}</a></li>
                        <li class="list-group-item"><a href="{{ $galleryImage->getLargeUrl() }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Large: {{ $galleryImage->large_width }}x{{ $galleryImage->large_height }}</a></li>
                        <li class="list-group-item"><a href="{{ $galleryImage->getUrl() }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Medium: {{ $galleryImage->width }}x{{ $galleryImage->height }}</a></li>
                        <li class="list-group-item"><a href="{{ $galleryImage->getThumbUrl() }}" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> Thumb: {{ $galleryImage->thumb_width }}x{{ $galleryImage->thumb_height }}</a></li>
                    </ul>
            </div>

        </div>
    </div>

@stop