/*jshint esversion: 6 */
const initialUploadImage= (id,remove_element=null) => {
    if ($uploadCrop== null) {
        let maxWidth=document.querySelector(id).offsetWidth;
        if (maxWidth>350) {
            maxWidth=350;
        }
        if (remove_element){remove_element.remove();}
        $uploadCrop = $(id).croppie({
            viewport: {
                width: maxWidth-50,
                height: maxWidth-50,
                type: 'square'
            },
            boundary: {
                width: maxWidth,
                height: maxWidth
            },
            enableExif: true
        });
        return 'first';
    }
    return 'last';
};
const initialExistImage= (id) => {
    if ($uploadCrop== null) {
        let maxWidth=document.querySelector(id).offsetWidth;
        if (maxWidth>350) {
            maxWidth=350;
        }
        $uploadCrop = $(id).croppie({
            viewport: {
                width: maxWidth-50,
                height: maxWidth-50,
                type: 'square'
            },
            boundary: {
                width: maxWidth,
                height: maxWidth
            },
            enableExif: true
        });
        $uploadCrop.croppie('bind', {
            url: document.querySelector('#single-image-url').getAttribute('value'),
        });
    }
};
let image_changed=false;
var $uploadCrop=null;
$('.upload-image + input').on('change', function () {
    initialUploadImage('#website-logo',document.querySelector('.websie-logo-img'));
    readFile(this);
});

$('.upload-multi-image + input').on('change', function () {
    let elemnet=this;
    if (!elemnet.files || !elemnet.files[0]){
        return;
    }
    image_changed=true;
    let status=initialUploadImage('#single-image');

    if (status=='last' && $uploadCrop && $uploadCrop !== null) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            let image_container = document.createElement('span');
            let image_remover= document.createElement('span');
            let new_image = document.createElement('img');
            let new_image_input = document.createElement('input');
            image_container.setAttribute('class', 'product-image');
            image_remover.innerHTML='&#x2715';
            image_remover.setAttribute('class', 'image-remover');
            image_remover.setAttribute('onclick', 'image_remover(this)');
            new_image_input.setAttribute('type', 'hidden');
            new_image_input.setAttribute('name', 'product-images[]');
            new_image_input.setAttribute('value', resp);
            new_image.setAttribute('src', resp);
            image_container.appendChild(image_remover);
            image_container.appendChild(new_image);
            image_container.appendChild(new_image_input);
            document.querySelector('#product-images').appendChild(image_container);
            readFile(elemnet);
        });
    }else{
        readFile(elemnet);
    }
});

$('.upload-single-image + input').on('change', function () {
    let elemnet=this;
    if (!elemnet.files || !elemnet.files[0]){
        return;
    }
    image_changed=true;
    let status=initialUploadImage('#single-image');
    readFile(elemnet);
});

const image_remover = (element) => {
    element.parentElement.remove();
};

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e){
            $uploadCrop.croppie('bind',{
            type: 'base64',
            url: e.target.result,
        }).then(function(){
                console.log('jQuery bind complete');
        });
        };
        reader.readAsDataURL(input.files[0]);
    }
    else {
        hs_izi_error_message("Sorry - you're browser doesn't support the FileReader API");
    }
}

$('.upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (resp) {
        popupResult({
            src: resp
        });
    });
});

const hs_add_image_to_product = (image_id,image_url)=>{
    let image_container = document.createElement('span');
    let image_remover= document.createElement('span');
    let new_image = document.createElement('img');
    let new_image_input = document.createElement('input');
    image_container.setAttribute('class', 'product-image');
    image_remover.innerHTML='&#x2715';
    image_remover.setAttribute('class', 'image-remover');
    image_remover.setAttribute('onclick', 'image_remover(this)');
    new_image_input.setAttribute('type', 'hidden');
    new_image_input.setAttribute('name', 'product-images[]');
    new_image_input.setAttribute('value', image_id);
    new_image.setAttribute('src', image_url);
    image_container.appendChild(image_remover);
    image_container.appendChild(new_image);
    image_container.appendChild(new_image_input);
    document.querySelector('#product-images').appendChild(image_container);
};