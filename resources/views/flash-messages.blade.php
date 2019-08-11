<div id='flash-messages'>
</div>

@section('flash-messages-scripts')
  <script>
    var fm = {
      addMessage: function(type, message) {
        let icon = 'info';

        switch(type) {
          case 'success':
            icon = 'check'; break;

          case 'danger':
            icon = 'ban'; break;

          case 'warning':
            icon = 'warning'; break;
          
          default:
            icon = 'info';
        }

        let messages = JSON.parse(localStorage.getItem('messages'));

        let data = {'type': type, 'icon': icon, 'content': message};

        if( !Array.isArray(messages) ) {
          messages = [];
        }
        
        messages.push(data);

        localStorage.setItem('messages', JSON.stringify(messages));
      }
    };

    $(function() {
      let messages = JSON.parse(localStorage.getItem('messages'));

      if( Array.isArray(messages) ) {
        for( let i = 0; i < messages.length; i++ ) {
          item = messages[i];
          let template = `<div class='alert alert-${item.type} alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class="icon fa fa-${item.icon}"></i>Status</h4>${item.content}</div>`;

          $('#flash-messages').append(template);
        }
      }

      localStorage.setItem('messages', JSON.stringify([]));
    });
  </script>
@stop