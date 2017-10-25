@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.permissions.management'))

@section('after-styles')
    {{ Html::style("/css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@endsection

@section('page-header')
    <h1>{{ trans('labels.backend.access.permissions.management') }}</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.permissions.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.permission-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="permissions-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.access.permissions.table.ID') }}</th>
                            <th>{{ trans('labels.backend.access.permissions.table.name') }}</th>
                            <th>{{ trans('labels.backend.access.permissions.table.display_name') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! history()->renderType('Permission') !!}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection

@section('after-scripts')
    {{ Html::script("/js/backend/plugin/dt-1.10.15/datatables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables-extend.js") }}

    <script>
        $(function() {
            $('#permissions-table').DataTable({
                dom: 'lfrtip',
                processing: false,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route("admin.access.permission.get") }}',
                    type: 'post',
                    error: function (xhr, err) {
                        if (err === 'parsererror')
                            location.reload();
                    }
                },
                columns: [
                    {data: 'id', name: '{{config("access.permissions_table")}}.ID'},
                    {data: 'name', name: '{{config("access.permissions_table")}}.name'},
                    {data: 'display_name', name: '{{config("access.permissions_table")}}.display_name', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                // order: [[1, "asc"]]
            });
        });
    </script>
@endsection
