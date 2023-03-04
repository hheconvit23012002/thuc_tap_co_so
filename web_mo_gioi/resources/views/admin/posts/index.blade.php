@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header form-inline">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        Create
                    </a>
                    <form>
                        <label class="btn btn-info ml-2" for="csv">Import CSV</label>
                        <input type="file" name="csv" id="csv" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Remotable</th>
                                <th>Is Part-time</th>
                                <th>Range Salary</th>
                                <th>Date Range</th>
                                <th>Status</th>
                                <th>Is Pinned</th>
                                <th>Create At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-rounded mb-0" id="paginate">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('api.posts')}}',
                dataType: 'json',
                data: {page: {{ request()->get('page') ?? 1}}  },
                success :function(response){
                    response.data.data.forEach(function(value,index){
                        let location = value.district+ '-' + value.city
                        let remotable = value.remotable ? 'x' : ''
                        let is_partime = value.is_partime ? 'x' : ''
                        let range_salary = (value.min_salary &&  value.max_salary) ? value.min_salary+ '-' + value.max_salary : ''
                        let range_date = (value.start_date &&  value.end_date) ? value.start_date+ '-' + value.end_date : ''
                        let is_pinned = value.is_pinned ? 'x' : ''
                        let created_at  = moment(new Date(value.created_at)).subtract(10, 'days').calendar();
                        $('#table-data').append($('<tr>')
                            .append($('<td>').append(value.id))
                            .append($('<td>').append(value.job_title))
                            .append($('<td>').append(location))
                            .append($('<td>').append(remotable))
                            .append($('<td>').append(is_partime))
                            .append($('<td>').append(range_salary))
                            .append($('<td>').append(range_date))
                            .append($('<td>').append(value.status))
                            .append($('<td>').append(is_pinned))
                            .append($('<td>').append(created_at))

                        )
                    })
                    renderPagination(response.data.pagination)
                },
                error: function(response) {
                    /* Act on the event */
                    $.toast({
                        heading: 'Import Error',
                        text: response.responseJSON.message,
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'error'
                    })
                },
            })
            $(document).on('click','#paginate > li > a',function (e){
                e.preventDefault();
                let page = $(this).text()
                let urlParams = new URLSearchParams(window.location.search)
                urlParams.set('page',page)
                window.location.search = urlParams
            })
            $("#csv").change(function(event) {
                /* Act on the event */
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    url: '{{ route('admin.posts.import_csv')}}',
                    type: 'POST',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data have been imported',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'success'
                        })
                    },
                    error: function(response) {
                        /* Act on the event */
                    }
                })
            });
        });
    </script>
@endpush
