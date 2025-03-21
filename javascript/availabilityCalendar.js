//Loading calender with current month and year as well as the appropriate days for the month.
document.addEventListener('DOMContentLoaded', function () {
    // This checks if availability exists in localStorage and if not, sets it to an empty string.
    if (localStorage.getItem('availability') == null) {
        localStorage.setItem('availability', "");
    }

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
            dayDiv.id = "dayDiv" + i;
            if (i <= today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayDiv.textContent = i;
                dayDiv.classList.add('fade');
            }
            else{
                // Create a checkbox for each day linked to the label that displays the day number
                const checkboxDay = document.createElement('input');
                checkboxDay.onclick = function () { changeUponSelect(dayDiv, checkboxDay) };
                checkboxDay.type = 'checkbox';
                checkboxDay.name = i;
                // Necessary to prevent dates from being read incorrectly
                if (i < 10) {
                    checkboxDay.value = `${year}-${month + 1}-0${i}`;
                }
                else {
                    checkboxDay.value = `${year}-${month + 1}-${i}`;
                }
                checkboxDay.id = i;
                checkboxDay.classList.add('checkbox');
                dayDiv.appendChild(checkboxDay);
                const dayLabel = document.createElement('label');
                dayLabel.textContent = i;
                dayLabel.htmlFor = i;
                dayDiv.appendChild(dayLabel);
                dayDiv.classList.add('active');
                // If the date has already been selected, check the checkbox and add the selected class
                if (checkIfDateSelected(checkboxDay.value)) {
                    checkboxDay.checked = true;
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

// Function to change the appearance of the day div and update the availability array in localStorage
// This function takes a div and a checkbox as arguments and adds the selected class to the div if the checkbox is checked
// If the checkbox is unchecked, the selected class is removed
function changeUponSelect(div, checkbox) {
    if (checkbox.checked == true) {
        div.classList.add('selected');
        var selected = JSON.parse(localStorage.getItem('availability'));
        selected.push(checkbox.value);
        localStorage.setItem('availability', JSON.stringify(selected));
    }
    else{
        div.classList.remove('selected');
        var selected = JSON.parse(localStorage.getItem('availability'));
        var index = selected.indexOf(checkbox.value);
        selected.splice(index, 1);
        localStorage.setItem('availability', JSON.stringify(selected));
    }
};

// Function to check if a date has been selected
function checkIfDateSelected(date) {
    if (JSON.parse(localStorage.getItem('availability')).includes(date)) {
        return true;
    }
    return false;
}