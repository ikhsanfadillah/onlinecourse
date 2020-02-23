@extends('layouts.admin')
@section('title','Lessons')
@section('subTitle','Lesson')
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('discounts.index') }}">Discounts</a></li>
        <li class="breadcrumb-item active">Create Discount</li>
    </ol>
@endsection
@section('content')

    <!-- form start -->
    <form action="{{ route('discounts.store') }}" method="post" >
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
                            <label for="txtCode">Discount Code</label>
                            <input id="txtCode" type="text" name="code" value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" placeholder="Discount Code" >
                            @error('code')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtDesc">Description</label>
                            <textarea name="desc" id="txtDesc" rows="3" class="form-control @error('desc') is-invalid @enderror">{{ old('desc') }}</textarea>
                            @error('desc')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="selType">Type</label>
                            <select name="type" class="form-control select2bs4 @error('type') is-invalid @enderror" id="selType" style="width: 100%;" >
                                @php $type = [1 => 'Price', 100 => 'Percent'] @endphp
                                @foreach ($type as $key => $val)
                                    @if (old('type') == $key)
                                        <option value="{{ $key }}" selected>{{ $val }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="txtPrice">Price</label>
                            <input id="txtPrice" type="number" name="price" value="{{ old('price',$discount->price) }}" class="form-control @error('price') is-invalid @enderror" placeholder="Price" >
                            @error('price')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="txtPercent">Percent</label>
                            <input id="txtPercent" type="number" name="percent" value="{{ old('percent',$discount->percent) }}" class="form-control @error('percent') is-invalid @enderror" placeholder="Percent" >
                            @error('percent')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="txtMaxPrice">Maximum Discount Price</label>
                            <input id="txtMaxPrice" type="number" name="max_price" value="{{ old('max_price',0) }}" class="form-control @error('max_price') is-invalid @enderror" placeholder="Enter Title" >
                            @error('max_price')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <!-- Date and time range -->
                        <div class="form-group">
                            <label>Date and time range:</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                                <input type="text" name="discount_date_range" class="form-control float-right" id="txtDiscountDateRange">
                            </div>
                            <!-- /.input group -->
                        </div>

                    </div>
                    <!-- /.card-body -->

                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 mb-3">
                <input type="reset" value="Reset" class="btn btn-success">
                <input type="submit" value="Save" class="btn btn-success">
            </div>
        </div>
    </form>
@endsection

@section('script')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<script>

    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $(this).closest('.form-group').find('.custom-file-label').html(fileName);
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    //Date range picker with time picker
    $('#txtDiscountDateRange').daterangepicker({
        timePicker: true,
        timePickerIncrement: 15,
        timePicker24Hour: true,
        timePickerSeconds:true,
        drops:'up',
        locale: {
            format: '{{ config('app.datetime_format_js') }}'
        }
    });

    $('#selType').change(function () {
        let selectedValue = $(this).val();
        $('#txtPercent').parent().hide();
        $('#txtMaxPrice').parent().hide();
        $('#txtPrice').parent().hide();
        if (selectedValue == 1){
            $('#txtPrice').parent().show();
        } else if (selectedValue == 100) {
             $('#txtPercent').parent().show();
            $('#txtMaxPrice').parent().show();
        }
    });
    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }
    $('#selType').trigger('change');

</script>
@endsection