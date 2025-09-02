document.addEventListener('DOMContentLoaded', function () {
    // Get the current date and time
    const now = new Date();

    // Format the date as YYYY-MM-DD
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(now.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;

    // Format the time as HH:MM
    const hours = String(now.getHours()).padStart(2, '0'); // Format hours
    const minutes = String(now.getMinutes()).padStart(2, '0'); // Format minutes
    const formattedTime = `${hours}:${minutes}`;



    // document.getElementById('scheduledate').value = formattedDate;

    // document.getElementById('scheduledate').setAttribute('min', formattedDate);



    // document.getElementById('scheduletime').value = formattedTime;

    
    // Check and set date input
    const dateInput = document.getElementById('scheduledate');
    if (dateInput) {
        dateInput.value = formattedDate;
        dateInput.setAttribute('min', formattedDate);
    }

    // Check and set time input
    const timeInput = document.getElementById('scheduletime');
    if (timeInput) {
        timeInput.value = formattedTime;
    }

});
function toggleFields() {
    const draftChecked = document.getElementById('draft').checked;
    const dateTimeFields = document.getElementById('dateTimeFields');
    dateTimeFields.classList.toggle('hidden', !draftChecked);
}