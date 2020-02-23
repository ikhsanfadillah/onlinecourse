@extends('layouts.admin')
@section('title','Lessons')
@section('subTitle','Lesson')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('mentors.index') }}">Mentors</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mentors.show',$mentor->user->username) }}">Profile</a></li>
        <li class="breadcrumb-item active">Edit Lesson</li>
    </ol>
@endsection
@section('content')

    <!-- form start -->
    <form action="{{ route('mentors.lessons.store',$mentor->user->username) }}" method="post" enctype="multipart/form-data" >
        @csrf
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
                            <label for="txtTitle">Title</label>
                            <input id="txtTitle" type="text" name="title" value="{{ old('title',$lesson->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Profesi" >
                            @error('title')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtSlug">Slug</label>
                            <input id="txtSlug" type="text" name="slug" value="{{ old('slug',$lesson->slug) }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Enter Profesi" >
                            @error('slug')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="txtDesc">Description</label>
                            <textarea id="txtDesc" name="desc" class="form-control @error('desc') is-invalid @enderror" rows="3" placeholder="Enter ..." >{{ old('desc',$lesson->desc) }}</textarea>
                            @error('desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @empty(!$lessonMedia['thumbnailPhoto'])
                            <img src="{{ $lessonMedia['thumbnailPhoto'] }}" alt="..." class="img-thumbnail">
                        @endempty
                        <div class="form-group">
                            <label for="inpThumbnailPhoto">Thumbnail Photo <small>(.jpg, .jpeg, .png)</small></label>
                            <div class="custom-file">
                                <input value="{{ old('thumbnail_photo') }}" name="thumbnail_photo" type="file" class="custom-file-input @error('thumbnail_photo') is-invalid @enderror" id="inpThumbnailPhoto" accept="image/*"  >
                                <label class="custom-file-label" for="inpThumbnailPhoto">Choose file...</label>
                                @error('thumbnail_photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        @empty(!$lessonMedia['lessonVideo'])
                        <!-- 16:9 aspect ratio -->
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls>
                                    <source src="{{$lessonMedia['lessonVideo']}}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endempty
                        <div class="form-group">
                            <label for="inpHighlightVideo">Lesson Video <small>(.flv, .mp4, .mov, .avi, .wmv)</small></label>
                            <div class="custom-file">
                                <input value="{{ old('lesson_video') }}" name="lesson_video" type="file" class="custom-file-input @error('lesson_video') is-invalid @enderror" id="inpLessonVideo" accept="video/*" >
                                <label class="custom-file-label" for="inpLessonVideo">Choose file...</label>
                                @error('lesson_video')
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
    $("#txtTitle").on('input',function(){
        var Text = $(this).val();
        console.log(Text);
        Text = convertToSlug(Text);
        $("#txtSlug").val(Text);
    });
    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }
</script>
@endsection