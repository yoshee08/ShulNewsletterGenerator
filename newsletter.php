<?php
// -------------------------
// Safe defaults (prevents undefined-variable issues on GET loads)
// -------------------------
$date = "";
$zip = "";
$naviminutes = 0;
$includeNavi = false;
$shabbosMinchaAmount = 0;

$includeHalacha = false;
$halachashiurheader = "";
$halachashiurtime = "";

$shabbosShachris = "";

$includeshabbosLearning = false;
$shabbosLearning = "";

$includeParsha = false;
$parshaSummary = "";

$includeDaf = false;

$includeShiur = false;
$shiur = "";

$includeMazeltovs = false;
$mazeltovs = "";

$includeEvents = false;
$events = "";

$includeKiddush = false;
$kiddush = "";

$includeBnos = false;
$bnos = "";

$includeKollel = false;
$kollel = "";

$includeAvosubanim = false;
$avosubanim = "";

$eiruvStatus = "Eiruv is Down";
$logourl = "logo.png";

// Helpers
function clean_text($v): string {
    return trim((string)$v);
}
function clean_url($v, $fallback = "logo.png"): string {
    $v = trim((string)$v);
    if ($v === "") return $fallback;
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
function format_time_am_pm($raw): string {
    $raw = trim((string)$raw);
    if ($raw === "") return "";
    $ts = strtotime($raw);
    if ($ts === false) return "";
    return date("g:i A", $ts);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = clean_text($_POST["date"] ?? "");
    $zip = clean_text($_POST["zipInput"] ?? "");

    $naviminutes = (int)($_POST["naviMinutesInput"] ?? 0);
    $shabbosMinchaAmount = (int)($_POST["shabbosMinchaInput"] ?? 0);

    // Halacha Shiur
    $includeHalacha = isset($_POST["halachaCheckbox"]);
    $halachashiurheader = $includeHalacha ? clean_text($_POST["halachaShiurHeaderInput"] ?? "") : "";
    $halachashiurtime = $includeHalacha ? format_time_am_pm($_POST["halachaShiurTimeInput"] ?? "") : "";

    // Shachris
    $shabbosShachris = format_time_am_pm($_POST["shabbosShachrisInput"] ?? "");

    // Shabbos Learning
    $includeshabbosLearning = isset($_POST["shabbosLearningCheckbox"]);
    $shabbosLearning = $includeshabbosLearning ? format_time_am_pm($_POST["shabbosLearningInput"] ?? "") : "";

    // Parsha
    $includeParsha = isset($_POST["parshaCheckbox"]);
    $parshaSummary = $includeParsha ? clean_text($_POST["parshaSummary"] ?? "") : "";

    // Daf Yomi
    $includeDaf = isset($_POST["includeDafYomiCheckbox"]);

    // Shiur
    $includeShiur = isset($_POST["shiurCheckbox"]);
    $shiur = $includeShiur ? clean_text($_POST["shiur"] ?? "") : "";

    // Mazel Tovs
    $includeMazeltovs = isset($_POST["mazeltovCheckbox"]);
    $mazeltovs = $includeMazeltovs ? clean_text($_POST["mazeltov"] ?? "") : "";

    // Events
    $includeEvents = isset($_POST["eventsCheckbox"]);
    $events = $includeEvents ? clean_text($_POST["events"] ?? "") : "";

    // Kiddush
    $includeKiddush = isset($_POST["kiddushCheckbox"]);
    $kiddush = $includeKiddush ? clean_text($_POST["kiddush"] ?? "") : "";

    // Bnos
    $includeBnos = isset($_POST["bnosCheckbox"]);
    $bnos = $includeBnos ? clean_text($_POST["bnos"] ?? "") : "";

    // Kollel
    $includeKollel = isset($_POST["kollelCheckbox"]);
    $kollel = $includeKollel ? clean_text($_POST["kollel"] ?? "") : "";

    // Avos U'banim
    $includeAvosubanim = isset($_POST["avosubanimCheckbox"]);
    $avosubanim = $includeAvosubanim ? clean_text($_POST["avosubanim"] ?? "") : "";

    // Eiruv
    $eiruvIsUp = (isset($_POST["eiruvCheckbox"]) && $_POST["eiruvCheckbox"] === "on");
    $eiruvStatus = $eiruvIsUp ? "Eiruv is Up" : "Eiruv is Down";
    

    // Navi
    $includeNavi = isset($_POST["naviCheckbox"]);
    $naviminutes = $includeNavi ? (int)($_POST["naviMinutesInput"] ?? 0) : 0;


    // Logo
    $logourl = clean_url($_POST["logourl"] ?? "", "logo.png");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shul Newsletter</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&display=swap" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; background:#f5f5f5; }
    .container { width:800px; margin:20px auto; background:#fff; box-shadow:0 0 10px rgba(0,0,0,.1); border-radius:8px; overflow:hidden; }
    @media print { .container{ box-shadow:none; } body{ background:#fff; } }
    header { color:#fff; text-align:center; padding:10px; width:100%; }
    header img { max-width:250px; height:auto; }
    nav { background:#cddde8; color:#000; padding:25px 10px; width:100%; display:flex; justify-content:space-evenly; flex-wrap:wrap; }
    .davening-times { text-align:center; width:100%; }
    .davening-times h2 { margin:0; }
    .friday-times, .shabbat-times { width:36%; box-sizing:border-box; }
    .main-content { width:100%; padding:20px; box-sizing:border-box; color:#184183; }
    footer { background:#184183; color:#fff; text-align:center; padding:10px; width:100%; }
    h2, h3 { text-align:center; color:#35A8E0; }
    ul { list-style:none; padding:0; margin:0; }
    ul li { padding:5px 0; border-bottom:1px solid #ddd; }
    ul li:last-child { border-bottom:none; }
    article p { text-align:left; margin:0 auto; max-width:600px; white-space:pre-wrap; }
    .eiruv-status { text-align:center; width:75%; margin-top:25px; border:2px solid #35A8E0; border-radius:8px; padding:10px; box-shadow:0 4px 8px rgba(53,168,224,.2); }
    .eiruv-status h3 { font-family:'Playfair Display',serif; font-size:24px; font-weight:900; font-style:italic; color:#35A8E0; text-shadow:1px 1px 2px rgba(0,0,0,.1); margin:10px 0; }
    .eiruv-status p { font-family:Verdana,sans-serif; font-weight:bold; font-size:20px; color:#184183; margin-bottom:5px; }
    .page { overflow:hidden; page-break-after:always; }
    .page:last-of-type { page-break-after:auto; }
  </style>
</head>

<body>
  <div id="newsletter" class="container">
    <header>
      <img src="<?php echo $logourl; ?>" alt="Shul Logo">
    </header>

    <nav>
      <div class="davening-times">
        <h2 contenteditable="true">Davening Times</h2>
        <div id="dateRange" contenteditable="true"></div>
        <div id="shabbosDaf" contenteditable="true"></div>
      </div>

      <div class="friday-times">
        <h3 contenteditable="true">Friday Night</h3>
        <ul>
          <li id="candleLighting" contenteditable="true"></li>
          <li id="minchaTime" contenteditable="true"></li>
          <li id="shkia" contenteditable="true"></li>
        </ul>
        <div class="eiruv-status">
          <h3 contenteditable="true">Eiruv Status</h3>
          <p contenteditable="true"><?php echo htmlspecialchars($eiruvStatus, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      </div>

      <div class="shabbat-times">
        <h3 contenteditable="true">Shabbos Day</h3>
        <ul>
          <li id="Shachris" contenteditable="true">Shachris: <?php echo htmlspecialchars($shabbosShachris, ENT_QUOTES, 'UTF-8'); ?></li>
          <li id="sofZmanShma" contenteditable="true"></li>

          <?php if ($includeHalacha && $halachashiurtime !== ""): ?>
            <li id="halachashiur" contenteditable="true">
              <?php echo htmlspecialchars($halachashiurheader . " " . $halachashiurtime, ENT_QUOTES, 'UTF-8'); ?>
            </li>
          <?php endif; ?>

          <?php if ($includeshabbosLearning && $shabbosLearning !== ""): ?>
            <li id="shabbosLearning" contenteditable="true">Men and Boys Learning: <?php echo htmlspecialchars($shabbosLearning, ENT_QUOTES, 'UTF-8'); ?></li>
          <?php endif; ?>

          <li id="minchaTimeShabbat" contenteditable="true"></li>
          <li id="shkiaShabbat" contenteditable="true"></li>
          
          <?php if ($includeNavi && $naviminutes !== ""): ?>
          <li id="naviShiur" contenteditable="true"></li>
          <?php endif; ?>
          
          <li id="maariv" contenteditable="true"></li>
          <li id="havdalah42" contenteditable="true"></li>
          <li id="havdalah72" contenteditable="true"></li>
        </ul>
      </div>
    </nav>

    <article class="main-content">
      <h2 id="parshaHeader" contenteditable="true"></h2>

      <?php if ($includeParsha && $parshaSummary !== ""): ?>
        <p contenteditable="true"><?php echo htmlspecialchars($parshaSummary, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeMazeltovs && $mazeltovs !== ""): ?>
        <h2 id="mazeltovsHeader" contenteditable="true">Mazel Tov's!</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($mazeltovs, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeEvents && $events !== ""): ?>
        <h2 id="eventsHeader" contenteditable="true">Weekly Events</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($events, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeKollel && $kollel !== ""): ?>
        <h2 id="kollelHeader" contenteditable="true">Kollel</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($kollel, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeAvosubanim && $avosubanim !== ""): ?>
        <h2 id="avosubanimHeader" contenteditable="true">Avos U'banim</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($avosubanim, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeBnos && $bnos !== ""): ?>
        <h2 id="bnosHeader" contenteditable="true">Bnos</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($bnos, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeKiddush && $kiddush !== ""): ?>
        <h2 id="kiddushHeader" contenteditable="true">Kiddush</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($kiddush, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>

      <?php if ($includeShiur && $shiur !== ""): ?>
        <h2 id="rabbisdesk" contenteditable="true">From the Rabbi's Desk</h2>
        <p contenteditable="true"><?php echo htmlspecialchars($shiur, ENT_QUOTES, 'UTF-8'); ?></p>
      <?php endif; ?>
    </article>

    <div id="resultsDiv"></div>
  </div>

  <script>
    // Pull PHP values safely into JS
    const date = <?php echo json_encode($date); ?>;
    const zip = <?php echo json_encode($zip); ?>;
    const naviMinutes = <?php echo (int)$naviminutes; ?>;
    const shabbosMinchaAmount = <?php echo (int)$shabbosMinchaAmount; ?>;
    const includeDafCheckbox = <?php echo json_encode((bool)$includeDaf); ?>;
    const includeNaviCheckbox = <?php echo json_encode((bool)$includeNavi); ?>;

    const resultsDiv = document.getElementById('resultsDiv');

    function setHTML(id, html) {
      const el = document.getElementById(id);
      if (el) el.innerHTML = html;
    }

    function parseISODateToLocal(iso) {
      if (!iso || typeof iso !== "string") return null;
      const parts = iso.split("-");
      if (parts.length !== 3) return null;
      const y = Number(parts[0]), m = Number(parts[1]), d = Number(parts[2]);
      if (!y || !m || !d) return null;
      return new Date(y, m - 1, d); // local midnight (avoids UTC shifting)
    }

    function formatTimestamp(timestamp) {
      const d = new Date(timestamp);
      const options = { hour: 'numeric', minute: 'numeric', second: 'numeric' };
      return new Intl.DateTimeFormat('en-US', options).format(d);
    }

    function formatTimestamprounded(timestamp) {
      const d = new Date(timestamp);
      const options = { hour: 'numeric', minute: 'numeric' };
      return new Intl.DateTimeFormat('en-US', options).format(d);
    }

    // Guard: don't run fetches if required inputs are missing
    if (!date || !zip) {
      if (resultsDiv) {
        resultsDiv.innerHTML = "<p>Please provide both a date and zip code.</p>";
      }
    } else {
      // Add one day to the date for Shabbat
      const baseDate = parseISODateToLocal(date);
      const nextDay = baseDate ? new Date(baseDate.getTime()) : null;
      if (nextDay) nextDay.setDate(nextDay.getDate() + 1);
      const shabbatDate = nextDay
        ? `${nextDay.getFullYear()}-${String(nextDay.getMonth()+1).padStart(2,'0')}-${String(nextDay.getDate()).padStart(2,'0')}`
        : "";

      const shabbatApiUrl72 = `https://www.hebcal.com/shabbat?cfg=json&zip=${zip}&sec=1&m=72&a=on&gy=${date.slice(0,4)}&gm=${date.slice(5,7)}&gd=${date.slice(8,10)}`;
      const shabbatApiUrl42 = `https://www.hebcal.com/shabbat?cfg=json&zip=${zip}&sec=1&m=42&a=on&gy=${date.slice(0,4)}&gm=${date.slice(5,7)}&gd=${date.slice(8,10)}`;
      const zmanimFridayApiUrl = `https://www.hebcal.com/zmanim?cfg=json&zip=${zip}&sec=1&a=on&date=${date.slice(0,4)}-${date.slice(5,7)}-${date.slice(8,10)}`;
      const zmanimApiUrlroundedShabbos = `https://www.hebcal.com/zmanim?cfg=json&zip=${zip}&a=on&date=${shabbatDate}`;
      const zmanimApiUrlShabbos = `https://www.hebcal.com/zmanim?cfg=json&sec=1&a=on&zip=${zip}&a=on&date=${shabbatDate}`;
      const zmanimApiUrlDafYomi = `https://www.hebcal.com/hebcal?cfg=json&v=1&F=on&start=${shabbatDate}&end=${shabbatDate}`;

      const shabbatPromise = fetch(shabbatApiUrl72)
        .then(r => r.json())
        .then(data => {
          const candleData = data.items.find(item => item.category === 'candles');
          const havdalahData = data.items.find(item => item.category === 'havdalah');
          const parshaData = data.items.find(item => item.category === 'parashat');
          const roshChodeshData = data.items.find(item => item.category === 'mevarchim');
          const shabbatItem = data.items.find(item => item.subcat === 'shabbat');

          const candleLighting = candleData ? formatTimestamprounded(candleData.date) : '';
          const candleLightingDate = candleData ? new Date(candleData.date) : null;
          if (candleLightingDate) candleLightingDate.setMinutes(candleLightingDate.getMinutes() + 3);
          const candleLightingmincha = candleLightingDate ? formatTimestamprounded(candleLightingDate.toISOString()) : '';

          const havdalah = havdalahData ? havdalahData.hebrew : '';
          const parshaItem = parshaData ? parshaData.hebrew : '';
          const roshChodeshItem = roshChodeshData ? roshChodeshData.hebrew : '';
          const shabbatItemHebrew = shabbatItem ? shabbatItem.hebrew : '';

          // Local-safe date range formatting (uses API range.start, but avoids timezone drift)
          const [startYear, startMonth, startDay] = (data.range.start || "").split('-').map(Number);
          const startDate = (startYear && startMonth && startDay) ? new Date(startYear, startMonth - 1, startDay) : null;
          const endDate = startDate ? new Date(startDate.getTime()) : null;
          if (endDate) endDate.setDate(endDate.getDate() + 1);

          const formattedStartDate = startDate ? new Intl.DateTimeFormat('en-US', { month:'short', day:'numeric' }).format(startDate) : "";
          const formattedEndDate = endDate ? new Intl.DateTimeFormat('en-US', { month:'short', day:'numeric', year:'numeric' }).format(endDate) : "";

          return { candleLighting, havdalah, parshaItem, roshChodeshItem, shabbatItemHebrew, candleLightingmincha, formattedStartDate, formattedEndDate };
        });

      const shabbat42Promise = fetch(shabbatApiUrl42)
        .then(r => r.json())
        .then(data => {
          const havdalahData = data.items.find(item => item.category === 'havdalah');
          const havdalah = havdalahData ? havdalahData.hebrew : '';
          return { havdalah };
        });

      const shabbatDafYomiPromise = fetch(zmanimApiUrlDafYomi)
        .then(r => r.json())
        .then(data => {
          const dafData = data.items.find(item => item.category === 'dafyomi');
          const Daf = dafData ? dafData.hebrew : '';
          return { Daf };
        });

      const zmanimFridayPromise = fetch(zmanimFridayApiUrl)
        .then(r => r.json())
        .then(data => {
          const t = data.times || {};
          const sunset = t.sunset ? formatTimestamprounded(t.sunset) : '';
          return { sunset };
        });

      const zmanimPromiserounded = fetch(zmanimApiUrlroundedShabbos)
        .then(r => r.json())
        .then(data => {
          const t = data.times || {};
          const tzeit50min = t.tzeit50min ? formatTimestamprounded(t.tzeit50min) : '';

          const naviShiurDate = t.tzeit50min ? new Date(t.tzeit50min) : null;
          if (naviShiurDate) {
            naviShiurDate.setMinutes(naviShiurDate.getMinutes() - naviMinutes);
            let minutes = naviShiurDate.getMinutes();
            minutes = Math.ceil(minutes / 5) * 5;
            naviShiurDate.setMinutes(minutes);
          }
          const naviShiur = naviShiurDate ? formatTimestamprounded(naviShiurDate.toISOString()) : '';
          return { tzeit50min, naviShiur };
        });

      const zmanimPromiseShabbos = fetch(zmanimApiUrlShabbos)
        .then(r => r.json())
        .then(data => {
          const t = data.times || {};
          const sofZmanShma = t.sofZmanShma ? formatTimestamp(t.sofZmanShma) : '';
          const sofZmanShmaMGA = t.sofZmanShmaMGA ? formatTimestamp(t.sofZmanShmaMGA) : '';
          const shkiaShabbat = t.sunset ? formatTimestamprounded(t.sunset) : '';
          const tzeit42min = t.tzeit42min ? formatTimestamp(t.tzeit42min) : '';
          const tzeit72min = t.tzeit72min ? formatTimestamp(t.tzeit72min) : '';

          const minchaDate = t.sunset ? new Date(t.sunset) : null;
          if (minchaDate) minchaDate.setMinutes(minchaDate.getMinutes() - shabbosMinchaAmount);
          const minchaTimeShabbat = minchaDate ? formatTimestamprounded(minchaDate.toISOString()) : '';

          return { shkiaShabbat, tzeit42min, tzeit72min, sofZmanShma, sofZmanShmaMGA, minchaTimeShabbat };
        });

      Promise.all([shabbatPromise, shabbat42Promise, zmanimFridayPromise, zmanimPromiserounded, zmanimPromiseShabbos, shabbatDafYomiPromise])
        .then(([shabbatData, shabbat42Data, zmanimFridayData, zmanimDatarounded, zmanimShabbos, shabbatDafYomi]) => {
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

          // Daf Yomi block
          const shabbosDaf = (includeDafCheckbox && shabbatDafYomi.Daf) ? `Shabbos Daf: ${shabbatDafYomi.Daf}` : '';
          setHTML('shabbosDaf', shabbosDaf);
          if (!includeDafCheckbox || !shabbosDaf) {
            const el = document.getElementById('shabbosDaf');
            if (el) el.style.display = 'none';
          }

          setHTML('minchaTimeShabbat', `Mincha(No Shalashudis): ${zmanimShabbos.minchaTimeShabbat}`);

          // Parsha header
          let parshaLine = `${shabbatData.parshaItem || ""}`.trim();
          if (shabbatData.roshChodeshItem) parshaLine += ` - ${shabbatData.roshChodeshItem}`;
          if (shabbatData.shabbatItemHebrew) parshaLine += ` - ${shabbatData.shabbatItemHebrew}`;
          setHTML('parshaHeader', parshaLine);

          setHTML('dateRange', dateRange);
          setHTML('candleLighting', candleLighting);
          setHTML('minchaTime', minchaTime);
          setHTML('havdalah42', havdalah42);
          setHTML('havdalah72', havdalah72);
          setHTML('sofZmanShma', sofZmanShma);
          setHTML('shkia', shkia);
          setHTML('maariv', maariv);
          setHTML('shkiaShabbat', shkiaShabbat);
          setHTML('naviShiur', naviShiur);
        })
        .catch(err => {
          console.error(err);
          if (resultsDiv) {
            resultsDiv.innerHTML = '<p>Error fetching Zmanim. Please try again.</p>';
          }
        });
    }
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('[contenteditable="true"]').forEach(el => {
        el.addEventListener("click", () => el.focus());
      });
    });
  </script>
</body>
</html>
