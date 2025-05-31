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
                
                // Use proper JSON encoding
                $('#gdb_disabled_dates_hidden').val(JSON.stringify(datesArray));
            },
            onReady: function(selectedDates, dateStr, instance) {
                // Calendar styling is handled by CSS - no need for manual styling
                $('.flatpickr-calendar').removeAttr('style');
            }
        });
    }
    
    // Form submission validation and double-submission prevention
    $('#post').on('submit', function(e) {
        var formIdInput = $('#gdb_form_id');
        
        // Validate form ID if field exists
        if (formIdInput.length > 0) {
            var formId = formIdInput.val();
            if (!formId || formId.trim() === '') {
                alert('Please enter a Target Fluent Form ID before saving.');
                e.preventDefault();
                return false;
            }
        }
        
        // Prevent double submission
        var $submitButtons = $('#publish, #save-post');
        if ($submitButtons.first().prop('disabled')) {
            e.preventDefault();
            return false;
        }
        
        // Disable buttons briefly to prevent double clicks
        $submitButtons.prop('disabled', true);
        
        // Re-enable buttons if form stays on page (fallback)
        setTimeout(function() {
            $submitButtons.prop('disabled', false);
        }, 5000);
    });
}); 