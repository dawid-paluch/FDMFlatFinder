
bookedProperties = ['property1'];
bookedProperties.push('propertyId');
sessionStorage.setItem('bookedProperties', JSON.stringify(bookedProperties));

document.querySelectorAll('.bookButton').forEach(button => {
    button.addEventListener('click', async function () {
      const propertyDiv = this.closest('.bookingButtons');
      const propertyId = propertyDiv.getAttribute('data-id');
  
      try {
        let previousSaved = sessionStorage.getItem('savedProperties');
        if (previousSaved) {
          previousSaved = JSON.parse(previousSaved);
        } else {
          previousSaved = [];
        }
        if (previousSaved.includes(propertyId)) {
          previousSaved = previousSaved.filter(id => id !== propertyId);
          sessionStorage.setItem('savedProperties', JSON.stringify(previousSaved));
          this.textContent = 'Book Now';
          this.classList.remove('booked');
        }
        else {
          previousSaved.push(propertyId);
          sessionStorage.setItem('savedProperties', JSON.stringify(previousSaved));
          this.textContent = 'Booked';
          this.classList.add('booked');
        }
      } catch (err) {
        console.error('Fetch failed', err);
      }
    });
  });
  