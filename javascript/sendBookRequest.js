document.querySelectorAll('.bookButton').forEach(button => {
    button.addEventListener('click', async function () {
      const propertyDiv = this.closest('.bookingButtons');
      const propertyId = propertyDiv.getAttribute('data-id');
  
      try {
        const response = await fetch('sendBookRequest.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ property_id: propertyId}) // use real user_id from session eventually
        });
  
        const result = await response.json();
  
        if (result.success) {
          if (result.action === 'saved') {
            this.classList.add('booked');
          } else if (result.action === 'unsaved') {
            this.classList.remove('booked');
          }
        } else {
          alert('Failed to update saved status: ' + (result.error || 'Unknown error'));
        }
      } catch (err) {
        console.error('Fetch failed', err);
      }
    });
  });
  