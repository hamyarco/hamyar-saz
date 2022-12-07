/*jshint esversion: 6 */
const hs_make_id= length => {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
};
const $=jQuery;
const hs_izi_success_message= function (message, title = '', once = false) {
    let parameter = {
        id: 'success',
        title: title,
        message: message,
        displayMode: 'once',
        position: 'topCenter',
        transitionIn: 'bounceInLeft',
        rtl: true
    };
    if (once) { parameter.displayMode = 'once'; }

    iziToast.success(parameter);
};

const hs_izi_success= () => {
    iziToast.success({
        title: 'is done',
        rtl: true,
        close:false,
        icon:'',
        displayMode: 'once',
        timeout: 3400
    });
};

const hs_izi_question=function (message, title = '',yes_answer='Yes',no_answer='No', yes_callback = false,no_callback = false) {
    iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        id: 'question',
        zindex: 999,
        title: title,
        message: message,
        position: 'center',
        buttons: [
            ['<button>'+yes_answer+'</button>', function (instance, toast) {
                if (yes_callback !== false) {
                    yes_callback(instance, toast);
                }
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

            }, true],
            ['<button>'+no_answer+'</button>', function (instance, toast) {
                if (no_callback !== false) {
                    no_callback(instance, toast);
                }
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

            },false],
        ]
    });
};

const hs_izi_error_message=function (message, title = '', timeout = 5000, once = false) {
    console.log(message);
    let parameter = {
        id: 'error',
        timeout: 0,
        title: title,
        close:false,
        icon:'',
        message: message,
        position: 'topCenter',
        transitionIn: 'bounceInLeft',
        rtl: true,
    };
    if (once) { parameter.displayMode = 'once'; }
    iziToast.error(parameter);
};

const hs_xhr_send_request= function (endpoint, form_data, successCb, errorCb = false, badErrorCb = false, progressCb = false, method = 'POST', async = true) {
    var xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    let url = hs_update_query_string_parameter(endpoint, 't', new Date().getTime());
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                successCb(this.response);
            } else {
                if (errorCb !== false) {
                    errorCb(this);
                } else {
                    hs_izi_error_message(hs_http_status_code(this.status));
                }
            }
        } else {
            if (progressCb !== false) {
                progressCb();
            }
        }
    };
    xhr.onerror = function (e) {
        if (badErrorCb) {
            badErrorCb(e);
        }else{
            console.log(e);
        }
    };
    xhr.open(method, url, async);
    // if (form_data.get('csrf-token')) {
    //     xhr.setRequestHeader('X-CSRF-TOKEN', form_data.get('csrf-token'));
    // }
    xhr.send(form_data);
};

const hs_wc_xhr_send_request=function(endpoint, form_data, successCb, errorCb,method = 'POST') {
    var xhr = new XMLHttpRequest();
    xhr.responseType = 'json';
    xhr.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200 || this.status == 201|| this.status == 202|| this.status == 203|| this.status == 204|| this.status == 205|| this.status == 206) {
                successCb(this.response);
            } else {
                errorCb(this);
            }
        }
    };
    xhr.onerror = function (e) {
        errorCb(this);
        console.log(e);
    };
    xhr.open(method, endpoint, true);
    xhr.setRequestHeader('X-WC-Store-API-Nonce', ionVariable['X-WC-Store-API-Nonce']);
    xhr.send(form_data);
};

const hs_http_status_code=function(code) {
    let statusMessages = {
        '200': 'OK',
        '201': 'Created',
        '202': 'Accepted',
        '203': 'Non-Authoritative Information',
        '204': 'No Content',
        '205': 'Reset Content',
        '206': 'Partial Content',
        '207': 'Multi-Status (WebDAV)',
        '208': 'Already Reported (WebDAV)',
        '226': 'IM Used',
        '300': 'Multiple Choices',
        '301': 'Moved Permanently',
        '302': 'Found',
        '303': 'See Other',
        '304': 'Not Modified',
        '305': 'Use Proxy',
        '306': '(Unused)',
        '307': 'Temporary Redirect',
        '308': 'Permanent Redirect (experimental)',
        '400': 'Bad Request',
        '401': 'Unauthorized',
        '402': 'Payment Required',
        '403': 'Forbidden',
        '404': 'Not Found',
        '405': 'Method Not Allowed',
        '406': 'Not Acceptable',
        '407': 'Proxy Authentication Required',
        '408': 'Request Timeout',
        '409': 'Conflict',
        '410': 'Gone',
        '411': 'Length Required',
        '412': 'Precondition Failed',
        '413': 'Request Entity Too Large',
        '414': 'Request-URI Too Long',
        '415': 'Unsupported Media Type',
        '416': 'Requested Range Not Satisfiable',
        '417': 'Expectation Failed',
        '418': 'I\'m a teapot (RFC 2324)',
        '420': 'Enhance Your Calm (Twitter)',
        '422': 'Unprocessable Entity (WebDAV)',
        '423': 'Locked (WebDAV)',
        '424': 'Failed Dependency (WebDAV)',
        '425': 'Reserved for WebDAV',
        '426': 'Upgrade Required',
        '428': 'Precondition Required',
        '429': 'Too Many Requests',
        '431': 'Request Header Fields Too Large',
        '444': 'No Response (Nginx)',
        '449': 'Retry With (Microsoft)',
        '450': 'Blocked by Windows Parental Controls (Microsoft)',
        '451': 'Unavailable For Legal Reasons',
        '499': 'Client Closed Request (Nginx)',
        '500': 'Internal Server Error',
        '501': 'Not Implemented',
        '502': 'Bad Gateway',
        '503': 'Service Unavailable',
        '504': 'Gateway Timeout',
        '505': 'HTTP Version Not Supported',
        '506': 'Variant Also Negotiates (Experimental)',
        '507': 'Insufficient Storage (WebDAV)',
        '508': 'Loop Detected (WebDAV)',
        '509': 'Bandwidth Limit Exceeded (Apache)',
        '510': 'Not Extended',
        '511': 'Network Authentication Required',
        '598': 'Network read timeout error',
        '599': 'Network connect timeout error'
    };
    return 'server error: ' + statusMessages[code];
};

const hs_is_data_json=(str) => {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
};

const hs_update_query_string_parameter=function(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
};

function nice_bytes(x) {
    const units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    let l = 0, n = parseInt(x, 10) || 0;
    while (n >= 1024 && ++l) {
        n = n / 1024;
    }
    return (n.toFixed(n < 10 && l > 0 ? 1 : 0) + ' ' + units[l]);
}

const hs_show_loader= (el ,message='')=> {
    ongoing_process=true;
    el.classList.add('hs-show-loader');
    el.setAttribute('ajax-message',message);
};


const hs_hide_loader= el => {
    ongoing_process=false;
    el.classList.remove('hs-show-loader');
};

const hs_array_remove=(arr, value) => {
    return arr.filter(function (ele) {
        return ele != value;
    });
};

const hs_get_select_values=select=> {
    let result = [];
    let options = select && select.options;
    let opt;
    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];
        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }
    return result;
};

const hs_get_form_input=form=> {
    let inputs = form.querySelectorAll('input,textarea,select');
    let formData = new FormData();
    let file_action = {};
    for (let i = 0; i < inputs.length; ++i) {
        if (!inputs[i].hasAttribute('name') || inputs[i].getAttribute('name') == null) continue;

        if (inputs[i].type === 'checkbox') {
            if (inputs[i].checked == false) {
                continue;
            }
        }
        if (inputs[i].type === 'radio') {
            if (inputs[i].checked == false) {
                continue;
            }
        }
        let thisValue = inputs[i].value;
        if (inputs[i].type === 'file' && inputs[i].files && inputs[i].files[0]) {
            thisValue = inputs[i].files[0];
        }
        if (inputs[i].type === 'select-multiple') {
            // thisValue = JSON.stringify(getSelectValues(inputs[i]))
            thisValue = getSelectValues(inputs[i]);
        }

        formData.append(inputs[i].getAttribute('name'), thisValue);
    }
    var json_file_action = JSON.stringify(file_action);
    return formData;
};

const hs_to_farsi_number=value=> {
    var id= ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return value.replace(/[0-9]/g, function(w){
        return id[+w];
    });
};

const hs_to_english_number= str =>{

    // convert persian digits [۰۱۲۳۴۵۶۷۸۹]
    var e = '۰'.charCodeAt(0);
    str = str.replace(/[۰-۹]/g, function(t) {
        return t.charCodeAt(0) - e;
    });

    // convert arabic indic digits [٠١٢٣٤٥٦٧٨٩]
    e = '٠'.charCodeAt(0);
    str = str.replace(/[٠-٩]/g, function(t) {
        return t.charCodeAt(0) - e;
    });
    return str;
};

const hs_analyze_free_link=link =>{
    link=trim(link);
    if (!link.startsWith('http://') && !link.startsWith('https://')){
        link='https://'+link;
    }
    link = link.split('?')[0];

    for(let regex in HbVariable.free_regex){
        const rgx = new RegExp(HbVariable.free_regex[regex], 'i');
        let match=link.match(rgx);
        if (match){
            return true;
        }
    }
    return false;
};

const trim = function(str) {
    if (!str) {
        return str;
    }
    return String.prototype.trim ? String.prototype.trim.call(str) : str.toString().replace(/^\s*/, '').replace(/\s*$/, '');
};

const toogle_elements=()=>{
    document.querySelectorAll('.toogle-me').forEach(function (label) {
        if (label.style.display=='' || label.style.display === 'none') {
            label.style.display = 'block';
        }else{
            label.style.display = 'none';
        }
    });
};

function copyToClipboard( textToCopy ) {
    var textArea;

    function isOS() {
        //can use a better detection logic here
        return navigator.userAgent.match(/ipad|iphone/i);
    }

    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.readOnly = true;
        textArea.contentEditable = true;
        textArea.value = text;
        document.body.appendChild(textArea);
    }

    function selectText() {
        var range, selection;
        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }
    function copyTo() {
        document.execCommand('copy');
        document.body.removeChild(textArea);
        console.log(textArea.value);
        hs_izi_success_message('کپی شد');
    }
    createTextArea(textToCopy);
    selectText();
    copyTo();
}