@extends('../template')

@section('title', 'File update')

@section('content')
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Updating file '{{ $f->name }}'</h3>
        <div class="box-tools pull-right">
            <!-- Collapse Button -->
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    
    <div class="box-body">
        <!-- form start -->
        <form role="form" id="files-update" action="{{ app('url')->to('files') }}/{{ $f->id }}" method="POST">
            <div class="form-group">
                <label>Category</label>
                <select name='category' class="form-control" value='{{ $f->category }}'>
                    <option {{ $f->category == 'Book' ? 'selected' : '' }}>Book</option>    
                    <option {{ $f->category == 'Document' ? 'selected' : '' }}>Document</option>
                    <option {{ $f->category == 'Movie' ? 'selected' : '' }}>Movie</option>
                    <option {{ $f->category == 'Music' ? 'selected' : '' }}>Music</option>
                    <option {{ $f->category == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="filename">File name</label>
                <input value='{{ $f->name }}' class="form-control" type='text' name="name" id="name" placeholder="New file name. Don't forget the .extension!"/>
            </div>
        </form>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" form="files-update" class="btn btn-primary">Submit</button>
    </div>
</div>
<!-- /.box -->
@stop

@section('form-scripts')
<script>
    $(function () {
        $("#files-update").ajaxForm({
            data: $(this).serialize(),
            success: function(message) {
                fm.addMessage("success", message);
            },
            error: function(request) {
                fm.addMessage(request.status == 500 ? "danger" : "warning", request.responseJSON.error);
            },
            complete: function() {
                window.location = "{{ app('url')->to('files') }}";
            }
        });
    })
</script>
@stop