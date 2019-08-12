@extends('../template')

@section('title', 'Files')
@section('description', 'Below you can upload files and find a list of all uploaded files')

@section('content')

@if( Auth::user() )
    @include('files/create')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <table id="files-list" class="table table-bordered table-striped fs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Last update</th>
                        <th>User</th>
                        <th class="fs-table-action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $f)
                    <tr id='fs-table-row-{{ $f->id }}'>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->name }}</td>
                        <td><span class='label label-{{ strtolower($f->category) }}'>{{ $f->category }}</span></td>
                        <td>{{ $f->updated_at->format("d/m/Y, H:i:s") }}</td>
                        <td><a href="{{ app('url')->to('users') }}/{{ $f->user->id }}/profile">{{ $f->user->fullname }}</a></td>
                        <td class="fs-table-action">
                            <div class="btn-group">
                                <a href='{{ app("url")->to("files") }}/{{ $f->id }}/download' class="btn text-primary"><i class="fa fa-download"></i></a>
                                @if( Auth::user()->isAdmin() || $f->user->id === Auth::user()->id )
                                    <a href='{{ app("url")->to("files") }}/{{ $f->id }}/update' class="btn text-primary"><i class="fa fa-edit"></i></a>
                                    <a href='{{ app("url")->to("files") }}/{{ $f->id }}/delete' class="btn text-danger"><i class="fa fa-trash"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Last update</th>
                        <th>User</th>
                        <th class="fs-table-action">Actions</th>
                    </tr>
                </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@stop

@section('table-scripts')
<script>
  $(function () {
    $('#files-list').DataTable({
        columnDefs: [ { orderable: false, targets: [5] }, { searchable: false, targets: [5] } ]
    });
  })
</script>
@stop