<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST["date"];
    $zip = $_POST["zipInput"];
    $naviminutes = $_POST["naviMinutesInput"];
    $shabbosMinchaAmount = $_POST["shabbosMinchaInput"];
    $includeHalacha = isset($_POST["halachaCheckbox"]);
    $halachashiurheader = $includeHalacha ? $_POST["halachaShiurHeaderInput"] : "";
    $halachashiurtimeraw = $includeHalacha ? $_POST["halachaShiurTimeInput"] : "";
    $halachashiurtime = date("g:i A", strtotime($halachashiurtimeraw));
    $shabbosShachrisraw = $_POST["shabbosShachrisInput"];
    $shabbosShachris = date("g:i A", strtotime($shabbosShachrisraw));

    // Check if the "Include Parsha" checkbox is checked
    $includeshabbosLearning = isset($_POST["shabbosLearningCheckbox"]);
    $shabbosLearning = $includeshabbosLearning ? $_POST["shabbosLearningInput"] : "";

    // Check if the "Include Parsha" checkbox is checked
    $includeParsha = isset($_POST["parshaCheckbox"]);
    $parshaSummary = $includeParsha ? $_POST["parshaSummary"] : "";

    // Check if the "Include Shiur" checkbox is checked
    $includeShiur = isset($_POST["shiurCheckbox"]);
    $shiur = $includeShiur ? $_POST["shiur"] : "";

    //"Include Mazel Tovs"
    $includeMazeltovs = isset($_POST["mazeltovCheckbox"]);
    $mazeltovs = $includeMazeltovs ? $_POST["mazeltov"] : "";

    //"Include Events"
    $includeEvents = isset($_POST["eventsCheckbox"]);
    $events = $includeEvents ? $_POST["events"] : "";

    //"Include Kiddush"
    $includeKiddush = isset($_POST["kiddushCheckbox"]);
    $kiddush = $includeKiddush ? $_POST["kiddush"] : "";

    //"Include Bnos"
    $includeBnos = isset($_POST["bnosCheckbox"]);
    $bnos = $includeBnos ? $_POST["bnos"] : "";

    //"Include Kollel"
    $includeKollel = isset($_POST["kollelCheckbox"]);
    $kollel = $includeKollel ? $_POST["kollel"] : "";

    //"Include Kiddush"
    $includeAvosubanim = isset($_POST["avosubanimCheckbox"]);
    $avosubanim = $includeAvosubanim ? $_POST["avosubanim"] : "";

    $eiruvIsUp = isset($_POST["eiruvCheckbox"]) && $_POST["eiruvCheckbox"] === "on";
    $eiruvStatus = $eiruvIsUp ? "Eiruv is Up" : "Eiruv is Down";

    // Handle logourl - check if URL is provided, otherwise use default
    $logourl = !empty($_POST["logourl"]) ? htmlspecialchars($_POST["logourl"], ENT_QUOTES, 'UTF-8') : "https://kehillashillburn.com/newslettergenerator/logo.png";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shul Newsletter</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 800px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }
@media print {
  .container {
    box-shadow: none; /* or any other styles you want for printing */
  }
}

    header {
        color: #fff;
        text-align: center;
        padding: 10px;
        width: 100%;
    }

    header img {
        margin: 0;
    }

    nav {
        background-color: #cddde8;
        color: #000;
        padding: 25px 10px 10px 10px;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }

    .davening-times {
        text-align: center;
        width: 100%;
        order: 1; /* Move to the top */
    }

    .davening-times h2 {
        margin: 0px; 
    }

    .friday-times,
    .shabbat-times {
        width: 36%; /* Adjust width for smaller screens */
        box-sizing: border-box;
    }

    .friday-times {
        order: 2; /* Move Friday Night below Davening Times */
    }

    .shabbat-times {
        order: 3; /* Move Shabbos Day below Davening Times and Friday Night */
    }

    .main-content {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
        color: #184183;
    }

    footer {
        background-color: #184183;
        color: #fff;
        text-align: center;
        padding: 10px;
        width: 100%;
    }

    h2#parshaHeader,
    h2#rabbisdesk,
    h2#mazeltovsHeader,
    h2#eventsHeader,
    h2#kiddushHeader,
    h2#avosubanimHeader,
    h2#kollelHeader,
    h2#bnosHeader {
        text-align: center;
        color: #35A8E0;
    }

    /* Add this CSS to style your UL and LI */
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    ul li {
        padding: 5px 0;
        border-bottom: 1px solid #ddd;
    }

    ul li:last-child {
        border-bottom: none;
    }

    /* Additional styles for your specific lists */
    .main-content ul {
        padding-left: 20px;
    }

    .main-content li {
        color: #184183;
        font-weight: bold;
    }
article p {
    text-align: left;
    margin: 0 auto; /* Center the text */
    max-width: 600px; /* Adjust the max-width as needed */
}

.page {
    overflow: hidden;
    page-break-after: always;
}
.page:last-of-type {
    page-break-after: auto
}

/* Eiruv Status Styling */
.eiruv-status {
  text-align: center;
  width: 75%;
  margin-top: 25px;
  border: 2px solid #35A8E0; /* Add border */
  border-radius: 8px; /* Add border radius for rounded corners */
  padding: 10px; /* Add padding for better spacing */
  box-shadow: 0 4px 8px rgba(53, 168, 224, 0.2); /* Add a subtle box shadow */
}

.eiruv-status h3 {
  margin: 0;
  font-family: 'Cursive', 'Brush Script MT', cursive; /* Choose a decorative font */
  font-size: 36px;
  color: #35A8E0;
  text-shadow: 2px 2px 4px rgba(53, 168, 224, 0.5); /* Add a subtle text shadow */
}

.eiruv-status p {
  font-family: 'Verdana', sans-serif;
  font-weight: bold;
  font-size: 20px;
  color: #184183;
  margin-bottom: 5px;
}

  </style>
</head>

<body>
  <div id="newsletter" class="container">
		<header>
			<img src="<?php echo $logourl; ?>" alt="Shul Logo" style="max-width: 250px; height: auto;">
		</header>
    <nav>

      <div class="davening-times">
        <h2>Davening Times</h2>
        <div id="dateRange"></div>
      </div>
      <div class="friday-times">
        <h3>Friday Night</h3>
        <ul>
          <li id="candleLighting"></li>
          <li id="minchaTime"></li>
          <li id="shkia"></li>
        </ul>
		
		<div class="eiruv-status">
			<h3>Eiruv Status</h3>
			<p><?php echo $eiruvStatus; ?></p>
		</div>
      </div>
      <div class="shabbat-times">
        <h3>Shabbos Day</h3>
        <ul>
		  <li id="Shachris">Shachris: <?php echo $shabbosShachris; ?></li>
          <li id="sofZmanShma"></li>
		  <li id="halachashiur"><?php echo $halachashiurheader . " " . $halachashiurtime;?></li>
		  <li id="shabbosLearning"></li>
		  <li id="minchaTimeShabbat"></li>
          <li id="shkiaShabbat"></li>
          <li id="naviShiur"></li>
          <li id="maariv"></li>
          <li id="havdalah42"></li>
          <li id="havdalah72"></li>
        </ul>
      </div>
    </nav>


    <article class="main-content">
      <h2 id="parshaHeader"></h2>

      <?php if (!empty($parshaSummary) && $includeParsha): ?>
        <p><?php echo $parshaSummary; ?></p>
      <?php endif; ?>


      <?php if (!empty($mazeltovs) && $includeMazeltovs): ?>
        <h2 id="mazeltovsHeader">Mazel Tov's!</h2>
        <p><?php echo $mazeltovs; ?></p>
      <?php endif; ?>

      <?php if (!empty($events) && $includeEvents): ?>

        <h2 id="eventsHeader">Weekly Events</h2>
        <p><?php echo $events; ?></p>
      <?php endif; ?>
	  
	        <?php if (!empty($kollel) && $includeKollel): ?>

        <h2 id="kollelHeader">Kollel</h2>
        <p><?php echo $kollel; ?></p>
      <?php endif; ?>

      <?php if (!empty($avosubanim) && $includeAvosubanim): ?>

        <h2 id="avosubanimHeader">Avos U'banim</h2>
        <p><?php echo $avosubanim; ?></p>
      <?php endif; ?>

      <?php if (!empty($bnos) && $includeBnos): ?>

        <h2 id="bnosHeader">Bnos</h2>
        <p><?php echo $bnos; ?></p>
      <?php endif; ?>

      <?php if (!empty($kiddush) && $includeKiddush): ?>

        <h2 id="kiddushHeader">Kiddush</h2>
        <p><?php echo $kiddush; ?></p>
      <?php endif; ?>

      <?php if (!empty($shiur) && $includeShiur): ?>

        <h2 id="rabbisdesk">From the Rabbi's Desk</h2>
        <p><?php echo $shiur; ?></p>
      <?php endif; ?>
    </article>
	
	
    <div id="resultsDiv"></div>
	
  </div>

       <script>
        // Directly use the PHP variable for date
        const date = "<?php echo $date; ?>";
        const resultsDiv = document.getElementById('zmanim-results');
		
		// Add one day to the date for Shabbat
		const nextDay = new Date(date);
		nextDay.setDate(nextDay.getDate() + 1);
		const shabbatDate = nextDay.toISOString().split('T')[0];

        function formatTimestamp(timestamp) {
            const date = new Date(timestamp);
            const options = {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
            };

            return new Intl.DateTimeFormat('en-US', options).format(date);
        }

        function formatTimestamprounded(timestamp) {
			//rounded up, so its earlier
            const date = new Date(timestamp);
            const options = {
                hour: 'numeric',
                minute: 'numeric',
            };

            return new Intl.DateTimeFormat('en-US', options).format(date);
        }

        // Hebcal API call
        const shabbatApiUrl72 = `https://www.hebcal.com/shabbat?cfg=json&zip=<?php echo $zip; ?>&sec=1&m=72&a=on&gy=${date.slice(0, 4)}&gm=${date.slice(5, 7)}&gd=${date.slice(8, 10)}`;
		const shabbatApiUrl42 = `https://www.hebcal.com/shabbat?cfg=json&zip=<?php echo $zip; ?>&sec=1&m=42&a=on&gy=${date.slice(0, 4)}&gm=${date.slice(5, 7)}&gd=${date.slice(8, 10)}`;
        const zmanimFridayApiUrl = `https://www.hebcal.com/zmanim?cfg=json&zip=<?php echo $zip; ?>&sec=1&a=on&date=${date.slice(0, 4)}-${date.slice(5, 7)}-${date.slice(8, 10)}`;
		// Not in use	const zmanimFridayApiUrlRounded = `https://www.hebcal.com/zmanim?cfg=json&zip=<?php echo $zip; ?>&a=on&date=${date.slice(0, 4)}-${date.slice(5, 7)}-${date.slice(8, 10)}`;
        const zmanimApiUrlroundedShabbos = `https://www.hebcal.com/zmanim?cfg=json&zip=<?php echo $zip; ?>&a=on&date=${shabbatDate}`;
		const zmanimApiUrlShabbos = `https://www.hebcal.com/zmanim?cfg=json&sec=1&a=on&zip=<?php echo $zip; ?>&a=on&date=${shabbatDate}`;


        // Fetch Shabbat data 72 minutes
        const shabbatPromise = fetch(shabbatApiUrl72)
            .then(response => response.json())
            .then(data => {
                const candleLighting = formatTimestamprounded(data.items.find(item => item.category === 'candles').date);
				//Calculate mincha based on candle lighting time
					const candleLightingDate = new Date(data.items.find(item => item.category === 'candles').date);
					candleLightingDate.setMinutes(candleLightingDate.getMinutes() + 3);
					const candleLightingmincha = formatTimestamprounded(candleLightingDate.toISOString());
                const havdalah = data.items.find(item => item.category === 'havdalah').hebrew;
                const parshaItem = data.items.find(item => item.category === 'parashat').hebrew;
                // Check if roshChodeshItem exists before accessing it
					const roshChodeshItem = data.items.find(item => item.category === 'roshchodesh')?.hebrew ?? '';
					const roshChodeshHebrew = roshChodeshItem ? roshChodeshItem.hebrew : '';
				//Get shabbos dates
				const startDate = new Date(data.range.start);
				const endDate = new Date(data.range.end);
				// Format the dates in full format (e.g., "February 9th-12th, 2024")
				const formattedStartDate = new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric' }).format(startDate);
				const formattedEndDate = new Intl.DateTimeFormat('en-US', { month: 'short', day: 'numeric', year: 'numeric' }).format(endDate);		
		
                return { candleLighting, havdalah, parshaItem, roshChodeshItem, candleLightingmincha, formattedStartDate, formattedEndDate };
            });
			
		// Fetch Shabbat data 42 minutes
        const shabbat42Promise = fetch(shabbatApiUrl42)
            .then(response => response.json())
            .then(data => {
                const havdalah = data.items.find(item => item.category === 'havdalah').hebrew;
                return { havdalah };
            });

        // Fetch Zmanim data
        const zmanimFridayPromise = fetch(zmanimFridayApiUrl)
            .then(response => response.json())
            .then(data => {
                const zmanimTimes = data.times;

                const sunset = formatTimestamprounded(zmanimTimes.sunset);
                return { sunset };
            });

        // Fetch Zmanim data Rounded
        const zmanimPromiserounded = fetch(zmanimApiUrlroundedShabbos)
            .then(response => response.json())
            .then(data => {
                const zmanimTimesrounded = data.times;
				//Used for Maariv
                const tzeit50min = formatTimestamprounded(zmanimTimesrounded.tzeit50min);
				// Calculate Navi Shiur time
				const naviShiurDate = new Date(zmanimTimesrounded.tzeit50min);
				naviShiurDate.setMinutes(naviShiurDate.getMinutes() - <?php echo $naviminutes; ?>);

				// Round up to the nearest 5 or 10 minutes
				const roundToMinutes = -5; // Change this to 10 if you want to round up to the nearest 10 minutes
				const roundedMinutes = Math.ceil(naviShiurDate.getMinutes() / roundToMinutes) * roundToMinutes;

				naviShiurDate.setMinutes(roundedMinutes);

				const naviShiur = formatTimestamprounded(naviShiurDate.toISOString());


                return { tzeit50min, naviShiur};
            });
			
		// Fetch Zmanim data for Shkia on Shabbat
		const zmanimPromiseShabbos = fetch(zmanimApiUrlShabbos)
			.then(response => response.json())
			.then(data => {
				const zmanimTimesShabbos = data.times;
				const sofZmanShma = formatTimestamp(zmanimTimesShabbos.sofZmanShma);
                const sofZmanShmaMGA = formatTimestamp(zmanimTimesShabbos.sofZmanShmaMGA);
				const shkiaShabbat = formatTimestamprounded(zmanimTimesShabbos.sunset);
				const tzeit42min = formatTimestamp(zmanimTimesShabbos.tzeit42min);
				const tzeit72min = formatTimestamp(zmanimTimesShabbos.tzeit72min);
				
				// Calculate Mincha time (40 minutes before Shkia)
				const minchaDate = new Date(zmanimTimesShabbos.sunset);
				minchaDate.setMinutes(minchaDate.getMinutes() - <?php echo $shabbosMinchaAmount;?>);
				const minchaTimeShabbat = formatTimestamprounded(minchaDate.toISOString());
				
				// Calculate Shabbos Learning Time (amount of minutes before mincha)
				
		// Calculate Shabbos Learning Time (amount of minutes before mincha)
const shabbosLearningMinutes = <?php echo $shabbosLearning; ?>;
const shabbosLearningTime = formatTimestamprounded(new Date(minchaDate.getTime() - shabbosLearningMinutes * 60000).toISOString());

				return { shkiaShabbat, tzeit42min, tzeit72min, sofZmanShma, sofZmanShmaMGA, minchaTimeShabbat, shabbosLearningTime };
        });

 // Combine the results when both promises are resolved
Promise.all([shabbatPromise, shabbat42Promise, zmanimFridayPromise, zmanimPromiserounded, zmanimPromiseShabbos])
    .then(([shabbatData, shabbat42Data, zmanimFridayData, zmanimDatarounded, zmanimShabbos]) => {
        // Create variables for each piece of information
       // const parshaHeader = `${shabbatData.parshaItem}`;
      //  const roshChodesh = `<p>${shabbatData.roshChodeshItem}</p>`;
        const candleLighting = `Candle Lighting: ${shabbatData.candleLighting}`;
		const shkia = `Shkia: ${zmanimFridayData.sunset}`;
		const minchaTime = `Mincha: ${shabbatData.candleLightingmincha}`;
		const havdalah42 = `${shabbat42Data.havdalah} ${zmanimShabbos.tzeit42min}`;
        const havdalah72 = `${shabbatData.havdalah} ${zmanimShabbos.tzeit72min}`;
        const sofZmanShma = `Zman Shma: ${zmanimShabbos.sofZmanShmaMGA} / ${zmanimShabbos.sofZmanShma}`;
		const shkiaShabbat = `Shkia: ${zmanimShabbos.shkiaShabbat}`;
        const maariv = `Maariv: ${zmanimDatarounded.tzeit50min}`;
		const naviShiur = `Navi: ${zmanimDatarounded.naviShiur}`;
		const dateRange = `${shabbatData.formattedStartDate} - ${shabbatData.formattedEndDate}`;
		
		


		const minchaTimeShabbatElement = document.getElementById('minchaTimeShabbat');
        minchaTimeShabbatElement.innerHTML = `Mincha, followed by Shalashudis: ${zmanimShabbos.minchaTimeShabbat}`;
		
		const shabbosLearningShabbatElement = document.getElementById('shabbosLearning');
        shabbosLearningShabbatElement.innerHTML = `Men and Boys Learning: ${zmanimShabbos.shabbosLearningTime}`;
		
		const parshaElement = document.getElementById('parshaHeader');
        
		if (shabbatData.roshChodeshItem) {
			const parshaHeader = `${shabbatData.parshaItem} - ${shabbatData.roshChodeshItem}`;
			parshaElement.innerHTML = parshaHeader;
		} else {
			parshaElement.innerHTML = `${shabbatData.parshaItem}`; 
		}
		
		const dateRangeElement = document.getElementById('dateRange');
		dateRangeElement.innerHTML = dateRange;
		
		const candleLightingElement = document.getElementById('candleLighting');
        candleLightingElement.innerHTML = candleLighting;
		
		const minchaTimeElement = document.getElementById('minchaTime');
		minchaTimeElement.innerHTML = minchaTime;
		
		const havdalah42Element = document.getElementById('havdalah42');
        havdalah42Element.innerHTML = havdalah42;
		
		const havdalah72Element = document.getElementById('havdalah72');
        havdalah72Element.innerHTML = havdalah72;
		
		const sofZmanShmaElement = document.getElementById('sofZmanShma');
        sofZmanShmaElement.innerHTML = sofZmanShma;
		
		const shkiaElement = document.getElementById('shkia');
        shkiaElement.innerHTML = shkia;
		
		const maarivElement = document.getElementById('maariv');
        maarivElement.innerHTML = maariv;		
		
        const shkiaShabbatElement = document.getElementById('shkiaShabbat');
        shkiaShabbatElement.innerHTML = shkiaShabbat;
		
		const naviShiurElement = document.getElementById('naviShiur');
		naviShiurElement.innerHTML = naviShiur;
		
		
    })
    .catch(error => {
        console.error(error);
        resultsDiv.innerHTML = '<p>Error fetching Zmanim. Please try again.</p>';
    });
    </script>
	
	
	<script>

document.addEventListener('DOMContentLoaded', () => {
  // Wait for 2 seconds (as per your comment)
 setTimeout(() => {
   window.print();
 }, 1000); // 2000 milliseconds (2 seconds)


  // // Wait for 2 seconds (as per your comment)
  // setTimeout(() => {
    // // Get the HTML content of the "newsletter" div
    // const newsletterContent = document.getElementById('newsletter').outerHTML;
	// const footer = document.getElementById('footer').outerHTML;
    // // Send the HTML content to the server for PDF generation
    // fetch('pdf.php', {
      // method: 'POST',
      // headers: {
        // 'Content-Type': 'application/json',
      // },
      // body: JSON.stringify({ html: newsletterContent, footerhtml: footer }),
    // })
      // .then(response => response.blob())
      // .then(blob => {
        // // Create a link element to trigger the download
        // const link = document.createElement('a');
        // link.href = window.URL.createObjectURL(blob);
        // link.download = 'shul_newsletter.pdf';

        // // Append the link to the body and trigger the click event
        // document.body.appendChild(link);
        // link.click();

        // // Remove the link element
        // document.body.removeChild(link);
      // })
      // .catch(error => {
        // console.error(error);
        // alert('Error generating PDF. Please try again.');
      // });
  // }, 2000); // 2000 milliseconds (2 seconds)




});
</script>
</body>

</html>