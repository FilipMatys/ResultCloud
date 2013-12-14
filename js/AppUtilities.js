/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Enumeration for application status
 * @type type
 */
var ENUM_Status =    {
    // Sucess
    SUCCESS: 'Success',
    // Error
    ERROR: 'Error',
    // Warning
    WARNING: 'Warning',
    // Information
    INFORMATION: 'Information'
    
};

/**
 * Show status message in status bar. Set color and status
 * message based on information.
 * - Information
 * - Warning
 * - Error
 * - Success
 * @param {ENUM_Status} status
 * @param {string} message
 * @returns {undefined}
 */
function ShowStatusMessage(status, message)    {
    // First clear any other status that is still on
    $('#statusWrapper').finish();
    
    // Set status content
    $('#statusWrapper span.header').text(status + ':');
    $('#statusWrapper span.message').text(message);
    
    // Set class and icon based on status
    $('#statusWrapper').attr('class', status.toLowerCase());    
    switch (status) {
        case ENUM_Status.SUCCESS:
            $('#statusWrapper span.icon').attr('class', 'icon glyphicon glyphicon-ok-circle');
            break;
        case ENUM_Status.ERROR:
            $('#statusWrapper span.icon').attr('class', 'icon glyphicon glyphicon-remove-circle');
            break;
        case ENUM_Status.WARNING:
            $('#statusWrapper span.icon').attr('class', 'icon glyphicon glyphicon-exclamation-sign');
            break;
        case ENUM_Status.INFORMATION:
            $('#statusWrapper span.icon').attr('class', 'icon glyphicon glyphicon-info-sign');
            break;
        default :
            break;
    }
    
    // Show status message for a few seconds
    $('#statusWrapper').fadeIn("slow").delay(3000).fadeOut("slow");
}
