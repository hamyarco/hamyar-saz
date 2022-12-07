/*jshint esversion: 6 */
/*
 * DataTables - Tables
 */

$(document).ready(function () {
    "use strict";

    $('.dropdown-trigger').dropdown({
        constrainWidth: false
    });

    $(".todo-list li").click(function () {
        var $this = $(this);
        if (!$this.hasClass("sidebar-title")) {
            $("li").removeClass("active");
            $this.addClass("active");
        }
    });

    // Sidenav
    $(".sidenav-trigger").on("click", function () {
        if ($(window).width() < 960) {
            $(".sidenav").sidenav("close");
            $(".app-sidebar").sidenav("close");
        }
    });


    if ($(".app-todo .collection").length > 0) {
        var ps_todo_collection = new PerfectScrollbar(".app-todo .collection", {
            theme: "dark"
        });
    }

    // todo-overlay and sidebar hide
    // --------------------------------------------
    var todoOverlay = $(".todo-overlay"),
        todoComposeSidebar = $(".todo-compose-sidebar"),
        todoComplete = $(".todo-complete"),
        todoTitleLabel = $(".todo-title-label"),
        orderDate = $(".todo-compose-sidebar .order-date"),
        orderStatus = $(".todo-compose-sidebar .status"),
        orderPayment = todoComposeSidebar.find("[data-type='order-payment']"),
        orderFactor = todoComposeSidebar.find("[data-type='order-factor']"),
        orderItems = todoComposeSidebar.find("[data-type='order-items']"),
        userDetails = todoComposeSidebar.find("[data-type='user-details']"),
        labelEditForm = $("label[for='edit-item-form']");
    $(".todo-sidebar-trigger").on("click", function () {
        $this=$(this);
        todoOverlay.addClass("show");
        todoComposeSidebar.addClass("show");
        labelEditForm.removeClass("active");
        todoComplete.addClass("hide");
        todoTitleLabel.html('ویرایش سفارش');
    });
    $(
        " .todo-compose-sidebar .close-icon, .todo-compose-sidebar .add-todo, .todo-overlay"
    ).on("click", function () {
        todoOverlay.removeClass("show");
        todoComposeSidebar.removeClass("show");
    });
    $(
        ".todo-compose-sidebar .update-todo"
    ).on("click", function () {
        this.querySelector('span').innerHTML='در حال ذخیره...';
    });
    var globalThis;
    $(".todo-collection .todo-items").on("click", function () {
        var $this = $(this);
        todoComposeSidebar.find('.clear-me').each(function(){
            $(this).remove();
        });
        todoComposeSidebar.find('.loader').each(function(){
            $(this).removeClass('hide');
        });

        let order_id=$this.find('.list-left label').data('order-id');
        todoTitleLabel.text('ویرایش سفارش '+order_id);
        document.querySelector('[name="order-id"]').value=order_id;

        orderDate.text($this.find('.list-date').text());

        M.FormSelect.getInstance(orderStatus).destroy();
        orderStatus.val($this.find('[data-status]').attr('data-status')).trigger('change');
        orderStatus.formSelect();

        todoOverlay.addClass("show");
        todoComposeSidebar.addClass("show");
        let url = hamyar_saz_public._ajax_url;
        let form_data=new FormData();
        form_data.append('action','hamyar_saz');
        form_data.append('class','getOrder');
        form_data.append('order_id',order_id);
        form_data.append('_nonce',hamyar_saz_public._nonce);

        hs_xhr_send_request(url, form_data, function (response){
            console.log(response);

            todoComposeSidebar.find('.loader').each(function(){
                $(this).addClass('hide');
            });
            $("<div class=' clear-me'>"+response.payment_method_title+"</div>").appendTo(orderPayment.parent());
            orderItemHtml('نام:',response.billing.first_name).appendTo(userDetails.parent());
            orderItemHtml('شماره تماس:',response.billing.phone).appendTo(userDetails.parent());
            orderItemHtml('آدرس:',response.shipping.address_1).appendTo(userDetails.parent());

            orderItemHtml('جمع کل:',response.total).appendTo(orderFactor.parent());
            orderItemHtml('میزان تخفیف:',response.discount_total).appendTo(orderFactor.parent());
            orderItemHtml('مبلغ پرداختی:',response.total).appendTo(orderFactor.parent());
            response.item_details.forEach(function (item) {
                orderItemHtml(item.quantity+' * ' +   item.name,item.price).appendTo(orderItems.parent());
            });

        }, order_submit_form_error, order_submit_form_error);
    });
    todoComplete.on("click", function () {
        globalThis.parent().find('input[type=checkbox]').prop('checked', true);
        globalThis.parent().find('.list-content .list-title').css('textDecoration', 'line-through');
        globalThis.parent().find('.list-content .list-desc').css('textDecoration', 'line-through');
    });
    if (todoComposeSidebar.length > 0) {
        var ps_compose_sidebar = new PerfectScrollbar(".todo-compose-sidebar", {
            theme: "dark",
            wheelPropagation: false
        });
    }

});

function orderItemHtml(title,data){
    return $("<div class='display-flex justify-content-between clear-me'><div>"+title+"</div><div>"+data+"</div></div>");
}

// Check All Checkbox
function toggle(source) {
    checkboxes = document.getElementsByName("foo");
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;

        // Check and Uncheck to do list line through css
        var parentCls = $(checkboxes[i]).closest(".collection-item");
        if (checkboxes[i].checked) {
            $(parentCls)
                .find(".list-content .list-title")
                .css("textDecoration", "line-through");
            $(parentCls)
                .find(".list-content .list-desc")
                .css("textDecoration", "line-through");
        } else {
            $(parentCls)
                .find(".list-content .list-title")
                .css("textDecoration", "none");
            $(parentCls)
                .find(".list-content .list-desc")
                .css("textDecoration", "none");
        }
    }
}

$(window).on('resize', function () {
    resizetable();
    $(".todo-compose-sidebar").removeClass("show");
    $(".todo-overlay").removeClass("show");
    if ($(window).width() > 899) {
        $("#todo-sidenav").removeClass("sidenav");
    }

    if ($(window).width() < 900) {
        $("#todo-sidenav").addClass("sidenav");
    }
});

function resizetable() {
    // $(".app-todo .collection").css({
    //    maxHeight: $(window).height() - 380 + "px"
    // });
    if ($(".vertical-layout").length > 0) {
        $(".app-todo .collection").css({ maxHeight: $(window).height() - 148 + "px" });
    }
    else {
        $(".app-todo .collection").css({ maxHeight: $(window).height() - 148 + "px" });
    }
}
resizetable();

function order_submit_form_error(response){
    console.log(response);
}
