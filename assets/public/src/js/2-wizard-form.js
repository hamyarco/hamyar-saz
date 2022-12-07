/*jshint esversion: 6 */
const hsw=document.querySelector('#hsw');
const hs_front_form=document.querySelector('form');
const hs_body=document.querySelector('body');
const add_product_btn=document.querySelector('.product--add');
const main_body=document.querySelector('.main-body');

const toggle_fiels=(visible_selector,hidden_selector)=>{
    document.querySelector(visible_selector).style.display='block';

    document.querySelector(hidden_selector).style.display='none';
};

const hidden_add_product=()=>{
    hsw.style.display='none';
    main_body.style.display='block';
};

const close_video_popup=(el)=>{
    el.parentElement.parentElement.style.display='none';
    el.parentElement.querySelector('video').pause();
};

let hs_request_free=false;
let wait_timer=0;
let credit_details;

let ongoing_process=false;

const edit_this_product=(product_id)=>{
    show_add_product_form(product_id);
};

const show_add_product_form=(product_id=false)=>{
    hsw.style.display='block';
    main_body.style.display='none';
    if (product_id==false){
        let inputs=hs_front_form.querySelectorAll('input');
        document.querySelector('#product-images').innerHTML='';
        inputs.forEach(el=>{
            if (el.name){
                el.value='';
            }
       });
        hs_front_form.querySelector('textarea').value='';
        return;
    }
    hs_show_loader(hs_front_form);
    let form_data=new FormData();
    form_data.set('action','hamyar_product_edit');
    form_data.set('product_id',product_id);
    hs_edit_product(form_data);
};
if (hs_front_form){
    hs_front_form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (ongoing_process) {
            return;
        }
        // hs_show_loader(hs_front_form);
        // const form_data = hs_get_form_input(hs_front_form);
        // ongoing_process = true;
        let textarea=hs_front_form.querySelector('.ql-editor');
        if (textarea){
            textarea.parentElement.parentElement.parentElement.querySelector('[type="hidden"]').value=textarea.innerHTML;
        }
        if ($uploadCrop && $uploadCrop !== null && image_changed) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                document.querySelector('[name="image-uploader"]').value = resp;
                hs_front_form.submit();
            });
        } else {
            hs_front_form.submit();
        }
    });
}


const submit_function_selector= (form_data) => {
    if (form_data.get('action')==='hamyar_wizard_1'){
        hs_submit_front_form_wizard1(form_data);
    }else if(form_data.get('action')==='hamyar_product'){
        hs_submit_product(form_data);
    }else{
        hs_general_submit(form_data);
    }
};

const hs_submit_product = (form_data) => {
    try {
        let name = form_data.get('name');
        let description = form_data.get('description');
        let price = hs_to_english_number(form_data.get('price'));
        let sale_price =form_data.get('sales-price');
        if (sale_price){
            sales_price = hs_to_english_number(sale_price);
        }
        if (!name || !description || !price) {
            throw new Error('نام و توضحایت  و قیمت الزامی است');
        }
        if (isNaN(price) || (sale_price && isNaN(sales_price) )) {
            throw new Error('قیمت یا قیمت فروش ویژه صحیح نمی‌باشد.');
        }

        let url = hamyar_saz_public._ajax_url;
        console.log(form_data.get('image-uploader'));
        return hs_xhr_send_request(url, form_data, hs_submit_form_success, hs_submit_form_error, hs_submit_form_error);

    } catch (err) {
        hs_hide_loader(hs_front_form);
        hs_izi_error_message(err.message);
        console.log(err);
    }
};

const hs_general_submit = (form_data) => {
    try {
        let url = hamyar_saz_public._ajax_url;
        return hs_xhr_send_request(url, form_data, hs_submit_form_success, hs_submit_form_error, hs_submit_form_error);
    } catch (err) {
        hs_hide_loader(hs_front_form);
        hs_izi_error_message(err.message);
        console.log(err);
    }
};

const hs_edit_product = (form_data) => {
    try {
        let url = hamyar_saz_public._ajax_url;
        return hs_xhr_send_request(url, form_data, function(response){
            hs_hide_loader(hs_front_form);
            if (response && response.success && response.data){
                let data=response.data;
                document.querySelector('#product-images').innerHTML='';
                for(let key in data){
                    if (key==='images'){
                        for (let i in data[key]){
                            hs_add_image_to_product(i,data[key][i]);
                        }
                    }
                    let input=hs_front_form.querySelector('[name="'+key+'"]');
                    if (input){
                        input.value=data[key];
                    }
                }
            }
        }, hs_submit_form_error, hs_submit_form_error);

    } catch (err) {
        hs_hide_loader(hs_front_form);
        hs_izi_error_message(err.message);
        console.log(err);
    }
};

const hs_submit_front_form_wizard1 = (form_data) => {
    try {
        let display_name = form_data.get('display-name');
        let username = form_data.get('username');
        if (!display_name || !username) {
            throw new Error('نام کاربری و نام نمایشی الزامی است');
        }

        let url = hamyar_saz_public._ajax_url;
        return hs_xhr_send_request(url, form_data, hs_submit_form_success, hs_submit_form_error, hs_submit_form_error);

    } catch (err) {
        hs_hide_loader(hs_front_form);
        hs_izi_error_message(err.message);
        console.log(err);
    }
};



const hs_submit_form_success=response=>{
    hs_hide_loader(hs_front_form);
    if (response && response.success && response.data){
        if (response.data.message){
            hs_izi_success_message(response.data.message);
        }
        if (response.data.html){
            hs_front_form.innerHTML=response.data.html;
        }
        if (response.data.javascript){
            eval(response.data.javascript);
        }
    }else{
        hs_izi_error_message(response.data.message);
    }
    console.log(response);
};

const hs_submit_form_error=response=>{
    hs_hide_loader(hs_front_form);
    if (response.status!==200){
        let status=hs_http_status_code(response.status);
        hs_izi_error_message(status);
    }else{
        hs_izi_error_message(response.statusText);
    }
    console.log(response);
};


const hs_next_step=(step,disabled=0)=>{
    if (disabled==1){
        return;
    }
    window.location.href=hamyar_saz_public._hamyar_saz_url+'?step='+step;
};

const hs_show_video=(video)=>{
    let video_section = document.getElementById(video);
    video_section.style.display = 'flex';
    video_section.querySelector('video').play();
};


