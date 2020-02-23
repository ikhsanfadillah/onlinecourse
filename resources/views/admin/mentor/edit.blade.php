@extends('layouts.admin')
@section('title','Mentors')
@section('subTitle','Mentors')
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
        <li class="breadcrumb-item"><a href="{{ route('mentors.index') }}">Mentors</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mentors.show',$mentor->user->username) }}">{{ $mentor->user->name }}</a></li>
        <li class="breadcrumb-item active">Update Mentor</li>
    </ol>
@endsection
@section('content')

    <!-- form start -->
    <form action="{{ route('mentors.update',$mentor->mentor_id) }}" method="post" enctype="multipart/form-data" >
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
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title bold">Main Profile</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @empty(!$mentorMedia['avatarPhoto'])
                            <img src="{{ $mentorMedia['avatarPhoto'] }}" alt="..." class="img-thumbnail">
                        @endempty
                        <div class="form-group">
                            <label for="fileAvatarPhoto">Avatar Photo <small>(.jpg, .jpeg, .png)</small></label>
                            <div class="custom-file">
                                <input value="{{ old('avatar_photo') }}" name="avatar_photo" type="file" class="custom-file-input @error('avatar_photo') is-invalid @enderror" id="fileAvatarPhoto" accept="image/*"  >
                                <label class="custom-file-label" for="fileAvatarPhoto">Choose file...</label>
                                @error('avatar_photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtFullname">Fullname</label>
                            <input id="txtFullname" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$mentor->user->name) }}" placeholder="Enter Fullname" >
                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtUsername">Username</label>
                            <input id="txtUsername" type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username',$mentor->user->username) }}" placeholder="Enter Username" >
                            @error('username')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtEmail">Email</label>
                            <input id="txtEmail" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$mentor->user->email) }}" placeholder="Enter Email" >
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Gender</label>
                            <select name="gender" class="form-control select2bs4 " style="width: 100%;" >
                                @php $genders = [1 => 'Laki-laki', 2 => 'Perempuan'] @endphp
                                @foreach ($genders as $key => $val)
                                    @if (old('gender',$mentor->user->gender) == $key)
                                        <option value="{{ $key }}" selected>{{ $val }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                    </div>
                    <!-- /.card-body -->

                </div>
            </div>
            <div class="col-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title bold">Mentoring Content</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="txtProfesi">Profession</label>
                            <input id="txtProfesi" type="text" name="profesi" value="{{ old('profesi',$mentor->profesi) }}" class="form-control @error('profesi') is-invalid @enderror" placeholder="Enter Profesi" >
                            @error('profesi')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtDesc">Description</label>
                            <textarea id="txtDesc" name="desc" class="form-control @error('desc',$mentor->desc) is-invalid @enderror" rows="3" placeholder="Enter ..." >{{ old('desc',$mentor->profesi) }}</textarea>
                            @error('desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        @empty(!$mentorMedia['primaryPhoto'])
                            <img src="{{ $mentorMedia['primaryPhoto'] }}" alt="..." class="img-thumbnail">
                        @endempty
                        <div class="form-group">
                            <label for="inpPrimaryPhoto">Primary Photo <small>(.jpg, .jpeg, .png)</small></label>
                            <div class="custom-file">
                                <input id="inpPrimaryPhoto" value="{{ old('primary_photo') }}" name="primary_photo" type="file" class="custom-file-input @error('primary_photo') is-invalid @enderror" accept="image/*"  >
                                <label class="custom-file-label" for="inpPrimaryPhoto">Choose file...</label>
                                @error('primary_photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        @empty(!$mentorMedia['descriptionPhoto'])
                            <img src="{{ $mentorMedia['descriptionPhoto'] }}" alt="..." class="img-thumbnail">
                        @endempty
                        <div class="form-group">
                            <label for="fileDescriptionPhoto">Description Photo <small>(.jpg, .jpeg, .png)</small></label>
                            <div class="custom-file">
                                <input id="fileDescriptionPhoto" value="{{ old('description_photo') }}" name="description_photo" type="file" class="custom-file-input @error('description_photo') is-invalid @enderror" accept="image/*"  >
                                <label class="custom-file-label" for="fileDescriptionPhoto">Choose file...</label>
                                @error('description_photo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        @empty(!$mentorMedia['highlightVideo'])
                            <!-- 16:9 aspect ratio -->
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" controls>
                                    <source src="{{$mentorMedia['highlightVideo']}}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endempty
                        <div class="form-group">
                            <label for="inpHighlightVideo">Highlight Video <small>(.flv, .mp4, .mov, .avi, .wmv)</small></label>
                            <div class="custom-file">
                                <input id="inpHighlightVideo" value="{{ old('highlight_video') }}" name="highlight_video" type="file" class="custom-file-input @error('highlight_video') is-invalid @enderror" accept="video/*" >
                                <label class="custom-file-label" for="inpHighlightVideo">Choose file...</label>
                                @error('highlight_video')
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
                <input type="submit" value="Update data" class="btn btn-success float-right">
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