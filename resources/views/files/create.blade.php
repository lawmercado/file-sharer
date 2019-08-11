<div class="box box-primary collapsed-box">
    <div class="box-header">
        <h3 class="box-title">Upload a new file</h3>
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
        <form role="form" id="files-create" action="{{ app('url')->to('files') }}" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">File input</label>
                <input type="file" name="file" id="file">
            </div>

            <div class="form-group">
                <label>Category</label>
                <select name='category' class="form-control">
                    <option>Book</option>
                    <option>Document</option>
                    <option>Movie</option>
                    <option>Music</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="filename">File name</label>
                <input class="form-control" type='text' name="name" id="name" placeholder="New file name. Don't forget the .extension!"/>
            </div>
        </form>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" form="files-create" class="btn btn-primary">Submit</button>
    </div>
</div>
<!-- /.box -->

@section('form-scripts')
<script>
    $(function () {
        $("#files-create").ajaxForm({
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