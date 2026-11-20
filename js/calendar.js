function selectDay(dateStr) {
    document.getElementById("modalHeader").value = dateStr;
    document.getElementById("selectedDate").value = dateStr;
    // Reset the form every time it opens
    document.querySelector("#eventModal form").reset();
    // Put the date back because reset() clears it
    document.getElementById("modalHeader").value = dateStr;
    document.getElementById("selectedDate").value = dateStr;
    
    const modal = new bootstrap.Modal(document.getElementById("eventModal"));
    modal.show();
    toggleTimeFields();
}
function toggleTimeFields() {
    const type = document.getElementById("taskType").value;
    const fields = document.getElementById("addTimeFields");
    const startTime = document.getElementById("start_time");
    const endTime = document.getElementById("end_time");
    
    if (type === "todo") {
        fields.style.display = "none";
    } else {
        fields.style.display = "block";
        startTime.required = true;
        endTime.required = true;
    }
}
