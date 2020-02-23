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
        <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Faqs</a></li>
    </ol>
@endsection
@section('content')
    <form action="{{route('faq.store')}}" method="post">
      @csrf
      <div class="form-group row">
        <label for="Question">Question</label>
        <input type="text" name="question" id="question" class="form-control">
      </div>
      <div class="form-group row">
        <label for="Answer">Answer</label>
        <input type="text" name="answer" id="answer" class="form-control">
      </div>
      <div class="form-group row">
        <label for="Order">Order</label>
        <input type="number" name="order" id="order" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection