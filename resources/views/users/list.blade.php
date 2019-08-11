@extends('../template')

@section('title', 'Users')
@section('description', 'Below you can list the users and operate over them')

@section('content')

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <table id="users-list" class="table table-bordered table-striped fs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Registered at</th>
                        <th># of files</th>
                        <th class="fs-table-action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr id='fs-table-row-{{ $u->id }}'>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->fullname }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->created_at->format("d/m/Y, H:i:s") }}</td>
                        <td>{{ count($u->files) }}</td>
                        <td class="fs-table-action">
                            <div class="btn-group">
                                <a href='{{ app("url")->to("users") }}/{{ $u->id }}/profile' class="btn text-primary"><i class="fa fa-user"></i></a>
                                @if( Auth::user()->id !== $u->id && Auth::user()->isAdmin() )
                                    <a href='{{ app("url")->to("users") }}/{{ $u->id }}/delete' class="btn text-danger"><i class="fa fa-trash"></i></a>
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
                        <th>Username</th>
                        <th>Registered at</th>
                        <th># of files</th>
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
    $('#users-list').DataTable({
        columnDefs: [ { orderable: false, targets: [4] }, { searchable: false, targets: [4] } ]
    });
  })
</script>
@stop