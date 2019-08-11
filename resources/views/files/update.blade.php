@extends('../template')

@section('title', 'File update')

@section('content')
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Updating file '{{ $f->name }}'</h3>
    </div>
    <!-- /.box-header -->
    
    <div class="box-body">
        <!-- form start -->
        <form role="form" id="files-update" action="{{ app('url')->to('files') }}/{{ $f->id }}/update" method="POST">
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