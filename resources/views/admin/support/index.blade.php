@extends('layouts.admin')
@section('title','Support')
@section('subTitle','Index')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('breadcrumb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">faqs</a></li>
        <li class="breadcrumb-item"><a href="{{ route('faqs.show',$item->user->username) }}">Profile</a></li>
        <li class="breadcrumb-item active">Add Lesson</li>
    </ol> --}}
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
                            <a class="btn btn-success btn-sm" href="{{ route('support.create') }}"> Create Support Article</a>
                        </div>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if(isset($supportDesks))
                  <table id="dt1" class="table table-bordered table-hover dt-responsive" width="100%">
                      <thead>
                      <tr>
                          <th>Topic</th>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Updated At</th>
                      </tr>
                      </thead>
                      <tbody>
                          @foreach($supportDesks as $item)
                              <tr>
                                  <td>{{ $item->topic }}</td>
                                  <td>{{ $item->title }}</td>
                                  <td>{{ $item->user->name }}</td>
                                  <td>
                                      <form action="{{ route('support.destroy',$item->id) }}" method="POST" style="text-align: right;">

                                          <a class="btn btn-link text-primary" href="{{ route('support.edit',$item->id) }}"><i class="fas fa-pencil-alt"></i></a>

                                          @csrf
                                          @method('DELETE')
                                          
                                          <button type="submit" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
                                      </form>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="col-sm-12">
                    {{ $supportDesks->links() }}
                  </div>
                @else
                <div class="alert alert-warning">No Data</div>
                @endif
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