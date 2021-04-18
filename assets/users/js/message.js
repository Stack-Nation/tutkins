$('document').ready(function(){
    // Sends text message when Enter key is pressed
    $('#messagebar').keyup(function(event){
        if (event.keyCode == 13 && !event.shiftKey) {
            $('#messagebar').html($('#messagebar').html().replace(/<div><br><\/div>/gm,""));
            if($('#messagebar').html()!="" && !$('#messagebar').html().match(/^(&nbsp;|\s|<div>|<\/div>)+$/gm)){
                $('#messagebar').attr('contenteditable','false');
                var formData = {
                    '_token' : $('input[name=_token]').val(),
                    'message':$('#messagebar').html(),
                    'receiver' : localStorage.getItem('receiver'),
                };
                $.ajax({
                    type: 'POST',
                    url: $('#messageForm').attr('action'),
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                    .done(function(data){
                        displayMessages();
                        $('#messagebar').html('');
                        $('#messagebar').attr('contenteditable','true');
                    });
            }
        }
      });
    //   Sends a file
    $('#messageFile').change(function(){
        $('#messagebar').attr('contenteditable','false');
        var formData = new FormData($('#fileForm')[0]);
        formData.append('receiver',localStorage.getItem('receiver'));
        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url : $('#fileForm').attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
        })
            .done(function(data){
                if(data==1){
                    displayMessages();
                    $('#messagebar').html('');
                    $('#messagebar').attr('contenteditable','true');
                }
                else{
                    alert('File could not be uploaded');
                    $('#messagebar').html('');
                    $('#messagebar').attr('contenteditable','true');
                }
            });
    });
    // Sends an image
    $('#messageImage').change(function(){
        $('#messagebar').attr('contenteditable','false');
        var formData = new FormData($('#imageForm')[0]);
        formData.append('receiver',localStorage.getItem('receiver'));
        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url : $('#imageForm').attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
        })
            .done(function(data){
                if(data==1){
                    displayMessages();
                    $('#messagebar').html('');
                    $('#messagebar').attr('contenteditable','true');
                }
                else{
                    alert('Image could not be uploaded');
                    $('#messagebar').html('');
                    $('#messagebar').attr('contenteditable','true');
                }
            });
    });

    // Checks for new messages every 5secs

    if(localStorage.getItem('receiver')!=''){
        setInterval(function(){
            displayMessages();
        }, 5000);
    }
      
});

// Allows the user to select file
function openFile(){
    $('#messageFile').click();
}
// Allows the user to select image
function openImage(){
    $('#messageImage').click();
}
// Display list of messages
function displayMessages(){
    var formData = {
        'receiver':localStorage.getItem('receiver'),
        '_token':$('input[name=_token]').val(),
    };
    var urll = localStorage.getItem('display_message_route');
    $.ajax({
        type:'POST',
        url: urll,
        data: formData,
        dataType:'json',
        encode:true,
    })
        .done(function(data){
            $('#message-area').html('');
            messages = data.messages;
            messages.forEach(function(message){
                    let date = new Date(message.created_at);
                    var di = `
                    <div class="card d-inline-block mb-3 mr-2 ${message.sender_id==localStorage.getItem('receiver')? "no-shadow bg-lighter float-left": "bg-primary float-right"} max-w-p80" style="min-width:200px">
                      <div class="position-absolute pt-1 pr-2 r-0">
                          <span class="text-extra-small">${date.toLocaleDateString()}</span>
                      </div>
                      <div class="card-body">
                          <div class="chat-text-left pl-55">
                            ${message.message}
                          </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    `;
                    $('#message-area').append(di);
            });
        });
}
// Will open a modal so the user can view the image in its original size
function view_img(obj){
    $("#view-img-modal").html("<img src=\""+$($(obj)[0]).children().attr('src')+"\" style=\"max-width:100%;max-height:100%\">");
    $('#imgModal').modal('show');
}
// Will display the message of selected user
function display_user_message(id){
    localStorage.setItem('receiver',id);
    displayMessages();
}