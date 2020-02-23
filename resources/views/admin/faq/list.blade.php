@extends('layouts.admin')
@section('title','FAQs')
@section('subTitle','FAQ')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
@section('breadcrumb')
    {{-- <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">faqs</a></li>
        <li class="breadcrumb-item"><a href="{{ route('faqs.show',$faq->user->username) }}">Profile</a></li>
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
                            <a class="btn btn-success btn-sm" href="{{ route('faq.create') }}"> Create faq</a>
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
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Order</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $faq->question }}</td>
                                <td>{{ $faq->answer }}</td>
                                <td>{{ $faq->order }}</td>
                                <td>
                                    <form action="{{ route('faq.destroy',$faq->id) }}" method="POST" style="text-align: right;">

                                        <a class="btn btn-link text-primary" href="{{ route('faq.edit',$faq->id) }}"><i class="fas fa-pencil-alt"></i></a>

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