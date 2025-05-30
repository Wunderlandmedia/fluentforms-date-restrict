jQuery(document).ready(function($) {
    'use strict';
    
    // Initialize Flatpickr for admin date selection in meta box
    if ($('#gdb-flatpickr-container').length) {
        
        // Get existing disabled dates from localized data
        var existingDates = (typeof gdbAdminData !== 'undefined' && gdbAdminData.disabledDates) ? gdbAdminData.disabledDates : [];
        
        // Initialize Flatpickr with multiple date selection
        var datePicker = flatpickr('#gdb-flatpickr-container', {
            mode: 'multiple',
            dateFormat: 'Y-m-d',
            defaultDate: existingDates,
            inline: true,
            showMonths: 1,
            locale: {
                firstDayOfWeek: 1 // Start week on Monday
            },
            onChange: function(selectedDates, dateStr, instance) {
                // Update the hidden input with selected dates
                var datesArray = selectedDates.map(function(date) {
                    return flatpickr.formatDate(date, 'Y-m-d');
                });
                
                // Use proper JSON encoding without double escaping
                var jsonString = JSON.stringify(datesArray);
                $('#gdb_disabled_dates_hidden').val(jsonString);
            },
            onReady: function(selectedDates, dateStr, instance) {
                // Calendar styling is now handled by CSS
                // Remove any conflicting inline styles
                $('.flatpickr-calendar').removeAttr('style');
                
                // Ensure calendar is properly contained
                setTimeout(function() {
                    $('.flatpickr-calendar').each(function() {
                        $(this).css({
                            'position': 'relative',
                            'display': 'block',
                            'top': 'auto',
                            'left': 'auto',
                            'right': 'auto',
                            'bottom': 'auto'
                        });
                    });
                }, 100);
            }
        });
    }
    
    // Form submission validation for post edit screen
    $('#post').on('submit', function(e) {
        var formIdInput = $('#gdb_form_id');
        if (formIdInput.length > 0) { // Check if the field exists
            var formId = formIdInput.val();
            if (!formId || formId.trim() === '') {
                alert('Please enter a Target Fluent Form ID before saving.');
                e.preventDefault(); // Prevent submission
                return false;
            }
        }

        // To prevent double submission and ensure the clicked button's value is submitted:
        // Disable buttons slightly after the submit event has started processing.
        // This allows the browser to capture which button was clicked.
        var $buttons = $('#publish, #save-post');
        
        // Check if already submitting (e.g. if user clicks multiple times fast)
        // or if validation prevented submission previously and buttons are still disabled
        if ($buttons.first().prop('disabled')) { // Check if already disabled
            e.preventDefault(); // Prevent re-submission if buttons are already disabled
            return false;
        }
        
        // Disable buttons after a very short delay.
        // This ensures the clicked button's name/value is included in the form submission.
        setTimeout(function() {
            $buttons.prop('disabled', true);
        }, 50); // A small delay (e.g., 50ms)

        // Optional: Re-enable after a timeout in case submission hangs or fails client-side
        // This is a fallback; ideally, server response handles page navigation or errors.
        // If the form submits successfully, the page will navigate away, and this won't matter.
        // If it fails and stays on the page, buttons will be re-enabled.
        setTimeout(function() {
            if ($buttons.first().prop('disabled')) { // Only re-enable if they were indeed disabled by this script
                 $buttons.prop('disabled', false);
            }
        }, 8000); // Increased timeout (e.g., 8 seconds)
    });
}); 