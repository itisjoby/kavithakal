
$(document).ready(function(){
   
    $(".add_new_story").on('click',function(){
        
$("#addnewcontent").modal('show');
$('.tags').tagsInput({
   'height':'100px',
   'width':'100%',
   'interactive':true,
   'defaultText':'add tags',
   'delimiter': ['####'],   // Or a string with a single delimiter. Ex: ';'
   'removeWithBackspace' : true,
   'minChars' : 2,
   'maxChars' : 0, // if not provided there is no limit
   'placeholderColor' : '#666666'
});
// Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                
                CKEDITOR.replace( 'mini_content' );
                CKEDITOR.replace( 'content' ,{
    filebrowserBrowseUrl: '/browser/browse.php',
    filebrowserUploadUrl: '/uploader/upload.php'
});
    });
    
    $(".content_form").on('submit',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        for(var instanceName in CKEDITOR.instances){
            
            CKEDITOR.instances['mini_content'].updateElement();
            CKEDITOR.instances['content'].updateElement();
        }
        
        let title=$("[name='title'").val();
        let mini_content=$("[name='mini_content'").val();
        let content=$("[name='content'").val();
        let tags=$("[name='tags'").val();
        savePost(title,mini_content,content,tags);
    })
                        
  
});
function savePost(title,mini_content,content,tags){
    
    $.ajax({
                url: base_url + "/Admin/savePost/",
                type: 'POST',
                dataType: 'json',
                data:{content:content,title:title,mini_content:mini_content,tags:tags},
                async: true,
                beforeSend: function (xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    // setting a timeout
                    $(".page-loader").show();
                },
                success: function (data)
                {
                    $(".page-loader").hide();
                    if (data['status'] == 1) {
                       location.href=base_url+'/admin'
                    }
                    else{
                        let error_msg=`<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  ${data['msg']}
</div>`;
                        $('.error_screen').html(error_msg);
                    }
                }
            });
}