@extends('layouts.admin')
@section('title','Landing page')
@section('subTitle','Landing page')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .img-thumbnail{
            height: 170px;
        }
    </style>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('setting.index') }}">Setting</a></li>
        <li class="breadcrumb-item active">Landing Page</li>
    </ol>
@endsection
@section('content')

    <!-- form start -->
    <form action="{{ route('setting.landingpage.update') }}" method="post" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-triangle"></i> Error:</h5>
                        <ul class="m-1 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group">
                            <label for="txtDesc">Trailer Description</label>
                            <textarea id="txtDesc" name="trailer_desc" class="form-control @error('trailer_desc') is-invalid @enderror" rows="3" placeholder="Enter ..." >{{ old('trailer_desc',$landingpage->trailer_desc) }}</textarea>
                            @error('trailer_desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>


                        @if(!empty($landingpageMedia['previewPhoto']))
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls>
                                    <source src="{{$landingpageMedia['previewPhoto']}}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="inpTrailerVideo">Trailer Image<small>(.jpg, .jpeg, .png)</small></label>
                            <div class="custom-file">
                                <input value="{{ old('trailer_photo') }}" name="trailer_photo" type="file" class="custom-file-input @error('trailer_photo') is-invalid @enderror" id="inpTrailerVideo" accept="image/*" >
                                <label class="custom-file-label" for="inpTrailerVideo">Choose file...</label>
                                @error('trailer_photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        @if(!empty($landingpageMedia['previewVideo']))
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls>
                                    <source src="{{$landingpageMedia['previewVideo']}}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="inpTrailerVideo">Trailer Video <small>(.flv, .mp4, .mov, .avi, .wmv)</small></label>
                            <div class="custom-file">
                                <input value="{{ old('trailer_video') }}" name="trailer_video" type="file" class="custom-file-input @error('trailer_video') is-invalid @enderror" id="inpTrailerVideo" accept="video/*" >
                                <label class="custom-file-label" for="inpTrailerVideo">Choose file...</label>
                                @error('trailer_video')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 mb-3">
                <input type="submit" value="Save" class="btn btn-success float-right">
            </div>
        </div>
    </form>

@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>

        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $(this).closest('.form-group').find('.custom-file-label').html(fileName);
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection