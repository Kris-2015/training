/**
 * Name: Map.js  file 
 * Purpose: Uploadin picture by ajax 
 * Package: public/js
 * Created On: 24th August, 2016
 * Author: msfi-krishnadev
*/

//dropzone id
Dropzone.options.upload = { 
    url: 'image',
    type:'POST',
    paramName: "file", 
    maxFilesize: 2,
    maxThumbnailFilesize: 5,
    thumbnailWidth: 160,
    thumbnailHeight: 160,
    accept: function(file, done) {

        if(file == null){
            done("It does not any files!!");
        }
        else{ done(); }
    }
};