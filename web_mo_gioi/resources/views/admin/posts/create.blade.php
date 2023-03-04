@extends('layout.master')
@push('css')
<style>
    .error{
        color:red;
    }
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div id="div-error" class="alert alert-danger d-none"></div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('admin.posts.store') }}" method="POST" id="form-create">
                    @csrf
                    <div class="form-group">
                        <label>Company</label>
                        <select class="form-control" name="company" id="select-company"></select>
                    </div>
                    <div class="form-group">
                        <label>Language</label>
                        <select class="form-control" multiple name="language[]" id="select-language">
                        </select>
                    </div>
                    <div class="form-row select-location">
                        <div class="form-group col-6">
                            <label>City</label>
                            <select class="form-control" name="city" id="select-city">
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>District</label>
                            <select class="form-control select-district" name="district" id="select-district">
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Min Salary</label>
                            <input type="number" name="min_salary" class="form-control">
                        </div>
                        <div class="form-group col-4">
                            <label>Max Salary</label>
                            <input type="number" name="max_salary" class="form-control">
                        </div>
                        <div class="form-group col-4">
                            <label>Max Salary</label>
                            <select name="currency_salary" class="form-control">
                                @foreach($currencies as $currency => $value)
                                    <option value="{{$value}}">
                                        {{ $currency}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Requirement</label>
                            <textarea name="requirement" class="form-control col-12" ></textarea>
                        </div>
                        <div class="form-group col-6">
                            <label>Number Applicants</label>
                            <input type="number" name="number_applicants" class="form-control col-12" ></input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control" ></input>
                        </div>
                        <div class="form-group col-6">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control" ></input>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" id="title"></input>
                        </div>
                        <div class="form-group col-6">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" id="btn-submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal-company" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title float-left">Create Company</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{ route('admin.companies.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Company</label>
                        <input readonly name="company" id="company" class="form-control">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label>Address2</label>
                            <input type="text" name="address2" class="form-control">
                        </div>
                    </div>
                    <div class="form-row select-location">
                        <div class="form-group col-6">
                            <label>City</label>
                            <select class="form-control" name="city" id="city">
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>District</label>
                            <select class="form-control select-district" name="district" id="district">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">create</button>
            </div>
        </div>

    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script>
    function generateTitle() {
        let languages = [];
        let selectedLanguage = $('#select-language :selected').map(function (i,v){languages.push($(v).text())});
        languages = languages.join(', ')
        let city = $('#select-city').val();
        let company = $('#select-company').text();
        let title = `(${city}) ${languages}`
        if(company){
            title +=' - '+company
        }

        $('#title').val(title)
        generateSlug(title);
    }
    function generateSlug(title){
        $.ajax({
            url: '{{ route('api.posts.slug.generate')}}',
            type: 'POST',
            dataType: 'json',
            data: {title},
            success: function(response){
                $('#slug').val(response.data)
                $('#slug').trigger('change');
            },
            error: function(response) {
                /* Act on the event */
            }
        })

    }
    async function loadDistrict(parent){
        parent.find('.select-district').empty()
        const city =  parent.find('option:selected').data('path');
        const district = await fetch('{{ asset('locations/') }}' + city).then((responseData) => responseData.json())
        let string = ''
        const selectedValue = $("#select-district").val()
        $.each(district.district,function(index,each){
            if(each.pre === 'Quận'){
                string += `<option`
                if(selectedValue === each.name){
                    string += ' selected '
                }
                string += `>${each.name}</option>`
            }
        })
        parent.find('.select-district').append(string)

    }
    async function checkCompany(){
        $.ajax({
            url: '{{ route('api.companies.check') }}/' + $("#select-company").val(),
            type: 'GET',
            dataType: 'json',
            success:async function(response){
                if(response.data){
                    submitForm();
                }else{
                    $("#modal-company").modal('show');
                    $("#company").val($("#select-company").val());
                    $("#city").val($("#select-city").val()).trigger('change');
                }
            },
            error: function(response) {
                /* Act on the event */
            }
        })
    }
    async function submitForm(){
        $.ajax({
            url: $("#form-create").attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $("#form-create").serialize(),
            success: function(response){
                $("#div-error").hide();
            },
            error: function(response){
                const errors = response.responseJSON.errors;
                let string = '<ul>'
                Object.values(errors).forEach(function(each){
                    each.forEach(function(error){
                        string += `<li>${error}</li>`;
                    })
                })
                string += '</ul>';
                $("#div-error").html(string);
                $("#div-error").removeClass("d-none").show();
            }
        })
    }
    $(document).ready(async function() {
        $('#select-city').select2()
        $('#city').select2()
        // $('#select-district').select2()
        const cities = await fetch('{{ asset('locations/index.json') }}').then((responseData) => responseData.json())
        $.each(cities,function(index,each){
            $('#select-city').append(`<option data-path='${each.file_path}'>${index}</option>`)
            $('#city').append(`<option data-path='${each.file_path}'>${index}</option>`)
        })
        $('#select-city, #city').change(function(){
            loadDistrict($(this).parents('.select-location'));
        })
        loadDistrict($('#select-city').parents('.select-location'));
        $("#select-company").select2({
          tags: true,
          ajax: {
              delay: 250,
              url: '{{ route('api.companies') }}',
              data: function (params) {
                  return {
                    q: params.term
                };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.data, function (item) {
                          return {
                              text: item.name,
                              id: item.id
                          }
                      })
                  };
              },
          }
      });
        $("#select-language").select2({
            ajax: {
                delay: 250,
                url: '{{ route('api.languages') }}',
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
        $(document).on('change','#select-company, #select-city,#select-language',function(){
            generateTitle()
        })
        $("#slug").change(function(){
            $("#btn-submit").attr('disabled',false)
            $.ajax({
                url: '{{ route('api.posts.slug.check')}}',
                type: 'GET',
                dataType: 'json',
                data: {slug: $(this).val()},
                success: function(response){
                    if(response.success) {
                        $("#btn-submit").attr('disabled',false)
                    }
                }
            })
        })
        $("#form-create").validate({
            rules: {
                company: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                checkCompany();
            }
        });
    });
</script>
@endpush
