jQuery(document).ready(function($) {
    'use strict';
    
    // Check if required data is available
    if (typeof gdbFrontendData === 'undefined') {
        console.error('GDB: gdbFrontendData is not available! Script may not be properly localized.');
        return;
    }
    
    // Check if Flatpickr is available
    if (typeof flatpickr === 'undefined') {
        console.error('GDB: Flatpickr is not available! Make sure Fluent Forms is properly loaded.');
        return;
    }
    
    // Global variables
    var checkinPicker = null;
    var checkoutPicker = null;
    var disabledDates = gdbFrontendData.disabledDates || [];
    var formId = gdbFrontendData.formId;
    var checkinFieldName = gdbFrontendData.checkinField;
    var checkoutFieldName = gdbFrontendData.checkoutField;
    
    
    
    // Function to disable specific dates in Flatpickr
    function disableDates(date) {
        // Check if the date is in our disabled dates array
        var dateStr = date.getFullYear() + '-' + 
                     String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                     String(date.getDate()).padStart(2, '0');
        
        return disabledDates.includes(dateStr);
    }
    
    // Function to add one day to a date
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    
    // Function to subtract one day from a date
    function subtractDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() - days);
        return result;
    }
    
    // Function to convert date string to Date object
    function stringToDate(dateStr) {
        var parts = dateStr.split('-');
        return new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
    }
    
    // Function to find the first disabled date after a given date
    function findFirstDisabledDateAfter(afterDate) {
        var afterDateStr = afterDate.getFullYear() + '-' + 
                          String(afterDate.getMonth() + 1).padStart(2, '0') + '-' + 
                          String(afterDate.getDate()).padStart(2, '0');
        
        var firstDisabledDate = null;
        
        for (var i = 0; i < disabledDates.length; i++) {
            var disabledDate = stringToDate(disabledDates[i]);
            
            // Only consider dates after the check-in date
            if (disabledDate > afterDate) {
                if (firstDisabledDate === null || disabledDate < firstDisabledDate) {
                    firstDisabledDate = disabledDate;
                }
            }
        }
        
        return firstDisabledDate;
    }
    
    // Function to create and add clear button
    function addClearButton($field, picker, fieldType) {
        // Remove existing clear button if any
        $field.siblings('.gdb-clear-btn').remove();
        
        // Create clear button with inline SVG
        var $clearBtn = $('<button type="button" class="gdb-clear-btn" title="Clear ' + fieldType + ' date">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="12" height="12">' +
            '<path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>' +
            '</svg>' +
            '</button>');
        
        // Position the field container relatively if not already
        var $container = $field.parent();
        if ($container.css('position') === 'static') {
            $container.css('position', 'relative');
        }
        
        // Add click handler
        $clearBtn.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            clearDateField(picker, fieldType);
        });
        
        // Insert button after the field
        $field.after($clearBtn);
        
        return $clearBtn;
    }
    
    // Function to clear a date field and update related restrictions
    function clearDateField(picker, fieldType) {
        if (!picker) return;
        
        // Clear the selected date
        picker.clear();
        
        // Update restrictions based on which field was cleared
        if (fieldType === 'checkin') {
            // If checkin is cleared, reset checkout restrictions
            if (checkoutPicker) {
                checkoutPicker.set('minDate', 'today');
                checkoutPicker.set('maxDate', null);
            }
            // Hide the clear button
            $('.gdb-clear-btn[title*="checkin"]').removeClass('gdb-show');
        } else if (fieldType === 'checkout') {
            // If checkout is cleared, reset checkin restrictions
            if (checkinPicker) {
                checkinPicker.set('maxDate', null);
            }
            // Hide the clear button
            $('.gdb-clear-btn[title*="checkout"]').removeClass('gdb-show');
        }
    }
    
    // Function to show/hide clear buttons based on field values
    function updateClearButtonVisibility() {
        // Show/hide checkin clear button
        if (checkinPicker && checkinPicker.selectedDates.length > 0) {
            $('.gdb-clear-btn[title*="checkin"]').addClass('gdb-show');
        } else {
            $('.gdb-clear-btn[title*="checkin"]').removeClass('gdb-show');
        }
        
        // Show/hide checkout clear button
        if (checkoutPicker && checkoutPicker.selectedDates.length > 0) {
            $('.gdb-clear-btn[title*="checkout"]').addClass('gdb-show');
        } else {
            $('.gdb-clear-btn[title*="checkout"]').removeClass('gdb-show');
        }
    }
    
    // Function to initialize date pickers
    function initializeDatePickers() {
        // Find the target form - try multiple possible selectors
        var $form = $('.fluentform_wrapper_' + formId);
        
        // If not found, try the original selector as fallback
        if ($form.length === 0) {
            $form = $('.fluentform_' + formId);
        }
        
        if ($form.length === 0) {
            return;
        }
        
        // Find checkin and checkout fields by name attribute
        var $checkinField = $form.find('input[name="' + checkinFieldName + '"]');
        var $checkoutField = $form.find('input[name="' + checkoutFieldName + '"]');
        
        if ($checkinField.length === 0 || $checkoutField.length === 0) {
            return;
        }
                
        // Initialize check-in date picker
        if ($checkinField.length > 0) {
            // Destroy existing Flatpickr instance if it exists
            if ($checkinField[0]._flatpickr) {
                $checkinField[0]._flatpickr.destroy();
            }
            
            checkinPicker = flatpickr($checkinField[0], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: [disableDates],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0 && checkoutPicker) {
                        var checkinDate = selectedDates[0];
                        var minCheckoutDate = addDays(checkinDate, 1);
                        
                        // Update checkout picker's minDate
                        checkoutPicker.set('minDate', minCheckoutDate);
                        
                        // Find the first disabled date after check-in date
                        var firstDisabledAfter = findFirstDisabledDateAfter(checkinDate);
                        
                        // If there's a disabled date after check-in, set maxDate to the day before it
                        if (firstDisabledAfter) {
                            var maxCheckoutDate = subtractDays(firstDisabledAfter, 1);
                            checkoutPicker.set('maxDate', maxCheckoutDate);
                        } else {
                            // If no disabled dates after check-in, remove maxDate restriction
                            checkoutPicker.set('maxDate', null);
                        }
                        
                        // Clear checkout date if it's now invalid
                        var currentCheckoutDate = checkoutPicker.selectedDates[0];
                        if (currentCheckoutDate && currentCheckoutDate <= checkinDate) {
                            checkoutPicker.clear();
                        }
                        
                        // Also clear if checkout date is after the new maxDate
                        if (firstDisabledAfter && currentCheckoutDate && currentCheckoutDate >= firstDisabledAfter) {
                            checkoutPicker.clear();
                        }
                    }
                    
                    // Update clear button visibility
                    updateClearButtonVisibility();
                }
            });
            
            // Add clear button for checkin field
            addClearButton($checkinField, checkinPicker, 'checkin');
        }
        
        // Initialize check-out date picker
        if ($checkoutField.length > 0) {
            // Destroy existing Flatpickr instance if it exists
            if ($checkoutField[0]._flatpickr) {
                $checkoutField[0]._flatpickr.destroy();
            }
            
            checkoutPicker = flatpickr($checkoutField[0], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: [disableDates],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0 && checkinPicker) {
                        var checkoutDate = selectedDates[0];
                        var maxCheckinDate = subtractDays(checkoutDate, 1);
                        
                        // Update checkin picker's maxDate
                        checkinPicker.set('maxDate', maxCheckinDate);
                        
                        // Clear checkin date if it's now invalid
                        var currentCheckinDate = checkinPicker.selectedDates[0];
                        if (currentCheckinDate && currentCheckinDate >= checkoutDate) {
                            checkinPicker.clear();
                        }
                    }
                    
                    // Update clear button visibility
                    updateClearButtonVisibility();
                }
            });
            
            // Add clear button for checkout field
            addClearButton($checkoutField, checkoutPicker, 'checkout');
        }
        
        // Initial update of clear button visibility
        setTimeout(updateClearButtonVisibility, 100);
    }
    
    // Function to handle Fluent Forms events
    function handleFluentFormsEvents() {
        // Listen for Fluent Forms rendered event
        $(document).on('fluentform_rendered', function(e, formId) {
            if (formId == gdbFrontendData.formId) {
                setTimeout(initializeDatePickers, 100);
            }
        });
        
        // Listen for Flatpickr options event (if available)
        $(document).on('ff_flatpickr_options', function(e) {
            var $field = $(e.target);
            var fieldName = $field.attr('name');
            
            if (fieldName === checkinFieldName || fieldName === checkoutFieldName) {
                // Apply disabled dates to the Flatpickr options
                if (e.detail && e.detail.options) {
                    var existingDisable = e.detail.options.disable || [];
                    e.detail.options.disable = existingDisable.concat([disableDates]);
                }
            }
        });
    }
    
    // Initialize when DOM is ready
    function init() {
        // Set up event handlers
        handleFluentFormsEvents();
        
        // Try to initialize immediately if form is already present
        setTimeout(function() {
            initializeDatePickers();
        }, 500);
        
        // Also try after a longer delay in case of slow loading
        setTimeout(function() {
            if (!checkinPicker || !checkoutPicker) {
                initializeDatePickers();
            }
        }, 2000);
    }
    
    // Start initialization
    init();
    
    // Expose functions for debugging - only in debug mode for security
    if (gdbFrontendData.debugMode) {
        window.gdbDebug = {
            reinitialize: initializeDatePickers,
            checkinPicker: function() { return checkinPicker; },
            checkoutPicker: function() { return checkoutPicker; },
            disabledDates: disabledDates,
            config: gdbFrontendData
        };
    }
}); 