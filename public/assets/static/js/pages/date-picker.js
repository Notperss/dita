flatpickr(".flatpickr-no-config", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});
flatpickr(".flatpickr-no-time", {
    enableTime: false,
    dateFormat: "Y-m-d",
});
flatpickr(".flatpickr-year", {
    dateFormat: "Y",
    minDate: "today", // You can customize this to set a minimum allowed date
    maxDate: new Date().fp_incr(10), // You can customize this to set a maximum al
});
flatpickr(".flatpickr-always-open", {
    inline: true,
});
flatpickr(".flatpickr-range", {
    dateFormat: "F j, Y",
    mode: "range",
});
flatpickr(".flatpickr-range-preloaded", {
    dateFormat: "F j, Y",
    mode: "range",
    defaultDate: ["2016-10-10T00:00:00Z", "2016-10-20T00:00:00Z"],
});
flatpickr(".flatpickr-time-picker-24h", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    inline: true,
});
