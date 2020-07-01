
// Display the images that the user has selected from their system
// Before we complete the upload (as triggered by the submit / upload button)

var previewVideo = function()

{

var file;
var fileCount = document.querySelector('input[type=file]').files.length;

var newDomElement = "";
var newImagesDiv = $("#newImages");
var preview = null;
var readers = [];

if (fileCount > 0) {
   // $('#files').css({'display':'none'});
    $('#upload').css({'display':'block'});
    if (fileCount < 2) {
    $('#upload').html('Upload This Video'); }

}
// for (var i =0; i < fileCount; i++) {
  //  file = document.querySelector('input[type=file]').files[0];
    // newDomElement = "<img class='previewImage' id='previewImage" + i + "'><br>";
    // $(newImagesDiv).append(newDomElement);
    
    //readers[0] = new FileReader();

    // readers[0].addEventListener("load", function () {
     
    //     this.preview.src = this.result;
    // }, false);

    // if (file)
    // {
    //     readers[0].readAsDataURL(file);
    //     readers[i].preview =  document.querySelector('#previewImage' + i);
    // }
// }







}