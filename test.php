<html>
<body>
<script>
"use strict";

window.loadedImages = [];

function loaded(element) {
    console.log('done loading:' + element);
}
let collection = ["fish","cats","birds","sharks","dogs"];
let files = ['abbey_1552075931.jpg','action_1552075932.jpg','acuatico_1552075933.jpg','apartheidwall_1552104351.jpg','arrived_1552075939.jpg','basic_1552075945.jpg'];
let i = 0;
let imageLoader = setTimeout( function loadImage() {
    
    if (i >= (collection.length) ) 
    {
        clearTimeout(imageLoader);
    } else 
    {
        i++;
        console.log(i);
        let image = new Image();
        image.src = 'uploads/artwork/' + files[i];
        image.addEventListener('load', function() { loaded(this); } );
        window.loadedImages.push(image);

        setTimeout(loadImage, 100);
    }
}, 100);

</script>

</body>
</html>
