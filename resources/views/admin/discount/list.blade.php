@extends('layouts.admin')
@section('title','Discounts')
@section('subTitle','Discounts')
@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item active">Discounts</li>
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
                                <a class="btn btn-success btn-sm" href="{{ route('discounts.create') }}"> Create Discount</a>
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
                                <th>Discount Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Max Price</th>
                                <th>Started At</th>
                                <th>Ended At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>
                                    <span class="d-inline-block bg-{{ $discount->is_active ? 'success' : 'danger' }} mr-1"
                                          style="height: .7em; width: .7em; border-radius: 99px">
                                    </span>
                                    {{ $discount->code }}
                                </td>
                                <td>{{ \App\Discount::$type[$discount->type] }}</td>
                                <td>
                                    {{ $discount->value_type }}
                                </td>
                                <td>{{ \App\Helper::IDR($discount->max_price) }}</td>
                                <td>{{ $discount->started_at }}</td>
                                <td>{{ $discount->ended_at }}</td>
                                <td>
                                    <form action="{{ route('discounts.destroy',$discount->id) }}" method="POST" style="text-align: right;">
                                        <a title="Edit Discount" href="{{ route('discounts.edit',$discount->id) }}" class="btn btn-link text-info">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </a>
                                        <a title="Assign Discount" href="{{ route('discounts.view-assign',$discount->id) }}" class="btn btn-link text-success">
                                            <ion-icon name="people-outline"></ion-icon>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger">
                                            <ion-icon name="trash-outline"></ion-icon>
                                        </button>
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