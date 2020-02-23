@extends('layouts.admin')
@section('title','Support Desk')
@section('subTitle','Create Support Article')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('breadcrumb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('mentors.index') }}">Mentors</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mentors.show',$mentor->user->username) }}">Profile</a></li>
        <li class="breadcrumb-item active">Add Lesson</li>
    </ol> --}}
@endsection
@section('content')

    <!-- form start -->
    <form action="{{ route('support.store') }}" method="post">
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
                            <input required id="txtTitle" type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter Title" >
                            @error('title')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtSlug">Slug</label>
                            <input required id="txtSlug" type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Customize Slug" >
                            @error('slug')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="topic">Topic</label>
                            <select required name="topic" id="" class="form-control">
                              <option value="privacy_policy">Privacy Policy</option>
                              <option value="terms_and_conditions">Terms & Condition</option>
                            </select>
                            @error('topic')
                              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                          <label for="content" class="form-control-label">Content</label>
                          <textarea required name="content" id="content"></textarea>
                          @error('content')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                          @enderror
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
<script>
  tinymce.init({
    selector: '#content',
    plugins: 'print preview paste autolink visualblocks image link wordcount',
    toolbar: 'undo redo | styleselect bold italic fontselect fontsizeselect | alignleft aligncenter alignright | bullist numlist | outdent indent',
    content_css: ['//fonts.googleapis.com/css?family=Indie+Flower',
                  '//fonts.googleapis.com/css?family=Open+Sans',
                  'https://fonts.googleapis.com/css?family=Merriweather'],
    font_formats: 'Andale Mono=andale mono,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Terminal=terminal,monaco; Times New Roman=times new roman,times;Cabin=cabin; Open Sans=open sans; Merriweather=merriweather, times;',
    fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',
    image_dimensions: false,
    image_class_list: [
      {title: 'Responsive', value: 'img-fluid'}
    ],
    min_width: 1000,
    height: 1000,
    theme: 'silver',
    mobile: {
      theme: 'mobile',
      plugins: [ 'autosave', 'lists', 'autolink' ],
      toolbar: [ 'undo', 'redo', 'bold', 'italic', 'underline', 'image', 'fontsizeselect']
    },
    view: { title: 'View', items: 'code | visualaid visualblocks | preview' },
    paste_data_images: true
  });
  $("#txtTitle").on('input',function(){
      var Text = $(this).val();
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