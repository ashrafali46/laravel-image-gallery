@extends('layouts.main')

@section('title', $gallery->name .' Gallery Images')
@section('description', '')
@section('keywords', '')

@section('content')

    <div class="class row">
        <div class="col-md-12">

            <h2>
                {{ $gallery->name }} Images
                <div class="btn-group pull-right">

                    @if (Gate::allows('view-gallery'))
                        {!! link_to_route('gallery.show', 'Back', [$gallery], ['class' => 'btn btn-primary']) !!}
                    @endif

                </div>
            </h2>

            {!! $galleryImages->render() !!}

            <table class="table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="hide">ID</th>
                        <th>Image</th>
                        <th>Active</th>
                        <th>Featured</th>
                        <th>Title</th>
                        <th>Caption</th>
                        <th>Alt Text</th>
                        <th>Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($galleryImages as $galleryImage)

                        <tr>
                            <td class="text-center hide" scope="row" valign="top">{{ $galleryImage->id }}</td>
                            <td class="text-nowrap" valign="top">
                                <a href="{{ $galleryImage->getUrl() }}" target="_blank">
                                    <img src="{{ $galleryImage->getThumbUrl() }}">
                                </a>
                            </td>
                            <td class="text-nowrap text-center" valign="top">{{ $galleryImage->active ? 'Y' : 'N' }}</td>
                            <td class="text-nowrap text-center" valign="top">{{ $galleryImage->featured ? 'Y' : 'N' }}</td>
                            <td class="text-nowrap" valign="top">{{ $galleryImage->title }}</td>
                            <td class="text-nowrap" valign="top">{{ $galleryImage->caption }}</td>
                            <td class="text-nowrap" valign="top">{{ $galleryImage->alt_text }}</td>
                            <td class="text-nowrap" valign="top">{{ $galleryImage->getFilename() }}</td>
                            <td class="text-nowrap" valign="top">

                                @if (Gate::allows('edit-gallery'))
                                    <a href="{{ route('gallery.gallery_image.edit', [$gallery, $galleryImage]) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                @endif

                                @if (Gate::allows('delete-gallery'))
                                    {!! Form::open(['action' => ['GalleryController@galleryImageDestroy', $gallery, $galleryImage], 'method' => 'delete', 'style' => 'display: inline;']) !!}
                                    {!! Form::button('<i class="fa fa-trash-o"></i> Delete', ['type' => 'submit', 'class'=>'btn btn-danger btn-xs delete-record', 'onclick' => 'return confirmDelete(\''.$galleryImage->getFilename().'\');']) !!}
                                    {!! Form::close() !!}
                                @endif

                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

            {!! $galleryImages->render() !!}

        </div>
    </div>

@stop