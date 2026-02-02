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
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background-color: #faf8f3;
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
      color: #5d4a3a;
      text-align: center;
      font-size: 2.5em;
      margin-bottom: 30px;
      font-weight: 600;
      grid-column: 1 / -1;
    }

    form {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(139, 115, 85, 0.08);
      border: 1px solid #e8e0d5;
    }

    #right-sidebar {
      background-color: #ffffff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(139, 115, 85, 0.08);
      border: 1px solid #e8e0d5;
      position: sticky;
      top: 20px;
    }

    #right-sidebar h3 {
      margin-top: 0;
      color: #8b7355;
      font-size: 1.2em;
      font-weight: 600;
    }

    #right-sidebar p {
      font-size: 0.9em;
      line-height: 1.6;
      color: #6b5d52;
    }

    #right-sidebar a {
      color: #8b7355;
      text-decoration: none;
      font-weight: 500;
    }

    #right-sidebar a:hover {
      text-decoration: underline;
      color: #6d5b45;
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
      color: #5d4a3a;
      margin: 30px 0 20px 0;
      padding-bottom: 10px;
      border-bottom: 2px solid #e8e0d5;
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
    }

    .section-header:first-of-type {
      margin-top: 0;
    }

    .section-header::before {
      content: '▶';
      color: #a89279;
      font-size: 0.7em;
    }

    /* Checkbox grid */
    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 12px;
      margin-bottom: 30px;
      padding: 20px;
      background-color: #f5f2ed;
      border-radius: 8px;
      border: 1px solid #e8e0d5;
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
      color: #5d4a3a;
      background-color: white;
      border: 1px solid #d9cfc0;
      border-radius: 6px;
      transition: all 0.2s ease;
      user-select: none;
    }

    .checkbox-wrapper label:hover {
      border-color: #8b7355;
      background-color: #fdfbf8;
      transform: translateY(-1px);
      box-shadow: 0 2px 4px rgba(139, 115, 85, 0.15);
    }

    .checkbox-wrapper label::before {
      content: '';
      display: inline-block;
      width: 18px;
      height: 18px;
      margin-right: 12px;
      border: 2px solid #c4b5a3;
      border-radius: 3px;
      background-color: white;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }

    .checkbox-wrapper input[type="checkbox"]:checked + label {
      border-color: #8b7355;
      background-color: #faf6f1;
      color: #5d4a3a;
      font-weight: 500;
    }

    .checkbox-wrapper input[type="checkbox"]:checked + label::before {
      background-color: #8b7355;
      border-color: #8b7355;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E");
      background-size: 14px;
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
      border: 1px solid #d9cfc0;
      border-radius: 6px;
      font-size: 15px;
      transition: all 0.2s ease;
      background-color: #fdfbf8;
    }

    input:focus {
      outline: none;
      border-color: #8b7355;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
    }

    input.error {
      border-color: #c97064;
      background-color: #fff5f5;
    }

    .date-helper {
      display: inline-block;
      margin-top: 6px;
      padding: 6px 12px;
      font-size: 13px;
      color: #8b7355;
      background-color: #faf6f1;
      border-radius: 4px;
      font-weight: 500;
      border: 1px solid #e8e0d5;
    }

    .date-helper.today {
      color: #6b8e4e;
      background-color: #f4f8f0;
      border-color: #d9e5d0;
    }

    /* Nested inputs */
    .nested-input-group {
      margin: 20px 0;
      padding: 20px;
      background-color: #faf6f1;
      border-left: 3px solid #8b7355;
      border-radius: 6px;
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
      border: 1px solid #d9cfc0;
      border-radius: 6px;
      font-size: 15px;
      font-family: inherit;
      resize: vertical;
      min-height: 100px;
      transition: all 0.2s ease;
      background-color: #fdfbf8;
    }

    textarea:focus {
      outline: none;
      border-color: #8b7355;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
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
      background-color: #8b7355;
      color: white;
      padding: 16px 32px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 30px;
    }

    button[type="submit"]:hover {
      background-color: #6d5b45;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(139, 115, 85, 0.25);
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

    /* Mincha toggle styles */
    .mincha-toggle {
      display: flex;
      gap: 8px;
      margin-bottom: 12px;
      background-color: #f5f2ed;
      padding: 4px;
      border-radius: 6px;
      border: 1px solid #e8e0d5;
    }

    .toggle-option {
      flex: 1;
      margin: 0;
      font-weight: normal;
    }

    .toggle-option input[type="radio"] {
      display: none;
    }

    .toggle-option span {
      display: block;
      padding: 8px 12px;
      text-align: center;
      font-size: 14px;
      color: #6b5d52;
      background-color: transparent;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.2s ease;
      user-select: none;
    }

    .toggle-option input[type="radio"]:checked + span {
      background-color: #8b7355;
      color: white;
      font-weight: 500;
    }

    .toggle-option:hover span {
      background-color: rgba(139, 115, 85, 0.1);
    }

    .toggle-option input[type="radio"]:checked + span:hover {
      background-color: #6d5b45;
    }

    .mincha-input-container {
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Shul Newsletter Generator - Shabbos Zmanim</h1>
    
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
          <label for="shiurCheckbox">Shiur</label>
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
          
          <!-- Toggle for Mincha type -->
          <div class="mincha-toggle">
            <label class="toggle-option">
              <input type="radio" name="minchaType" value="before" id="minchaTypeBefore" checked>
              <span>Minutes before Shkia</span>
            </label>
            <label class="toggle-option">
              <input type="radio" name="minchaType" value="settime" id="minchaTypeSetTime">
              <span>Set Time</span>
            </label>
          </div>

          <!-- Minutes before Shkia input -->
          <div id="minchaBeforeContainer" class="mincha-input-container">
            <input type="number" id="shabbosMinchaInput" value="40" name="shabbosMinchaInput" min="1" max="90">
            <span class="helper-text">Minutes before Shkia</span>
          </div>

          <!-- Set time input -->
          <div id="minchaSetTimeContainer" class="mincha-input-container" style="display: none;">
            <input type="time" id="shabbosMinchaTimeInput" name="shabbosMinchaTimeInput" value="17:00">
          </div>
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
          dateHelper.style.color = "#c97064";
          dateHelper.style.backgroundColor = "#fff5f5";
          dateHelper.style.borderColor = "#f5d6d0";
        } else {
          this.classList.remove('error');
          const isToday = selectedDate.getTime() === today.getTime();
          updateDateHelper(isToday);
        }
      });

      // Mincha type toggle
      const minchaTypeBefore = document.getElementById('minchaTypeBefore');
      const minchaTypeSetTime = document.getElementById('minchaTypeSetTime');
      const minchaBeforeContainer = document.getElementById('minchaBeforeContainer');
      const minchaSetTimeContainer = document.getElementById('minchaSetTimeContainer');

      function updateMinchaDisplay() {
        if (minchaTypeBefore.checked) {
          minchaBeforeContainer.style.display = 'block';
          minchaSetTimeContainer.style.display = 'none';
        } else {
          minchaBeforeContainer.style.display = 'none';
          minchaSetTimeContainer.style.display = 'block';
        }
      }

      minchaTypeBefore.addEventListener('change', updateMinchaDisplay);
      minchaTypeSetTime.addEventListener('change', updateMinchaDisplay);

      // Apply stored mincha type preference
      const storedMinchaType = localStorage.getItem('minchaType');
      if (storedMinchaType === 'settime') {
        minchaTypeSetTime.checked = true;
      }
      updateMinchaDisplay();

      // Store mincha type preference
      minchaTypeBefore.addEventListener('change', function() {
        if (this.checked) {
          localStorage.setItem('minchaType', 'before');
        }
      });

      minchaTypeSetTime.addEventListener('change', function() {
        if (this.checked) {
          localStorage.setItem('minchaType', 'settime');
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
        'shabbosMinchaTimeInput',
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
