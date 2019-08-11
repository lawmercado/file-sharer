@if( app('session')->has('message') )
<div id="flash-messages">
  <div class="alert alert-{{ app('session')->get('message-level') }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-{{ app('session')->get('message-icon') }}"></i>Status</h4>
    {{ app('session')->get('message') }}
  </div>

</div>
@endif