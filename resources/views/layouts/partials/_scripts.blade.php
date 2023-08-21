<script src="{{ asset('vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery/jquery-ui.js') }}"></script>
<script src="{{ asset('vendor_assets/js/bootstrap/popper.js') }}"></script>
<script src="{{ asset('vendor_assets/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/accordion.js') }}"></script>
<script src="{{ asset('vendor_assets/js/autoComplete.js') }}"></script>
<script src="{{ asset('vendor_assets/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('vendor_assets/js/drawer.js') }}"></script>
<script src="{{ asset('vendor_assets/js/dynamicBadge.js') }}"></script>
<script src="{{ asset('vendor_assets/js/dynamicCheckbox.js') }}"></script>
<script src="{{ asset('vendor_assets/js/feather.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/footable.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/fullcalendar@5.2.0.js') }}"></script>
<script src="{{ asset('vendor_assets/js/google-chart.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.filterizr.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.mCustomScrollbar.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.peity.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/jquery.star-rating-svg.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/leaflet.js') }}"></script>
<script src="{{ asset('vendor_assets/js/leaflet.markercluster.js') }}"></script>
<script src="{{ asset('vendor_assets/js/loader.js') }}"></script>
<script src="{{ asset('vendor_assets/js/message.js') }}"></script>
<script src="{{ asset('vendor_assets/js/moment.js') }}"></script>
<script src="{{ asset('vendor_assets/js/muuri.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/notification.js') }}"></script>
<script src="{{ asset('vendor_assets/js/popover.js') }}"></script>
<script src="{{ asset('vendor_assets/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/slick.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/trumbowyg.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/trumbowyg.upload64.min.js') }}"></script>
<script src="{{ asset('vendor_assets/js/wickedpicker.min.js') }}"></script>
<script src="{{ asset('js/drag-drop.js') }}"></script>
<script src="{{ asset('js/full-calendar.js') }}"></script>
<script src="{{ asset('js/googlemap-init.js') }}"></script>
<script src="{{ asset('js/icon-loader.js') }}"></script>
<script src="{{ asset('js/jvectormap-init.js') }}"></script>
<script src="{{ asset('js/footable.js') }}"></script>
<script src="{{ asset('js/leaflet-init.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
{{-- waleed export to csv buttons --}}
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
{{-- waleed export to csv buttons end --}}

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script> --}}

<!-- js for datetime picker -->
<script src="{{ asset('js/datetimepicker.js') }}"></script>

<!-- script for js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $("#allow_long_message_container").hide();
        $('.shortcode').click(function(e) {
            let expected_length = ($('#message').val()+'{'+$(this).attr('val')+'}').length;
            if(expected_length < 160){
                $('#allow_long_message_container').hide()
                $('#message').val($('#message').val()+'{'+$(this).attr('val')+'}');
            }else{
                $('#allow_long_message_container').show()
                if(document.querySelector('#allow_long_message:checked') !== null){
                    $('#message').val($('#message').val()+'{'+$(this).attr('val')+'}');
                    $('#character_length').text($('#message').val().length)
                   return;
                }else{
                    $('#message').val($('#message').val().substring(0, 160));
                }
            }
            $('#character_length').text($('#message').val().length)
            $('#message').focus()
        });
        $('.randomizer').click(function() {
            $('#randomizer-modal').modal();
        });
        $('#btn-randomizer').click(function() {
            $('#randomizer-modal').modal('hide');
            let expected_length = ($('#message').val()+'@{{{word1|word2|word3}}}').length;
            if(expected_length < 160){
                $('#allow_long_message_container').hide()
                $('#message').val($('#message').val()+'@{{{word1|word2|word3}}}');
            }else{
                $('#allow_long_message_container').show()
                if(document.querySelector('#allow_long_message:checked') !== null){
                    $('#message').val($('#message').val()+'@{{{word1|word2|word3}}}');
                    $('#character_length').text($('#message').val().length)
                    return;
                }else{
                    $('#message').val($('#message').val().substring(0, 160));
                }
            }
            $('#character_length').text($('#message').val().length)
            $('#message').focus()
        });
        $('#myonoffswitch1').change(function() {
            if($(this).prop('checked') == false) {
                let messageText = $('#message').val();
                let random = Math.floor(Math.random() * 3);
                random++;
                let index = '$'+random;
                messageText = messageText.replaceAll(/@{{{(\w+)\|(\w+)\|(\w+)}}}/g, index);
                messageText = messageText.replaceAll(/{(\w+)}/g, '$1');
                $('#message-preview-container .message-window').text(messageText);
            }
            $('#message-preview-container').toggleClass('none')
            $('#message-edit-container').toggleClass('none')
        });
        $('#message-edit-btn').click(function() {
            $('#message-edit-btn').toggleClass('btn-secondary')
            $('#message-edit-btn').toggleClass('btn-light')
            $('#message-preview-btn').toggleClass('btn-secondary')
            $('#message-preview-btn').toggleClass('btn-light')
            $('#message-preview-container').toggleClass('none')
            $('#message-edit-container').toggleClass('none')
        });
        $('#message-preview-btn').click(function() {
            $('#message-edit-btn').toggleClass('btn-secondary')
            $('#message-edit-btn').toggleClass('btn-light')
            $('#message-preview-btn').toggleClass('btn-secondary')
            $('#message-preview-btn').toggleClass('btn-light')
            $('#message-preview-container').toggleClass('none')
            $('#message-edit-container').toggleClass('none')

            let messageText = $('#message').val();
            // messageText = messageText.replaceAll('{FNAME}', 'Jhon');
            // messageText = messageText.replaceAll('{LNAME}', 'Doe');
            // messageText = messageText.replaceAll('{DOMAIN}', 'site.com');
            let random = Math.floor(Math.random() * 3);
            random++;
            let index = '$'+random;
            messageText = messageText.replaceAll(/@{{{(\w+)\|(\w+)\|(\w+)}}}/g, index);

            messageText = messageText.replaceAll(/{(\w+)}/g, '$1');

            $('#message-preview-container .message-window').text(messageText);
        });
        $('#regenrate-sytax').click(function() {
            let messageText = $('#message').val();
            let random = Math.floor(Math.random() * 3);
            random++;
            let index = '$'+random;
            messageText = messageText.replaceAll(/@{{{(\w+)\|(\w+)\|(\w+)}}}/g, index);
            messageText = messageText.replaceAll(/{(\w+)}/g, '$1');

            $('#message-preview-container .message-window').text(messageText);
        })
    });
</script>
