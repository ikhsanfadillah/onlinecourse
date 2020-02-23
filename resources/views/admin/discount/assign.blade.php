@extends('layouts.admin')
@section('title','Discount')
@section('subTitle',"Discount ")
@section('style')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

@endsection
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('discounts.index') }}">Discounts</a></li>
        <li class="breadcrumb-item active">{{ $discount->code }}</li>
    </ol>
@endsection
@section('content')

    <!-- form start -->
    <div class="row">
        <div class="col-sm-6">
            <form action="{{ route('discounts.do-assign',$discount->id) }}" method="post">
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

                                <h3>{{ $discount->code }}</h3>
                                <p>{{ $discount->desc }}</p>
                                <div class="form-group">
                                    <label for="selType">Assign discount to</label>
                                    @php $assignedMentors = $discount->mentors->pluck('mentor_id')->toArray() @endphp
                                    <select name="mentors[]" class="form-control select2bs4 @error('type') is-invalid @enderror" id="selType" multiple="multiple" style="width: 100%;" >
                                        @foreach ($mentors as $key => $mentor)
                                            <option value="{{ $mentor->mentor_id }}"
                                                {{ (collect(old("mentors"))->contains($mentor->mentor_id) ? "selected":"") }}
                                                {{ (in_array($mentor->mentor_id,$assignedMentors)) ? 'selected' : ''}}>
                                                {{ $mentor->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
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