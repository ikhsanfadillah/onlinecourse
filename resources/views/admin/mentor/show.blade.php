@extends('layouts.admin')
@section('title','Mentors')
@section('subTitle','Profile')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('mentors.index') }}">Mentors</a></li>
        <li class="breadcrumb-item active">{{ $mentor->user->name }}'s Profile</li>
    </ol>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" style="height: 100px;"
                             src="{{ $mentor->getAvatar() ?: "https://ui-avatars.com/api/?size=128&background=FFAE04&color=25282B&name=".$mentor->user->name }}"
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $mentor->user->name }}</h3>

                    <p class="text-muted text-center">{{ $mentor->profesi }}</p>

                    <hr>
                    <strong><i class="fas fa-dollar-sign mr-1"></i> Price</strong>
                    <p class="text-muted">{{ $mentor->price }}</p>
                    <hr>
                    <strong><i class="fas fa-signature mr-1"></i> Username</strong>
                    <p class="text-muted">{{ $mentor->user->username }}</p>
                    <hr>
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ $mentor->user->email }}</p>
                    <hr>
                    <strong><i class="fas fa-user-tie mr-1"></i> Profession</strong>
                    <p class="text-muted">{{ $mentor->profesi }}</p>
                    <hr>
                    <strong><i class="fas fa-scroll mr-1"></i> Description</strong>
                    <p class="text-muted">{{ $mentor->desc }}</p>
                    <hr>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted">Malibu, California</p>

                    <hr>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#lessons" data-toggle="tab">Lessons</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mentors.edit',$mentor->mentor_id) }}">Edit</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="lessons">
                            <a href="{{ route('mentors.lessons.create',$mentor->user->username) }}" class="btn btn-primary float-right">Create Lesson</a>
                            <div class="clearfix mb-3"></div>
                            <table id="dt1" class="table table-borderedless table-hover dt-responsive" width="100%">
                                <thead>
                                <tr>
                                    <th style="">#</th>
                                    <th style="">Title</th>
                                    <th style="">Slug</th>
                                    <th style="">Type</th>
                                    <th style="">Create Date</th>
                                    <th style="">Update Date</th>
                                    <th style=""></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lessons as $i => $lesson)
                                    <tr>
                                        <td> {{ $i+1 }} </td>
                                        <td> <a> {{ $lesson->title }} </a> </td>
                                        <td class="project_progress">{{ $lesson->slug }}</td>
                                        <td>
                                            @if($lesson->lessonable_type == \Spatie\MediaLibrary\Models\Media::class)
                                                Media
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ date('d-M-Y', strtotime($lesson->created_at)) }}</td>
                                        <td>{{ date('d-M-Y', strtotime($lesson->updated_at)) }}</td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-info btn-sm" href="{{ route('mentors.lessons.edit',[$mentor->user->username,$lesson->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="event.preventDefault();document.getElementById('delete-form-{{$lesson->id}}').submit();">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <form id="delete-form-{{$lesson->id}}" action="{{ route('mentors.lessons.destroy',[$mentor->user->username,$lesson->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="edit">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

    <script>

        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $(this).closest('.form-group').find('.custom-file-label').html(fileName);
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $(function () {
            $('#dt1').DataTable({
                "scrollX": true,
                "columnDefs": [ {
                    "targets": 0,
                    "orderable": false
                }, {
                    "targets": 6,
                    "orderable": false
                } ]
            });
        });
    </script>
@endsection