jQuery(document).ready(function($) {
    'use strict';
    
    // Initialize Flatpickr for admin date selection
    if ($('#gdb_date_picker').length) {
        
        // Get existing disabled dates from localized data
        var existingDates = gdbAdminData.disabledDates || [];
        
        // Initialize Flatpickr with multiple date selection
        var datePicker = flatpickr('#gdb_date_picker', {
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
                $('#gdb_disabled_dates').val(jsonString);
                
                // Update the visible input field
                $('#gdb_date_picker').val(dateStr);
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
    
    // Form submission validation and debugging
    $('form').on('submit', function(e) {
        var selectedDates = $('#gdb_disabled_dates').val();
        
        if (!selectedDates || selectedDates === '[]') {
            if (!confirm('No dates are currently selected. Do you want to clear all disabled dates?')) {
                e.preventDefault();
                return false;
            }
        }
        
        // Show loading state
        var $submitButton = $(this).find('input[type="submit"]');
        $submitButton.prop('disabled', true).val('Saving...');
    });
}); 