
// Display the images that the user has selected from their system
// Before we complete the upload (as triggered by the submit / upload button)

var previewFile = function()

{
    var file;
    var newDomElement = "";
    var newImagesDiv = $("#newImages");
  
    $('img.editthumb').remove();
    var reader = null;
    file = document.querySelector('input[type=file]').files[0];
    check_filename =  document.querySelector('input[type=file]').value;
    check_extension = check_filename.split('.');
    
    if (check_extension.length >0 )
    {
        check_ext_part = check_extension[check_extension.length-1];
        if ( (check_ext_part != 'jpg') && (check_ext_part != 'JPG') && (check_ext_part != 'gif') && (check_ext_part != 'GIF') && (check_ext_part != 'png') && (check_ext_part != 'PNG')
        && (check_ext_part != 'jpeg' && (check_ext_part != 'Jpeg')) ) 
        {
            alert("Only Jpegs, Gifs and Png Image formats are allowed.");
        } else {
    

        newDomElement = "<img class='previewImage' id='previewImage0'><br>";
        $(newImagesDiv).append(newDomElement);
        reader = new FileReader();
        reader.addEventListener("load", function () { 
            this.preview.src = this.result;
        }, false);

        if (file)
        {
            reader.readAsDataURL(file);
            reader.preview =  document.querySelector('#previewImage0');
            $('.fakeUploadImageButton').hide();
            $('#uploadfile').hide();
            $('.includeImage').hide();
        }
    }

  }
    
}

var previewTmpFile = function(tmpfile) 
{
    var file;
    var newDomElement = "";
    var newImagesDiv = $("#newImages");
  
    var reader = null;
    file = tmpfile;
    newDomElement = "<img class='previewImage' id='previewImage0'><br>";
    $(newImagesDiv).append(newDomElement);
    reader = new FileReader();
    reader.addEventListener("load", function () { 
        this.preview.src = this.result;
    }, false);

    if (file)
    {
        reader.readAsDataURL(file);
        reader.preview =  document.querySelector('#previewImage0');
       
        
    }
}

var previewFiles = function()

{

var file;
var fileCount = document.querySelector('input[type=file]').files.length;

var newDomElement = "";
var newImagesDiv = $("#newImages");
var preview = null;
var readers = [];

if (fileCount > 0) {
   // $('#files').css({'display':'none'});
   $('.chooseButton').hide();
}
for (var i =0; i < fileCount; i++) {
    file = document.querySelector('input[type=file]').files[i];
    
    newDomElement = "<div class='previewBox'><img class='previewImage' id='previewImage" + i + "'></div>";
    $(newImagesDiv).append(newDomElement);
    
    readers[i] = new FileReader();

    readers[i].addEventListener("load", function () {
     
        this.preview.src = this.result;
    }, false);

    if (file)
    {
        readers[i].readAsDataURL(file);
        readers[i].preview =  document.querySelector('#previewImage' + i);
    }
}
$(newImagesDiv).append("<br clear='all'>");

}
