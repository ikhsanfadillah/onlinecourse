@extends('layouts.admin')
@section('title','Mentors')
@section('subTitle','Mentors')
@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Mentors</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2 mb-md-3">
                        <div class="col-12 d-flex justify-content-between">
                            <div class="left"></div>
                            <div class="right">
                                <a class="btn btn-success btn-sm" href="{{ route('mentors.create') }}"> Create Mentor</a>
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id="dt1" class="table table-bordered table-hover dt-responsive" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mentors as $mentor)
                                <tr>
                                    <td><a href="{{ route('mentors.show',$mentor->user->username) }}"></a>{{ $mentor->user->name }}</td>
                                    <td>{{ $mentor->user->username }}</td>
                                    <td>{{ $mentor->user->email }}</td>
                                    <td>
                                        <form action="{{ route('mentors.destroy',$mentor->mentor_id) }}" method="POST" style="text-align: right;">

                                            <a class="btn btn-link text-info" href="{{ route('mentors.show',$mentor->user->username) }}"><i class="fas fa-user-tie"></i></a>
                                            <a class="btn btn-link text-primary" href="{{ route('mentors.edit',$mentor->mentor_id) }}"><i class="fas fa-pencil-alt"></i></a>

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script>

    $(function () {
        $('#dt1').DataTable({
            "scrollX": true
        });
    });

</script>
@endsection