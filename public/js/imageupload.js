            
    function previewImages() {

        var preview = document.querySelector('#preview');

        if (this.files) {
            [].forEach.call(this.files, readAndPreview);
        }

        function readAndPreview(file) {
            // Make sure `file.name` matches our extensions criteria
            var filename = file.name;
            var file_extension = filename.split('.').pop();
        
            if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) {
                return alert(file.name + " is not an image");
            } // else...
            
            if(file.size > 1000000)
            {
                return alert(file.name + " size can't be greater than 1 MB");
                return;
            }

            var reader = new FileReader();
            
            reader.addEventListener("load", function() {
                
                if(file_extension!='pdf')
                {
                    $("<span class=\"pip col-3\">" +
                    "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" + 
                    "<img class=\"images_upload\" src=\"" + this.result + "\" title=\"" + file.name + "\"/>" +
                    "</span>").insertAfter("#preview");
                }
                else{

                    $("<span class=\"pip col-4\">" +
                    "<span class=\"remove\"><i class=\"fa fa-times\"></i></span><br/>" + 
                    "<span class=\"images_upload pdf_file\" ><i class='fa fa-pdf'></i>"+file.name+"</span>" +
                    "</span>").insertAfter("#preview_pdf");
                
                }
            


                $(".remove").click(function(){
                    $(this).parent(".pip").delay(200).fadeOut();
                });


            });
            
            reader.readAsDataURL(file);
                
        }

    }
       
    document.querySelector('#file-input').addEventListener("change", previewImages);

    var remove_images = [];
    $(".remove").click(function(){
        event.preventDefault();
        let img_val =  $(this).attr('href');
        remove_images.push(img_val);
        $('#remove_images').val(remove_images);
        $(this).parent(".pip").remove();
    });