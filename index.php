<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="includes/tinymce/js/tinymce/tinymce.min.js"></script>
  <link rel="stylesheet" href="includes/tinymce/js/tinymce/skins/content/default/content.min.css">
  <title>Newsletter Generator - Shabbat Zmanim</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin: 0;
      padding: 20px;
      min-height: 100vh;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 280px;
      gap: 20px;
      align-items: start;
    }

    h1 {
      color: white;
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 30px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      grid-column: 1 / -1;
    }

    form {
      background-color: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    #right-sidebar {
      background-color: #fff;
      padding: 25px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      position: sticky;
      top: 20px;
    }

    #right-sidebar h3 {
      margin-top: 0;
      color: #667eea;
      font-size: 1.2em;
    }

    #right-sidebar p {
      font-size: 0.9em;
      line-height: 1.6;
      color: #666;
    }

    #right-sidebar a {
      color: #667eea;
      text-decoration: none;
    }

    #right-sidebar a:hover {
      text-decoration: underline;
    }

    /* Responsive layout */
    @media screen and (max-width: 1000px) {
      .container {
        grid-template-columns: 1fr;
      }

      #right-sidebar {
        position: static;
      }
    }

    /* Section headers */
    .section-header {
      font-size: 1.4em;
      color: #333;
      margin: 30px 0 20px 0;
      padding-bottom: 10px;
      border-bottom: 3px solid #667eea;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-header:first-of-type {
      margin-top: 0;
    }

    .section-header::before {
      content: '▶';
      color: #667eea;
      font-size: 0.8em;
    }

    /* Checkbox grid */
    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 12px;
      margin-bottom: 30px;
      padding: 20px;
      background-color: #f8f9ff;
      border-radius: 12px;
    }

    .checkbox-wrapper {
      position: relative;
    }

    .checkbox-wrapper input[type="checkbox"] {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }

    .checkbox-wrapper label {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      cursor: pointer;
      font-size: 15px;
      color: #333;
      background-color: white;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      transition: all 0.3s ease;
      user-select: none;
    }

    .checkbox-wrapper label:hover {
      border-color: #667eea;
      background-color: #f0f4ff;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(102, 126, 234, 0.2);
    }

    .checkbox-wrapper label::before {
      content: '';
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 12px;
      border: 2px solid #667eea;
      border-radius: 4px;
      background-color: white;
      transition: all 0.3s ease;
      flex-shrink: 0;
    }

    .checkbox-wrapper input[type="checkbox"]:checked + label {
      border-color: #667eea;
      background-color: #e8edff;
      color: #667eea;
      font-weight: 600;
    }

    .checkbox-wrapper input[type="checkbox"]:checked + label::before {
      background-color: #667eea;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E");
      background-size: 16px;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* Input groups */
    .input-group {
      margin-bottom: 24px;
    }

    .input-row {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 24px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #333;
      font-size: 14px;
    }

    input[type="text"],
    input[type="url"],
    input[type="date"],
    input[type="time"],
    input[type="number"] {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    input.error {
      border-color: #e53e3e;
      background-color: #fff5f5;
    }

    .date-helper {
      display: inline-block;
      margin-top: 6px;
      padding: 6px 12px;
      font-size: 13px;
      color: #667eea;
      background-color: #e8edff;
      border-radius: 6px;
      font-weight: 500;
    }

    .date-helper.today {
      color: #48bb78;
      background-color: #f0fff4;
    }

    /* Nested inputs */
    .nested-input-group {
      margin: 20px 0;
      padding: 20px;
      background-color: #f8f9ff;
      border-left: 4px solid #667eea;
      border-radius: 8px;
      display: none;
      animation: slideDown 0.3s ease;
    }

    .nested-input-group.visible {
      display: block;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .nested-input-group label {
      color: #555;
    }

    /* Textarea styling */
    textarea {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 15px;
      font-family: inherit;
      resize: vertical;
      min-height: 100px;
      transition: all 0.3s ease;
    }

    textarea:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .textarea-wrapper {
      margin-bottom: 24px;
      display: none;
      animation: slideDown 0.3s ease;
    }

    .textarea-wrapper.visible {
      display: block;
    }

    /* Button */
    button[type="submit"] {
      width: 100%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 16px 32px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 30px;
    }

    button[type="submit"]:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    button[type="submit"]:active {
      transform: translateY(0);
    }

    hr {
      margin: 30px 0;
      border: none;
      border-top: 2px solid #e0e0e0;
    }

    /* Helper text */
    .helper-text {
      font-size: 13px;
      color: #666;
      margin-top: 4px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Newsletter Generator - Shabbat Zmanim</h1>
    
    <!-- Zmanim Form -->
    <form id="zmanim-form" action="newsletter.php" method="post">
      
      <div class="section-header">Options to Include</div>
      
      <!-- Checkbox Grid -->
      <div class="checkbox-grid">
        <div class="checkbox-wrapper">
          <input type="checkbox" id="naviCheckbox" name="naviCheckbox">
          <label for="naviCheckbox">Navi</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="shiurCheckbox" name="shiurCheckbox">
          <label for="shiurCheckbox">D'var Torah</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="parshaCheckbox" name="parshaCheckbox">
          <label for="parshaCheckbox">Parsha</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="halachaCheckbox" name="halachaCheckbox">
          <label for="halachaCheckbox">Shabbos Shiur</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="mazeltovCheckbox" name="mazeltovCheckbox">
          <label for="mazeltovCheckbox">Mazel Tovs</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="eventsCheckbox" name="eventsCheckbox">
          <label for="eventsCheckbox">Events</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="kiddushCheckbox" name="kiddushCheckbox">
          <label for="kiddushCheckbox">Kiddush</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="bnosCheckbox" name="bnosCheckbox">
          <label for="bnosCheckbox">Bnos</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="avosubanimCheckbox" name="avosubanimCheckbox">
          <label for="avosubanimCheckbox">Avos U'banim</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="kollelCheckbox" name="kollelCheckbox">
          <label for="kollelCheckbox">Kollel</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="eiruvCheckbox" name="eiruvCheckbox">
          <label for="eiruvCheckbox">Eiruv is UP</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="shabbosLearningCheckbox" name="shabbosLearningCheckbox">
          <label for="shabbosLearningCheckbox">Shabbos Learning</label>
        </div>
        
        <div class="checkbox-wrapper">
          <input type="checkbox" id="includeDafYomiCheckbox" name="includeDafYomiCheckbox">
          <label for="includeDafYomiCheckbox">Daf Yomi</label>
        </div>
      </div>

      <div class="section-header">Basic Settings</div>

      <div class="input-row">
        <div class="input-group">
          <label for="logoUrl">Logo URL:</label>
          <input type="url" id="logoUrl" name="logoUrl" placeholder="https://example.com/logo.png">
        </div>

        <div class="input-group">
          <label for="zipInput">Zip Code:</label>
          <input type="text" id="zipInput" value="10931" name="zipInput" placeholder="10931">
        </div>
      </div>

      <div class="input-group">
        <label for="date">Shabbat Date (Friday):</label>
        <input type="date" id="date" name="date" required>
        <span id="dateHelper" class="date-helper"></span>
      </div>

      <div class="section-header">Time Settings</div>

      <div class="input-row">
        <div class="input-group">
          <label for="shabbosShachrisInput">Shabbos Shachris:</label>
          <input type="time" id="shabbosShachrisInput" value="08:30" name="shabbosShachrisInput">
        </div>

        <div class="input-group">
          <label for="shabbosMinchaInput">Shabbos Mincha:</label>
          <input type="number" id="shabbosMinchaInput" value="40" name="shabbosMinchaInput" min="1" max="90">
          <span class="helper-text">Minutes before Shkia</span>
        </div>
      </div>

      <!-- Conditional inputs -->
      <div class="nested-input-group" id="shabbosLearningTime">
        <label for="shabbosLearningInput">Shabbos Learning Time:</label>
        <input type="time" id="shabbosLearningInput" name="shabbosLearningInput">
      </div>

      <div class="nested-input-group" id="halachaMinutes">
        <div class="input-group">
          <label for="halachaShiurHeaderInput">Shabbos Shiur Name:</label>
          <input type="text" id="halachaShiurHeaderInput" value="Halacha Shiur" name="halachaShiurHeaderInput">
        </div>
        
        <div class="input-group">
          <label for="halachaShiurTimeInput">Shabbos Shiur Time:</label>
          <input type="time" id="halachaShiurTimeInput" value="16:45" name="halachaShiurTimeInput">
        </div>
      </div>

      <div class="nested-input-group" id="naviMinutes">
        <label for="naviMinutesInput">Navi - Minutes before Maariv:</label>
        <input type="number" id="naviMinutesInput" value="25" name="naviMinutesInput" min="5" max="60">
        <span class="helper-text">Rounded to nearest 5-minute mark</span>
      </div>

      <!-- Text areas for content -->
      <div class="section-header">Content Sections</div>

      <div class="textarea-wrapper" id="parshaSummary">
        <label for="parshaSummaryText">Parsha Vort:</label>
        <textarea class="tinymce" id="parshaSummaryText" name="parshaSummary"></textarea>
      </div>

      <div class="textarea-wrapper" id="shiur">
        <label for="shiurText">Shiur:</label>
        <textarea class="tinymce" id="shiurText" name="shiur"></textarea>
      </div>

      <div class="textarea-wrapper" id="mazeltov">
        <label for="mazeltovText">Mazel Tov's:</label>
        <textarea class="tinymce" id="mazeltovText" name="mazeltov"></textarea>
      </div>

      <div class="textarea-wrapper" id="events">
        <label for="eventsText">Events:</label>
        <textarea class="tinymce" id="eventsText" name="events"></textarea>
      </div>

      <div class="textarea-wrapper" id="kiddush">
        <label for="kiddushText">Kiddush:</label>
        <textarea class="tinymce" id="kiddushText" name="kiddush"></textarea>
      </div>

      <div class="textarea-wrapper" id="kollel">
        <label for="kollelText">Kollel:</label>
        <textarea class="tinymce" id="kollelText" name="kollel"></textarea>
      </div>

      <div class="textarea-wrapper" id="avosubanim">
        <label for="avosubanimText">Avos U'banim:</label>
        <textarea class="tinymce" id="avosubanimText" name="avosubanim"></textarea>
      </div>

      <div class="textarea-wrapper" id="bnos">
        <label for="bnosText">B'Nos:</label>
        <textarea class="tinymce" id="bnosText" name="bnos"></textarea>
      </div>

      <button type="submit">Generate Newsletter</button>
    </form>
    <!-- End Zmanim Form -->

    <div id="right-sidebar">
      <h3>About</h3>
      <p>Credit for Zmanim data: This newsletter generator uses Zmanim data through the <a href="https://www.hebcal.com/home/developer-apis" target="_blank">hebcal.com API</a>.</p>
      <p>For more details and to contribute to the open-source development, visit the <a href="https://github.com/yoshee08/shulnewslettergenerator" target="_blank">GitHub repository</a>.</p>
      <p>If you encounter any issues, please email <a href="mailto:yoshee08@gmail.com">yoshee08@gmail.com</a>.</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize TinyMCE
      tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'autoresize',
        autoresize_bottom_margin: 25,
        menubar: true,
        promotion: false,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
      });

      // Date handling - FIXED BUG: Friday is day 5, not 4!
      const dateInput = document.getElementById('date');
      const dateHelper = document.getElementById('dateHelper');

      function getDefaultDate() {
        const today = new Date();
        const dayOfWeek = today.getDay();

        // Check if today is Friday (day index 5, NOT 4!)
        if (dayOfWeek === 5) {
          return {
            date: today,
            isToday: true
          };
        } else {
          // Calculate days until next Friday
          const daysUntilFriday = (5 - dayOfWeek + 7) % 7 || 7;
          const nextFriday = new Date(today);
          nextFriday.setDate(today.getDate() + daysUntilFriday);
          return {
            date: nextFriday,
            isToday: false
          };
        }
      }

      // Set default date
      const defaultDateInfo = getDefaultDate();
      dateInput.value = defaultDateInfo.date.toISOString().split('T')[0];
      updateDateHelper(defaultDateInfo.isToday);

      function updateDateHelper(isToday) {
        if (isToday) {
          dateHelper.textContent = "Today is Friday! ✓";
          dateHelper.className = "date-helper today";
        } else {
          dateHelper.textContent = "Next Friday selected";
          dateHelper.className = "date-helper";
        }
      }

      // Validate date selection without annoying popups
      dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value + 'T00:00:00');
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        // Check if selected date is a Friday (day 5, NOT 4!)
        if (selectedDate.getDay() !== 5) {
          this.classList.add('error');
          dateHelper.textContent = "⚠️ Please select a Friday";
          dateHelper.className = "date-helper";
          dateHelper.style.color = "#e53e3e";
          dateHelper.style.backgroundColor = "#fff5f5";
        } else {
          this.classList.remove('error');
          const isToday = selectedDate.getTime() === today.getTime();
          updateDateHelper(isToday);
        }
      });

      // Checkbox toggle handlers - Improved with event delegation
      const checkboxMappings = {
        'naviCheckbox': 'naviMinutes',
        'halachaCheckbox': 'halachaMinutes',
        'shabbosLearningCheckbox': 'shabbosLearningTime',
        'parshaCheckbox': 'parshaSummary',
        'shiurCheckbox': 'shiur',
        'mazeltovCheckbox': 'mazeltov',
        'eventsCheckbox': 'events',
        'kiddushCheckbox': 'kiddush',
        'kollelCheckbox': 'kollel',
        'avosubanimCheckbox': 'avosubanim',
        'bnosCheckbox': 'bnos'
      };

      // Set up checkbox listeners
      Object.keys(checkboxMappings).forEach(checkboxId => {
        const checkbox = document.getElementById(checkboxId);
        const target = document.getElementById(checkboxMappings[checkboxId]);
        
        if (checkbox && target) {
          checkbox.addEventListener('change', function() {
            if (this.checked) {
              target.classList.add('visible');
            } else {
              target.classList.remove('visible');
            }
            updateLocalStorage(this.id, this.checked);
          });
        }
      });

      // LocalStorage management - Improved
      function updateLocalStorage(key, value) {
        localStorage.setItem(key, value);
      }

      function getFromLocalStorage(key, defaultValue = '') {
        return localStorage.getItem(key) || defaultValue;
      }

      // Apply stored checkbox states
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(checkbox => {
        const stored = localStorage.getItem(checkbox.id);
        if (stored === 'true') {
          checkbox.checked = true;
          checkbox.dispatchEvent(new Event('change'));
        }
      });

      // Apply stored input values
      const persistentInputs = [
        'logoUrl',
        'zipInput',
        'shabbosShachrisInput',
        'shabbosLearningInput',
        'shabbosMinchaInput',
        'halachaShiurHeaderInput',
        'halachaShiurTimeInput',
        'naviMinutesInput'
      ];

      persistentInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
          const stored = getFromLocalStorage(inputId);
          if (stored && !input.value) {
            input.value = stored;
          }
          
          input.addEventListener('input', function() {
            updateLocalStorage(this.id, this.value);
          });
        }
      });
    });
  </script>
</body>
</html>
