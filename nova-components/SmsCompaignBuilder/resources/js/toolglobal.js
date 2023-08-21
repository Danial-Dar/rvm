<script>

    var SCB_campaignType = function (value) {
        $('#campaignTypeDiv').find('button').removeClass("border-error");
    };

var SCB_receiveResponse = function (value) {
    $('#campaignResponseDiv').find('button').removeClass("border-error");
};

var SCB_loader = function () {
    $('#loader-modal').modal('show');
};
var SCB_contactListLoader = function () {
    $('#loader-modal-contact-list').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#add_contact_list_modal').modal('hide');
    $('#loader-modal-contact-list').modal('show');

};
var SCB_csvValidate = function () {
    var fileInput = document.getElementById('campaignContactListFile');
    var filePath = fileInput.value;

    var allowedExtensions = /(\.csv)$/i;
    // console.log(filePath,allowedExtensions);
    if (!allowedExtensions.exec(filePath)) {
        alert('Please choose a csv file');
        fileInput.value = '';
        return false;
    }

    let ajaxData = new FormData();
    ajaxData.append('file', $('#campaignContactListFile')[0].files[0]);
    $('#addContactListSubmitBtn').css('pointer-events', 'none');
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        url: document.getElementById('validateContactListCsvUrl').value,
        data: ajaxData,
        success: function (data) {
            // console.log(data['success'])
            if (data['success']) {
                $('#addContactListSubmitBtn').css('pointer-events', 'none');
                alert('Please add a phone,first_name,last_name column to your CSV.');
                fileInput.value = '';
            } else {
                $('#addContactListSubmitBtn').css('pointer-events', '');
            }
        },
        beforeSend: function () {
            $('.contact-list-validate-loader').show()
        },
        complete: function () {
            $('.contact-list-validate-loader').hide();
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
};

var SCB_updateDropsPerHourSliderRangeValue = function (value) {
    // $('#myRange').slider().slider('value', value);

    if (parseInt(value) > 10000000 || parseInt(value) < 2000) {

        alert('Range must be from 2000 to 10000000');
        $('#myRange').val('2000');
        $('#dropsPerHourSliderRange').val('2000')
        // $('#demo').text('0');
    } else {
        $('#myRange').val(value);
        // $('#demo').text(value);
    }

    // $('#myRange').slider('refresh');
};

var SCB_createContactList = function (e) {
    e.preventDefault();
    if ($('#campaignContactListName').val() === '') {
        alert('List Name is required');
        return;
    }
    if ($('#campaignContactListFile')[0].files.length === 0) {
        alert('File is required');
        return;
    }
    this.contactListLoader();

    let ajaxData = new FormData();
    ajaxData.append('name', $('#campaignContactListName').val());
    ajaxData.append('file', $('#campaignContactListFile')[0].files[0]);

    $('#recipient').empty();

    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        url: document.getElementById('contactListStoreUrl').value,
        data: ajaxData,
        success: function (data) {

            $('#campaignContactListName').val('');
            $('#campaignContactListFile').val('');
            setTimeout(function () {
                $('#loader-modal-contact-list').modal('hide');
            }, 1000);
            // $('#recipient').append('<option Selected disabled>Click to select Recording for RVM</option>');
            var response = data['contactList'];
            if (response !== null) {
                for (let i = 0; i < response.length; i++) {
                    $('#recipient').append('<option value="' + response[i].id + '">' + response[i].name + '</option>')
                }
            } else {
                alert('contact list not added');
            }
            $('#recipient').selectpicker('refresh');
            console.log('Submission was successful.');
            $('#add_contact_list_modal').modal('hide');

        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    });
};

var SCB_campaignTimeShow = function () {
    // let select = $('select').selectpicker({length:10});
    $('#later_date').show();
    $('#campaignTimeInput').attr('required', true);
};
var SCB_campaignTimeHide = function () {
    let select = $('select').selectpicker({
        length: 10
    });
    $('#later_date').hide();
    select.attr('required', false);
};
var SCB_closeAlert = function () {
    $('#alert-success').css('display', 'none');
    $('#alert-danger').css('display', 'none');
};
var SCB_submitForm = function () {
    $("#has_banned_words").val(has_banned_words);
    $("#campaignAddForm").submit();
};

</script>
