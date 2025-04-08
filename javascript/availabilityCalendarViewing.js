//Loading calender with current month and year as well as the appropriate days for the month.
document.addEventListener('DOMContentLoaded', function () {

    const avaialabilityDataElement = document.getElementById('availabilityData');
    localStorage.setItem('availability', JSON.stringify(avaialabilityDataElement.value));

    // Sets common variables for the calendar
    const monthYear = document.getElementById('month-year');
    const daysContainer = document.getElementById('days');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    const months = ['January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'];

    let currentDate = new Date();
    let today = new Date();

    // Function to render the calendar
    // This function takes a date as an argument and renders the calendar for that month with appropriate days.
    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();
        monthYear.textContent = `${months[month]} ${year}`;
        daysContainer.innerHTML = '';

        // Previous month's days - faded out
        const prevMonthLastDay = new Date(year, month, 0).getDate();
        for (let i = firstDay; i > 0; i--) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = prevMonthLastDay - i + 1;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);
        }
        // Current month's days - active if after today, faded out if before today
        for (let i = 1; i <= lastDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;
            if (i < 10) {
                dayDiv.id = `${year}-${month + 1}-0${i}`;
            }
            else {
                dayDiv.id = `${year}-${month + 1}-${i}`;
            }
            if (i <= today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayDiv.classList.add('fade');
            }
            else{
                dayDiv.classList.add('active');
                // If the date has already been selected, check the checkbox and add the selected class
                if (checkIfDateSelected(dayDiv.id)) {
                    dayDiv.classList.add('selected');
                }
            }
            daysContainer.appendChild(dayDiv);
        }
        // Next month's days - faded out
        const nextMonthStartDay = 7 - new Date(year, month + 1, 0).getDay() - 1;
        for (let i = 1; i <= nextMonthStartDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);
        }
    }

    // Event listeners for the previous and next buttons
    // These buttons allow the user to navigate through the months
    // The buttons are disabled if the user is viewing the current month or more than three months in the future
    prevButton.addEventListener('click', function () {
        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear() || prevButton.classList.contains('disabled')) {
            return;
        }
        currentDate.setMonth(currentDate.getMonth() - 1);

        nextButton.classList.remove('disabled');

        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
            prevButton.classList.add('disabled');
        }

        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', function () {
        if (nextButton.classList.contains('disabled')) {
            return;
        }
        currentDate.setMonth(currentDate.getMonth() + 1);
        if ((currentDate.getMonth() === (today.getMonth() + 3) && currentDate.getFullYear() === today.getFullYear()) ||
        currentDate.getFullYear() > today.getFullYear() && (currentDate.getMonth() + 12) === (today.getMonth() + 3)) {
            nextButton.classList.add('disabled');
        }

        prevButton.classList.remove('disabled');

        renderCalendar(currentDate);
    });
    
    renderCalendar(currentDate);
});

// Function to check if a date has been selected
function checkIfDateSelected(date) {
    if (JSON.parse(localStorage.getItem('availability')).includes(date)) {
        return true;
    }
    return false;
}