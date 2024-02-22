<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="includes/tinymce/js/tinymce/tinymce.min.js"></script>
  <link rel="stylesheet" href="includes/tinymce/js/tinymce/skins/content/default/content.min.css">
  <title>Newsletter Generator - Shabbat Zmanim</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 20px;
    }

    h1 {
      color: #333;
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    form {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: 0 auto;
    }

/* Add some basic styling to the input groups */
.input-group {
  margin-bottom: 20px;
}

.nested-input-group {
  margin-left: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
}

/* Style labels for better readability */
label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #333;
}

/* Add some spacing to the nested labels */
.nested-input-group label {
  margin-left: 10px;
  color: #555;
}

/* Adjust input styling for better alignment */
input {
  width: 100%;
  padding: 12px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s ease-in-out;
}

/* Add focus styles for a sleek appearance */
input:focus {
  outline: none;
  border-color: #6c63ff;
  box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
}

/* Style the submit button */
button {
  background-color: #6c63ff;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button:hover {
  background-color: #554fd8;
}

    textarea {
      padding: 10px;
      margin-bottom: 15px;
      box-sizing: border-box;
      border: 1px solid #aaa;
      border-radius: 6px;
      width: 100%;
      font-size: 1em;
      display: block;
    }


    hr {
      margin: 15px 0;
      border: none;
      border-top: 2px solid #ccc;
    }

    .form-group {
      display: flex;
      margin-bottom: 15px;
    }

    .form-group input,
    .form-group select {
      margin-bottom: 0;
    }

    .nested-input {
      display: flex;
      flex-direction: column;
      margin-top: 15px;
    }

    .tinymce {
      width: 100%;
      font-size: 1em;
    }

    .hidden {
      display: none;
    }
	
	  .checkbox-group input[type="checkbox"] {
    display: none;
    margin-bottom: 8px;
  }

  .checkbox-group label {
    position: relative;
    padding-left: 30px;
    cursor: pointer;
    font-size: 16px;
    color: #333;
    line-height: 20px;
    display: inline-block;
    margin-bottom: 8px;
  }

  .checkbox-group label:before {
       content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 20px;
      height: 20px;
      border: 2px solid #4caf50;
      background-color: #fff;
      border-radius: 50%;
      transition: background-color 0.3s;
  }

  .checkbox-group input[type="checkbox"]:checked+label:before {
    background-color: #4caf50;
    border: 2px solid #45a049;
  }

  .checkbox-group label:hover:before {
    background-color: #e0e0e0;
  }

  .checkbox-group input[type="checkbox"]:checked+label:hover:before {
    background-color: #45a049;
  }

  .checkbox-group input[type="checkbox"]:checked+label {
    color: #184183;
  }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'autoresize',
        autoresize_bottom_margin: 25,
        menubar: true,
        promotion: false,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
      }); 
			  
	        // Add an event listener to the date input
      const dateInput = document.getElementById('date');
      dateInput.addEventListener('input', function() {
        const selectedDate = new Date(this.value);
        
        // Check if the selected date is a Friday (day index 5)
        if (selectedDate.getDay() !== 4) {
          alert('Please select a Friday date for accurate Zmanim.');
          this.value = ''; // Clear the input value
        }
      });
	  
		// Function to get the default date based on whether today is Friday
	  function getDefaultDate() {
		const today = new Date();

		// Check if today is Friday (day index 5)
		if (today.getDay() === 5) {
		  // If today is Friday, set the default value to today
		  return today.toISOString().split('T')[0];
		} else {
		  // Calculate the next Friday's date
		  const daysUntilFriday = 5 - today.getDay() + (today.getDay() > 4 ? 7 : 0);
		  const nextFriday = new Date(today);
		  nextFriday.setDate(today.getDate() + daysUntilFriday);

		  // Format the date in 'YYYY-MM-DD' format
		  return nextFriday.toISOString().split('T')[0];
		}
	  }

  // Set the default value of the date input
  document.getElementById('date').value = getDefaultDate();

	  
	  const naviCheckbox = document.getElementById('naviCheckbox');
      const naviMinutesInput = document.getElementById('naviMinutes');
      // Add an event listener to the navi checkbox
      naviCheckbox.addEventListener('change', function () {
        // Show or hide the naviMinutes input based on the checkbox state
        naviMinutesInput.style.display = this.checked ? '' : 'none';
      });
	  
	  
	  // Halacha Checkbox
	  const halachaCheckbox = document.getElementById('halachaCheckbox');
      const halachaMinutesInput = document.getElementById('halachaMinutes');
      // Add an event listener to the halacha checkbox
      halachaCheckbox.addEventListener('change', function () {
        // Show or hide the halachaMinutes input based on the checkbox state
        halachaMinutesInput.style.display = this.checked ? '' : 'none';
      });	  
	  
	  // Shabbos Learning Checkbox
	  const shabbosLearningCheckbox = document.getElementById('shabbosLearningCheckbox');
      const shabbosLearningInput = document.getElementById('shabbosLearningTime');
      // Add an event listener to the shabbosLearning checkbox
      shabbosLearningCheckbox.addEventListener('change', function () {
        // Show or hide the shabbosLearning input based on the checkbox state
        shabbosLearningInput.style.display = this.checked ? '' : 'none';
      });	  
	   
	  // Parsha Checkbox
	  const parshaCheckbox = document.getElementById('parshaCheckbox');
	  const parshaInput = document.getElementById('parshaSummary');

	  parshaCheckbox.addEventListener('change', function () {
		parshaInput.style.display = this.checked ? 'block' : 'none';
	  });

	  // Shiur Checkbox
	  const shiurCheckbox = document.getElementById('shiurCheckbox');
	  const shiurInput = document.getElementById('shiur');

	  shiurCheckbox.addEventListener('change', function () {
		shiurInput.style.display = this.checked ? 'block' : 'none';
	  });

	  // Mazeltov Checkbox
	  const mazeltovCheckbox = document.getElementById('mazeltovCheckbox');
	  const mazeltovInput = document.getElementById('mazeltov');

	  mazeltovCheckbox.addEventListener('change', function () {
		mazeltovInput.style.display = this.checked ? 'block' : 'none';
	  });

	  // Events Checkbox
	  const eventsCheckbox = document.getElementById('eventsCheckbox');
	  const eventsInput = document.getElementById('events');

	  eventsCheckbox.addEventListener('change', function () {
		eventsInput.style.display = this.checked ? 'block' : 'none';
	  });
	  
	  // Kiddush Checkbox
	  const kiddushCheckbox = document.getElementById('kiddushCheckbox');
	  const kiddushInput = document.getElementById('kiddush');

	  kiddushCheckbox.addEventListener('change', function () {
		kiddushInput.style.display = this.checked ? 'block' : 'none';
	  });
	  
	  // Kollel Checkbox
	  const kollelCheckbox = document.getElementById('kollelCheckbox');
	  const kollelInput = document.getElementById('kollel');

		kollelCheckbox.addEventListener('change', function () {
			kollelInput.style.display = this.checked ? 'block' : 'none';
		});

		// Avos U'banim Checkbox
		const avosubanimCheckbox = document.getElementById('avosubanimCheckbox');
		const avosubanimInput = document.getElementById('avosubanim');

		avosubanimCheckbox.addEventListener('change', function () {
			avosubanimInput.style.display = this.checked ? 'block' : 'none';
		});

		// Bnos Checkbox
		const bnosCheckbox = document.getElementById('bnosCheckbox');
		const bnosInput = document.getElementById('bnos');

		bnosCheckbox.addEventListener('change', function () {
			bnosInput.style.display = this.checked ? 'block' : 'none';
		});
		
		
		

    // store checkbox values in browser for future reference

    // Function to update local storage with checkbox states
    function updateCheckboxLocalStorage(checkbox) {
      localStorage.setItem(checkbox.id, checkbox.checked.toString());
    }

    // Function to apply checkbox states from local storage
    function applyCheckboxLocalStorage(checkbox) {
      const storedValue = localStorage.getItem(checkbox.id);
      checkbox.checked = storedValue === "true";
    }

    // Apply stored checkbox states on page load
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
      applyCheckboxLocalStorage(checkbox);
      checkbox.addEventListener('change', function () {
        updateCheckboxLocalStorage(checkbox);
      });
    });
	
	
	// store values that wont change weekly in browser
	
	    // Function to update local storage with input values
    function updateInputLocalStorage(input) {
      localStorage.setItem(input.id, input.value);
    }

    // Function to apply input values from local storage
    function applyInputLocalStorage(input) {
      const storedValue = localStorage.getItem(input.id);
      input.value = storedValue || "";
    }

    // Apply stored input values on page load
    const inputsToStore = [
      document.getElementById("logoUrl"),
      document.getElementById("zipInput"),
      document.getElementById("shabbosShachrisInput"),
      document.getElementById("shabbosLearningInput"),
      document.getElementById("shabbosMinchaInput"),
      document.getElementById("halachaShiurHeaderInput"),
      document.getElementById("halachaShiurTimeInput"),
      document.getElementById("naviMinutesInput")
    ];

    inputsToStore.forEach(function (input) {
      applyInputLocalStorage(input);
      input.addEventListener('input', function () {
        updateInputLocalStorage(input);
      });
    });
		
	  
    });
  </script>
</head>
<body>
  <h1>Newsletter Generator - Shabbat Zmanim</h1>
  
  <!-- Zmanim Form -->
  <form id="zmanim-form" action="newsletter.php" method="post">
  
      <!-- Checkbox Group -->
    <div class="checkbox-group">
	  <input type="checkbox" id="naviCheckbox" name="naviCheckbox">
      <label for="naviCheckbox">Include Navi</label>
      	  
	  <input type="checkbox" id="shiurCheckbox" name="shiurCheckbox">
	  <label for="shiurCheckbox">Include Shiur</label>
       
	  <input type="checkbox" id="parshaCheckbox" name="parshaCheckbox">
	  <label for="parshaCheckbox">Include Parsha</label>
	  
	  <input type="checkbox" id="halachaCheckbox" name="halachaCheckbox">
	  <label for="halachaCheckbox">Include Shabbos Shiur</label>
      
	  <input type="checkbox" id="mazeltovCheckbox" name="mazeltovCheckbox">
	  <label for="mazeltovCheckbox">Include Mazel Tovs</label>
      
	  <input type="checkbox" id="eventsCheckbox" name="eventsCheckbox">
	  <label for="eventsCheckbox">Include Events</label>
      
	  <input type="checkbox" id="kiddushCheckbox" name="kiddushCheckbox">
	  <label for="kiddushCheckbox">Include Kiddush</label>
      
	  <input type="checkbox" id="bnosCheckbox" name="bnosCheckbox">
	  <label for="bnosCheckbox">Bnos</label>
      
	  <input type="checkbox" id="avosubanimCheckbox" name="avosubanimCheckbox">
	  <label for="avosubanimCheckbox">Avos U'banim</label>
      
	  <input type="checkbox" id="kollelCheckbox" name="kollelCheckbox">
	  <label for="kollelCheckbox">Kollel</label>
	  
	  <input type="checkbox" id="eiruvCheckbox" name="eiruvCheckbox">
	  <label for="eiruvCheckbox">Eiruv is UP</label>
	  
	  <input type="checkbox" id="shabbosLearningCheckbox" name="shabbosLearningCheckbox">
	  <label for="shabbosLearningCheckbox">Shabbos Learning</label>
      
	  
	  
    </div>
	
	<hr>
	
<div class="input-group">
  <!-- Logo URL Input -->
  <label for="logoUrl">Logo URL:</label>
  <input type="url" id="logoUrl" name="logoUrl" placeholder="Enter Logo URL">
</div>

<div class="input-group">
  <!-- Zip Code -->
  <label for="zipInput">Zip Code:</label>
  <input type="text" id="zipInput" value="10931" name="zipInput">
</div>

<div class="input-group">
  <!-- Date Input -->
  <label for="date">Enter a Friday Date (defaults to the next Friday) (YYYY-MM-DD):</label>
  <input type="date" id="date" name="date" required>
</div>

<div class="input-group">
  <!-- Shabbos Shachris Time -->
  <label for="shabbosShachrisInput">Shabbos Shachris Time:</label>
  <input type="time" id="shabbosShachrisInput" value="08:30" name="shabbosShachrisInput">
</div>







<div class="input-group">
  <!-- Shabbos Mincha Time -->
  <label for="shabbosMinchaInput">Shabbos Mincha (Min before Shkia):</label>
  <input type="number" id="shabbosMinchaInput" value="40" name="shabbosMinchaInput">
</div>





<div class="nested-input-group" id="shabbosLearningTime" style="display: none;">
  <!-- Shabbos Learning Time -->
  <label for="shabbosLearningInput">Shabbos Learning (Min before Mincha):</label>
  <input type="number" id="shabbosLearningInput" value="30" name="shabbosLearningInput">
</div>





<div class="nested-input-group" id="halachaMinutes" style="display: none;">
  <!-- Halacha Shiur Header -->
  <label for="halachaShiurHeaderInput">Shabbos Shiur Name:</label>
  <input type="text" id="halachaShiurHeaderInput" value="Halacha Shiur" name="halachaShiurHeaderInput">

  <!-- Halacha Shiur Time -->
  <label for="halachaShiurTimeInput">Shabbos Shiur Time:</label>
  <input type="time" id="halachaShiurTimeInput" value="16:45" name="halachaShiurTimeInput">
</div>

<div class="nested-input-group" id="naviMinutes" style="display: none;">
  <!-- Navi Minutes Input -->
  <label for="naviMinutesInput">Minutes before Maariv for Navi (rounded up to the nearest 5-minute mark):</label>
  <input type="number" id="naviMinutesInput" value="25" name="naviMinutesInput">
</div>

    <hr>
	
	
	<!-- Parsha Summary Input -->
	<div id="parshaSummary" style="display: none;">
	  <label for="parshaSummary">Parsha Vort:</label>
	  <textarea class="tinymce" name="parshaSummary" rows="4" cols="50"></textarea>
	</div>

	<!-- Mazeltov Input -->
	<div id="mazeltov" style="display: none;">
	  <label for="mazeltov">Mazel Tov's:</label>
	  <textarea class="tinymce" name="mazeltov" rows="4" cols="50"></textarea>
	</div>

	<!-- Events Input -->
	<div id="events" style="display: none;">
	  <label for="events">Events:</label>
	  <textarea class="tinymce" name="events" rows="4" cols="50"></textarea>
	</div>
	
	<!-- Kiddush Input -->
	<div id="kiddush" style="display: none;">
	  <label for="kiddush">Kiddush:</label>
	  <textarea class="tinymce" name="kiddush" rows="4" cols="50"></textarea>
	</div>
	
	<div id="kollel" style="display: none;">
	  <label for="kollel">Kollel:</label>
	  <textarea class="tinymce" name="kollel" rows="4" cols="50"></textarea>
	</div>
	
	<div id="avosubanim" style="display: none;">
	  <label for="avosubanim">Avos U'banim:</label>
	  <textarea class="tinymce" name="avosubanim" rows="4" cols="50"></textarea>
	</div>

	<div id="bnos" style="display: none;">
	  <label for="bnos">B'Nos:</label>
	  <textarea class="tinymce" name="bnos" rows="4" cols="50"></textarea>
	</div>
	
	<!-- Shiur Input -->
	<div id="shiur" style="display: none;">
	  <label for="shiur">Shiur:</label>
	  <textarea class="tinymce" name="shiur" rows="4" cols="50"></textarea>
	</div>

    <button type="submit">Get Zmanim</button>
  </form>
  <!-- End Zmanim Form -->
</body>
</html>
