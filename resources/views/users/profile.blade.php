@extends('../template')

@section('title', "User profile of '$user->fullname'")

@section('content')
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">General data</h3>
    </div>
    <!-- box-header -->

    <div class="box-body">
        <dl>
            <dt>Name</dt>
            <dd>{{ $user->fullname }}</dd>
            <dt>Username</dt>
            <dd>{{ $user->username }}</dd>
            <dt>Identification in the system</dt>
            <dd>{{ $user->id }}</dd>
        </dl>
    </div>
    <!-- box-body -->
</div>
<!-- box -->

@if( Auth::user()->id === $user->id )
<div class="box box-danger">
    <div class="box-header">
        <h3 class="box-title">Password update</h3>
    </div>
    <!-- box-header -->
    
    <div class="box-body">
        <form role="form" id="users-update" action="{{ app('url')->to('users') }}/{{ $user->id }}/profile" method="POST">
            <div class="form-group">
                <label>Old password</label>
                <input name='old_password' type="password" class="form-control" placeholder="Old password" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input name='password' type="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label>Password confirmation</label>
                <input name='password_confirmation' type="password" class="form-control" placeholder="Confirm your password" required>
            </div>
        </form>
        <!-- form -->
    </div>
    <!-- box-body -->

    <div class="box-footer">
        <button type="submit" form="users-update" class="btn btn-primary">Submit</button>
    </div>
    <!-- box-footer -->
</div>
<!-- box -->
@endif

<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Uploaded files</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <!-- box-tools -->
    </div>
    <!-- box-header -->

    <div class="box-body">
        <table id="user-files-list" class="table table-bordered table-striped fs-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Last update</th>
                    <th>Created at</th>
                    <th class="fs-table-action">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->files as $f)
                <tr id='fs-table-row-{{ $f->id }}'>
                    <td>{{ $f->id }}</td>
                    <td>{{ $f->name }}</td>
                    <td><span class='label label-{{ strtolower($f->category) }}'>{{ $f->category }}</span></td>
                    <td>{{ $f->updated_at->format("d/m/Y, H:i:s") }}</td>
                    <td>{{ $f->created_at->format("d/m/Y, H:i:s") }}</td>
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
                    <th>Created at</th>
                    <th class="fs-table-action">Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- box-body -->
</div>
<!-- box -->

@stop

@section('table-scripts')
<script>
  $(function () {
    $('#user-files-list').DataTable({
        columnDefs: [ { orderable: false, targets: [5] }, { searchable: false, targets: [5] } ]
    });
  })
</script>
@stop

@section('form-scripts')
<script>
  $(function () {
      
    $('#users-update').validate({
        rules: {
            old_password: {
                required:true,
            },
            password: {
                required:true,
                minlength : 5
            },
            password_confirmation: {
                required:true,
                minlength : 5,
                equalTo : '[name="password"]'
            }
        }
    });
  });
</script>
@stop