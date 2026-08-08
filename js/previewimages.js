
// Display the image that the user has selected from their system
// Before we complete the upload (as triggered by the submit / upload button)

var previewFile = function()

{
    var file;
    var reader = null;
    file = document.getElementById('uploadfile').files[0];

    check_filename =  document.querySelector('input[type=file]').value;
    check_extension = check_filename.split('.');
    
    if (check_extension.length > 0 )
    {
        check_ext_part = check_extension[check_extension.length-1];
        if ( (check_ext_part != 'jpg') && (check_ext_part != 'JPG') 
        && (check_ext_part != 'jpeg' && (check_ext_part != 'Jpeg')) ) 
        {
            alert("Only Jpegs are allowed.");
        } else {
    
        reader = new FileReader();
        reader.addEventListener("load", function () { 
            this.preview.src = this.result;
        }, false);

        if (file)
        {
            reader.readAsDataURL(file);
            var previewer = document.getElementById('previewImage');
            var uploadButton = document.getElementById('upload');
            var fileChooser = document.getElementById('uploadfile');
            // var cancel = document.getElementById('cancel');

            previewer.classList.remove('hidden');
            uploadButton.classList.remove('hidden');
            // cancel.classList.remove('hidden');
            fileChooser.classList.add('hidden');
            reader.preview =  previewer;
            
        }
    }

  }
    
}
