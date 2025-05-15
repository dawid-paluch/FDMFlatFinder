savedProperties = ['property2'];
savedProperties.push('propertyId');
sessionStorage.setItem('savedProperties', JSON.stringify(savedProperties));

document.querySelectorAll('.saveButton').forEach(button => {
    button.addEventListener('click', async function () {
      const propertyDiv = this.closest('.bottomField');
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
          this.textContent = 'Save';
          this.classList.remove('saved');
        }
        else {
          previousSaved.push(propertyId);
          sessionStorage.setItem('savedProperties', JSON.stringify(previousSaved));
          this.textContent = 'Saved!';
          this.classList.add('saved');
        }
      } catch (err) {
        console.error('Fetch failed', err);
      }
    });
  });
  