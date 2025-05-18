function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}

function validatePhoneNumber(phone) {
    const re = /^[6-9]\d{9}$/;
    return re.test(phone);
}

function validateForm() {
    const name = $('#billing_name').val();
    const email = $('#billing_email').val();
    const phone = $('#billing_mobile').val();
    const amount = $('#payAmount').val();

    if (name && validateEmail(email) && validatePhoneNumber(phone) && amount) {
        $('#PayNow').prop('disabled', false);
    } else {
        $('#PayNow').prop('disabled', true);
    }
}

jQuery(document).ready(function ($) {
    $('input').on('input', validateForm);

    $('#PayNow').click(function(e) {
        e.preventDefault();
        if ($(this).prop('disabled')) return;

        let formData = {
            student_id: $('#student_id').val(),
            course_id: $('#course_id').val(),
            billing_name: $('#billing_name').val(),
            billing_mobile: $('#billing_mobile').val(),
            billing_email: $('#billing_email').val(),
            payAmount: $('#payAmount').val(),
            action: 'payOrder'
        };

        $.ajax({
            type: 'POST',
            url: "submitpayment.php",
            data: formData,
            dataType: 'json',
        }).done(function(data) {
            if (data.res === 'success') {
                var options = {
                    "key": data.razorpay_key,
                    "amount": data.amount * 100,
                    "currency": "INR",
                    "name": "EduTrack",
                    "description": "Course Payment",
                    "order_id": data.rpay_order_id,
                    "handler": function(response) {
                        // SUCCESS: Insert to DB now
                        $.post('verifyPayment.php', {
                            student_id: data.student_id,
                            course_id: data.course_id,
                            rpay_order_id: data.rpay_order_id,
                            payAmount: data.amount
                        }, function(res) {
                            if (res === 'success') {
                                window.location.href = "success.php?order_id=" + data.rpay_order_id;
                            } else {
                                alert("Payment success but insertion failed.");
                            }
                        });
                    },
                    "theme": { "color": "#3399cc" }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }
        });
    });
});
