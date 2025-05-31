jQuery(document).ready(function($) {
    'use strict';
    
    // Check if required data is available
    if (typeof gdbFrontendConfigs === 'undefined' || !Array.isArray(gdbFrontendConfigs)) {
        if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
            console.log('GDB: Frontend configs not available or invalid');
        }
        return;
    }
    
    // Check if Flatpickr is available
    if (typeof flatpickr === 'undefined') {
        console.error('GDB: Flatpickr is not available! Make sure Fluent Forms is properly loaded.');
        return;
    }
    
    if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
        console.log('GDB: Initializing with configs:', gdbFrontendConfigs);
    }
    
    // Store form instances to avoid conflicts
    var formInstances = {};
    var isInitialized = false;
    
    // Utility function for date formatting to YYYY-MM-DD
    function formatDateToYMD(date) {
        return flatpickr.formatDate(date, 'Y-m-d');
    }
    
    // Function to disable specific dates in Flatpickr
    function createDisableDatesFunction(disabledDates) {
        return function(date) {
            return disabledDates.includes(formatDateToYMD(date));
        };
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
    function findFirstDisabledDateAfter(afterDate, disabledDates) {
        var firstDisabledDate = null;
        
        for (var i = 0; i < disabledDates.length; i++) {
            var disabledDate = stringToDate(disabledDates[i]);
            
            if (disabledDate > afterDate) {
                if (firstDisabledDate === null || disabledDate < firstDisabledDate) {
                    firstDisabledDate = disabledDate;
                }
            }
        }
        
        return firstDisabledDate;
    }
    
    // Function to create and add clear button for specific field
    function addClearButton($field, picker, fieldType, formInstance) {
        var buttonId = 'gdb-clear-btn-' + formInstance.config.formId + '-' + fieldType;
        
        // Remove existing clear button if any
        $('#' + buttonId).remove();
        
        // Create clear button with external CSS styling instead of inline SVG
        var $clearBtn = $('<button type="button" id="' + buttonId + '" class="gdb-clear-btn" title="Clear ' + fieldType + ' date">' +
            '<span class="gdb-clear-icon">&times;</span>' +
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
            clearDateField(picker, fieldType, formInstance);
        });
        
        // Insert button after the field
        $field.after($clearBtn);
        
        return $clearBtn;
    }
    
    // Function to clear a date field and update related restrictions
    function clearDateField(picker, fieldType, formInstance) {
        if (!picker) return;
        
        // Clear the selected date
        picker.clear();
        
        // Update restrictions based on which field was cleared
        if (fieldType === 'checkin') {
            // If checkin is cleared, reset checkout restrictions
            if (formInstance.checkoutPicker) {
                formInstance.checkoutPicker.set('minDate', 'today');
                formInstance.checkoutPicker.set('maxDate', null);
            }
            // Hide the clear button
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkin').removeClass('gdb-show');
        } else if (fieldType === 'checkout') {
            // If checkout is cleared, reset checkin restrictions
            if (formInstance.checkinPicker) {
                formInstance.checkinPicker.set('maxDate', null);
            }
            // Hide the clear button
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkout').removeClass('gdb-show');
        }
    }
    
    // Function to show/hide clear buttons for specific form instance
    function updateClearButtonVisibility(formInstance) {
        // Show/hide checkin clear button
        if (formInstance.checkinPicker && formInstance.checkinPicker.selectedDates.length > 0) {
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkin').addClass('gdb-show');
        } else {
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkin').removeClass('gdb-show');
        }
        
        // Show/hide checkout clear button
        if (formInstance.checkoutPicker && formInstance.checkoutPicker.selectedDates.length > 0) {
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkout').addClass('gdb-show');
        } else {
            $('#gdb-clear-btn-' + formInstance.config.formId + '-checkout').removeClass('gdb-show');
        }
    }
    
    // Function to apply restrictions to a specific form based on configuration
    function applyRestrictionsToForm(config) {
        var formId = config.formId;
        var checkinFieldName = config.checkinField;
        var checkoutFieldName = config.checkoutField;
        var disabledDates = config.disabledDates;
        
        // Find the target form - try multiple possible selectors
        var $form = $('.fluentform_wrapper_' + formId);
        
        // If not found, try the original selector as fallback
        if ($form.length === 0) {
            $form = $('.fluentform_' + formId);
        }
        
        if ($form.length === 0) {
            if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
                console.warn('GDB: Form not found for ID:', formId);
            }
            return;
        }
        
        // Find checkin and checkout fields by name attribute
        var $checkinField = $form.find('input[name="' + checkinFieldName + '"]');
        var $checkoutField = $form.find('input[name="' + checkoutFieldName + '"]');
        
        if ($checkinField.length === 0 || $checkoutField.length === 0) {
            if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
                console.warn('GDB: Required fields not found:', checkinFieldName, checkoutFieldName);
            }
            return;
        }
        
        // Create or get form instance
        if (!formInstances[formId]) {
            formInstances[formId] = {
                config: config,
                checkinPicker: null,
                checkoutPicker: null
            };
        }
        
        var formInstance = formInstances[formId];
        var disableDatesFunction = createDisableDatesFunction(disabledDates);
        
        // Initialize check-in date picker
        if ($checkinField.length > 0) {
            // Destroy existing Flatpickr instance if it exists
            if ($checkinField[0]._flatpickr) {
                $checkinField[0]._flatpickr.destroy();
            }
            
            formInstance.checkinPicker = flatpickr($checkinField[0], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: [disableDatesFunction],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0 && formInstance.checkoutPicker) {
                        var checkinDate = selectedDates[0];
                        var minCheckoutDate = addDays(checkinDate, 1);
                        
                        // Update checkout picker's minDate
                        formInstance.checkoutPicker.set('minDate', minCheckoutDate);
                        
                        // Find the first disabled date after check-in date
                        var firstDisabledAfter = findFirstDisabledDateAfter(checkinDate, disabledDates);
                        
                        // If there's a disabled date after check-in, set maxDate to the day before it
                        if (firstDisabledAfter) {
                            var maxCheckoutDate = subtractDays(firstDisabledAfter, 1);
                            formInstance.checkoutPicker.set('maxDate', maxCheckoutDate);
                        } else {
                            // If no disabled dates after check-in, remove maxDate restriction
                            formInstance.checkoutPicker.set('maxDate', null);
                        }
                        
                        // Clear checkout date if it's now invalid
                        var currentCheckoutDate = formInstance.checkoutPicker.selectedDates[0];
                        if (currentCheckoutDate && currentCheckoutDate <= checkinDate) {
                            formInstance.checkoutPicker.clear();
                        }
                        
                        // Also clear if checkout date is after the new maxDate
                        if (firstDisabledAfter && currentCheckoutDate && currentCheckoutDate >= firstDisabledAfter) {
                            formInstance.checkoutPicker.clear();
                        }
                    }
                    
                    // Update clear button visibility
                    updateClearButtonVisibility(formInstance);
                }
            });
            
            // Add clear button for checkin field
            addClearButton($checkinField, formInstance.checkinPicker, 'checkin', formInstance);
        }
        
        // Initialize check-out date picker
        if ($checkoutField.length > 0) {
            // Destroy existing Flatpickr instance if it exists
            if ($checkoutField[0]._flatpickr) {
                $checkoutField[0]._flatpickr.destroy();
            }
            
            formInstance.checkoutPicker = flatpickr($checkoutField[0], {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: [disableDatesFunction],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0 && formInstance.checkinPicker) {
                        var checkoutDate = selectedDates[0];
                        var maxCheckinDate = subtractDays(checkoutDate, 1);
                        
                        // Update checkin picker's maxDate
                        formInstance.checkinPicker.set('maxDate', maxCheckinDate);
                        
                        // Clear checkin date if it's now invalid
                        var currentCheckinDate = formInstance.checkinPicker.selectedDates[0];
                        if (currentCheckinDate && currentCheckinDate >= checkoutDate) {
                            formInstance.checkinPicker.clear();
                        }
                    }
                    
                    // Update clear button visibility
                    updateClearButtonVisibility(formInstance);
                }
            });
            
            // Add clear button for checkout field
            addClearButton($checkoutField, formInstance.checkoutPicker, 'checkout', formInstance);
        }
        
        // Initial update of clear button visibility
        updateClearButtonVisibility(formInstance);
        
        if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
            console.log('GDB: Applied restrictions to form', formId);
        }
    }
    
    // Function to initialize all configurations
    function initializeAllConfigurations() {
        if (isInitialized) return;
        
        gdbFrontendConfigs.forEach(function(config) {
            applyRestrictionsToForm(config);
        });
        
        isInitialized = true;
    }
    
    // Function to handle Fluent Forms events
    function handleFluentFormsEvents() {
        // Listen for Fluent Forms rendered event
        $(document).on('fluentform_rendered', function(e, renderedFormId) {
            // Find matching configuration for this form ID
            var matchingConfig = gdbFrontendConfigs.find(function(config) {
                return config.formId == renderedFormId;
            });
            
            if (matchingConfig) {
                // Use requestAnimationFrame for better timing than setTimeout
                requestAnimationFrame(function() {
                    applyRestrictionsToForm(matchingConfig);
                });
            }
        });
        
        // Listen for Flatpickr options event (if available)
        $(document).on('ff_flatpickr_options', function(e) {
            var $field = $(e.target);
            var fieldName = $field.attr('name');
            
            // Find matching config for this field
            var matchingConfig = gdbFrontendConfigs.find(function(config) {
                return config.checkinField === fieldName || config.checkoutField === fieldName;
            });
            
            if (matchingConfig && e.detail && e.detail.options) {
                // Apply disabled dates to the Flatpickr options
                var existingDisable = e.detail.options.disable || [];
                var disableDatesFunction = createDisableDatesFunction(matchingConfig.disabledDates);
                e.detail.options.disable = existingDisable.concat([disableDatesFunction]);
            }
        });
    }
    
    // Initialize when DOM is ready
    function init() {
        // Set up event handlers first
        handleFluentFormsEvents();
        
        // Initialize forms that are already present
        // Use requestAnimationFrame for better performance and timing
        requestAnimationFrame(function() {
            initializeAllConfigurations();
        });
    }
    
    // Start initialization
    init();
    
    // Expose functions for debugging - only in debug mode
    if (typeof gdbFrontendData !== 'undefined' && gdbFrontendData.debugMode) {
        window.gdbDebug = {
            reinitialize: function() {
                isInitialized = false;
                initializeAllConfigurations();
            },
            formInstances: formInstances,
            configs: gdbFrontendConfigs,
            applyToForm: applyRestrictionsToForm
        };
    }
}); 