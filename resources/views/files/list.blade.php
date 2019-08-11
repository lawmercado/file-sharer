@extends('../template')

@section('title', 'Files')
@section('description', 'Below you can upload files and find a list of all uploaded files')

@section('content')

@if( Auth::user()->isAdmin() )
    @include('files/create')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <table id="files-list" class="table table-bordered table-striped fs-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Uploaded at</th>
                        <th class="fs-table-action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $f)
                    <tr id='fs-table-row-{{ $f->id }}'>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->name }}</td>
                        <td><span class='label label-{{ strtolower($f->category) }}'>{{ $f->category }}</span></td>
                        <td>{{ $f->created_at->format("d/m/Y, H:i:s") }}</td>
                        <td class="fs-table-action">
                            <div class="btn-group">
                                <a data-action='download' data-subject='{{ $f->id }}' class="btn text-primary"><i class="fa fa-download"></i></a>
                                @if( Auth::user()->isAdmin() )
                                    <a href='{{ app("url")->to("files") }}/{{ $f->id }}' class="btn text-primary"><i class="fa fa-edit"></i></a>
                                    <a data-action='delete' data-subject='{{ $f->id }}' class="btn text-danger"><i class="fa fa-trash"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Uploaded at</th>
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
        columnDefs: [ { orderable: false, targets: [4] }, { searchable: false, targets: [4] } ]
    });

    $('#files-list a[data-action="delete"').on('click', function() {
        let subject = $(this).data('subject');

        $.ajax({
            url: "{{ app('url')->to('files') }}/" + subject,
            method: "delete",
            success: function(message) {
                fm.addMessage('success', message);
            },
            error: function(request) {
                fm.addMessage('danger', request.responseJSON.error);
            },
            complete: function() {
                window.location = "{{ app('url')->to('files') }}";
            }
        });
    });

    $('#files-list a[data-action="download"').on('click', function() {
        let subject = $(this).data('subject');
        window.location = "{{ app('url')->to('files') }}/" + subject + "/download";        
    });

  })
</script>
@stop