<?php header("Content-Type: text/html; charset=UTF-8"); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Performance Tracker</title>
  <style>
    :root{--accent:#ff9800;--accent-dark:#f57c00;--safe:#4caf50;--warn:#ffeb3b;--danger:#f44336;}
    html,body{height:100%;margin:0;font-family:Arial, Helvetica, sans-serif;background:#f3f3f3;}
    body {
      background: url("https://i.ibb.co/jkmSMZ0W/Gemini-Generated-Image-l5n3dtl5n3dtl5n3.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      height: 100vh;
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }
    .container{
      background: linear-gradient(135deg,#fff8e1,#ffb74d);
      border-radius:16px;padding:16px;width:95%;max-width:1200px;color:#222;box-shadow:0 6px 30px rgba(0,0,0,.35);
    }
    .header { display:flex;align-items:center;justify-content:space-between;margin-bottom:12px; }
    .title-group {display:flex;align-items:center;gap:12px;}
    h1{margin:0;font-size:1.5rem;color:#333}
    .ham {width:40px;height:36px;border-radius:8px;background:rgba(0,0,0,0.08);display:flex;align-items:center;justify-content:center;cursor:pointer}
    .ham .lines{display:flex;flex-direction:column;gap:4px}
    .ham .line{width:18px;height:2px;background:#333;border-radius:2px}
    .header-actions{display:flex;align-items:center;gap:8px}
    .btn {border:none;padding:8px 12px;border-radius:8px;cursor:pointer;font-weight:700}
    .btn.primary{background:var(--accent);color:#fff}
    .btn.secondary{background:rgba(0,0,0,0.06)}
    .btn.toggle-active{background:var(--safe);color:#fff;box-shadow:0 0 8px var(--safe);}
    .btn.toggle-inactive{background:#ddd;color:#333;box-shadow:none;}
    .target-inputs{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-bottom:10px}
    label{font-weight:700;white-space:nowrap}
    input[type=number]{width:84px;padding:6px;border-radius:6px;border:1px solid #ccc}
    input:disabled{background-color:#f5f5f5;color:#777;cursor:not-allowed;}
    .table-container{width:100%;overflow:auto;max-height:340px;border-radius:8px;margin-bottom:12px;border:1px solid #ffb74d;background:linear-gradient(135deg,#fff8e1,#ffb74d)}
    table{width:100%;border-collapse:collapse;min-width:750px}
    thead{background:linear-gradient(135deg,var(--accent),var(--accent-dark));color:#fff;position:sticky;top:0;z-index:2}
    th,td{padding:8px;text-align:center;border:1px solid #ffb74d}
    th:first-child, td:first-child{min-width:140px}
    th:nth-child(2),td:nth-child(2){min-width:150px}
    td input, td select {width:95%;padding:6px;border-radius:6px;border:1px solid #ccc;box-sizing:border-box}
    td input[type=date]{max-width:140px}
    .actions{display:flex;gap:6px;justify-content:center}
    .actions button {padding:6px 8px;border-radius:6px;border:none;cursor:pointer;color:#fff}
    .add-btn{background:var(--safe)}
    .remove-btn{background:var(--danger)}
    .remove-btn.disabled{background:#ccc;cursor:not-allowed;opacity:.6}
    .results{background:rgba(255,255,255,.9);border-radius:12px;padding:12px;margin-top:8px;display:flex;flex-direction:column;gap:8px}
    .result-row{display:flex;gap:8px;flex-wrap:wrap}
    .result-item{flex:1;min-width:200px;padding:10px;border-radius:10px;background:#ffb74d;font-weight:700;display:flex;justify-content:center;align-items:center}
    .result-item.met{background:rgba(76,175,80,.85);color:#fff}
    .result-item.miss{background:rgba(244,67,54,.85);color:#fff}
    .analysis-btn{background:#2196f3;color:#fff;padding:10px;border-radius:8px;border:none;cursor:pointer;font-weight:700}
    .modal{display:none;position:fixed;z-index:50;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.6);justify-content:center;align-items:center}
    .modal.show{display:flex}
    .modal-content{background:#fff;color:#333;padding:22px;border-radius:14px;width:680px;max-width:96%;max-height:86vh;overflow:auto;box-shadow:0 10px 40px rgba(0,0,0,.4)}
    .modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;border-bottom:2px solid #ffb74d;padding-bottom:8px}
    .modal-title{font-size:1.25rem;color:var(--accent)}
    .close{cursor:pointer;font-size:22px;color:#777}
    .modal-section{margin-bottom:12px}
    .ratio-explanation{background:#fff8e1;padding:12px;border-radius:8px;border-left:4px solid #ffb74d}
    .perf-table{width:100%;border-collapse:collapse;margin-top:8px}
    .perf-table th, .perf-table td{padding:8px;border:1px solid #ddd;text-align:center}
    .perf-table input[type=number]{width:100px}
    .perf-actions{display:flex;justify-content:center;gap:8px;margin-top:12px}
    .small-note{font-size:.9rem;color:#444}
    @media (max-width:768px){
      .result-row{flex-direction:column}
      table{min-width:600px}
      .modal-content{padding:12px}
    }
    .date-group-1{background:#f9f9f9;color:#222}
    .date-group-2{background:#444;color:#fff}
    .is-green{background:rgba(76,175,80,.7);color:#fff;border-radius:6px;padding:4px}
    .is-yellow{background:rgba(255,193,7,.7);color:#000;border-radius:6px;padding:4px}
    .is-red{background:rgba(244,67,54,.7);color:#fff;border-radius:6px;padding:4px}
    .info-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 20px;
      height: 20px;
      background-color: #2196f3;
      color: white;
      border-radius: 50%;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 8px;
    }
    
    .modal-section .section {
      margin-bottom: 20px;
    }

    .modal-section .section h3 {
      color: var(--accent);
      margin-bottom: 12px;
      font-size: 1.1rem;
    }

    .modal-section .section p {
      margin: 12px 0 0;
      padding: 8px 12px;
      background-color: #fff8e1;
      border-radius: 6px;
      border-left: 3px solid var(--accent);
    }

    .modal-section hr {
      margin: 20px 0;
      border: 0;
      border-top: 1px solid #ddd;
    }
    
    .analysis-result {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    
    .analysis-item {
      padding: 10px;
      border-radius: 8px;
      background: #f5f5f5;
      text-align: center;
    }
    
.analysis-value {
  font-weight: bold;
  margin-top: 5px;
  font-family: 'Roboto', Arial, sans-serif; /* ADD THIS LINE */
}

/* ADD THIS NEW STYLE FOR RUNNING SCORECARD SPECIFICALLY */
.running-scorecard-eq {
  font-family: 'Roboto', Arial, sans-serif !important;
  font-weight: 900 !important; /* Extra bold for emphasis */
  font-size: 1.1rem !important;
}

/* ADD THIS FOR THE RUNNING SCORECARD LABEL */
.running-scorecard-label {
  font-family: 'Roboto', Arial, sans-serif !important;
  font-weight: 700 !important; /* Bold for the label */
}
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="title-group">
        <div class="ham" id="ham_advopt" title="Advance Options (click)">
          <div class="lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
          </div>
        </div>
        <h1>Performance Tracker</h1>
      </div>
      <div class="header-actions">
        <button id="perfToggle" class="btn toggle-inactive" title="Performance EQ Toggle">PERF EQ INACTIVE</button>
      </div>
    </div>

    <div class="targets-section">
      <!-- Row 1 -->
      <div class="target-inputs">
        <label>Target CSAT:
          <input type="number" id="targetCSAT" step="0.01" value="4.92" min="1" max="5">
        </label>
        <label>Target FCR (%):
          <input type="number" id="targetFCR" step="1" value="85" min="0" max="100">
        </label>
        <label>Target AHT (sec):
          <input type="number" id="targetAHT" step="1" value="0" min="0">
        </label>
      </div>

      <!-- Row 2 -->
      <div class="target-inputs">
        <label>Running AHT (sec):
          <input type="number" id="RunningAHT" step="1" value="0" min="0">
        </label>
        <label>Total Case Interactions:
          <input type="number" id="TotalCI" step="1" value="0">
        </label>
        <label>Remaining Work Days:
          <input type="number" id="RWD" step="1" value="0">
        </label>
        <span class="info-icon" onclick="showRatioModal()">i</span>
      </div>
    </div>

    <div class="table-container">
      <table border="1">
        <thead>
          <tr>
            <th>Date</th>
            <th>Interaction ID</th>
            <th>KR</th>
            <th>CR</th>
            <th>IS</th>
            <th>FCR</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>

    <div class="results">
      <div class="result-row">
        <div id="csatResult" class="result-item">
          Est. Running CSAT: <span id="tsatBox" style="margin-left:6px">0.000</span>
        </div>
        <div id="fcrResult" class="result-item">
          Est. Running FCR: <span id="tfcrBox" style="margin-left:6px">0%</span>
        </div>
      </div>

      <div class="result-row">
        <div class="result-item"><span id="dsatRatio">Required CSAT: 0</span></div>
        <div class="result-item"><span id="fcrRatio">Required FCR: 0</span></div>
      </div>



<!-- AHT metrics row -->
<div class="result-row">
  <div class="result-item"><span id="requiredAHT">Target Minutes per case: 0</span></div>
  <div class="result-item"><span id="targetAHTPerCase">Forecasted Remaining Cases: 0</span></div>
</div>

      <button class="analysis-btn" onclick="showAnalysisModal()">Show Analysis</button>
    </div>
  </div>

  <div id="confirmModal" class="modal"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Confirm Deletion</h2>
      <span class="close" onclick="closeModal('confirmModal')">&times;</span>
    </div>
    <p>Reminder: Row will be deleted permanently.</p>
    <div style="display:flex;justify-content:center;gap:10px;margin-top:12px">
      <button class="btn primary" id="proceedDelete">PROCEED</button>
      <button class="btn secondary" id="cancelDelete">CANCEL</button>
    </div>
  </div></div>

  <div id="ratioModal" class="modal"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Calculation Guide</h2>
      <span class="close" onclick="closeModal('ratioModal')">&times;</span>
    </div>
    <div class="modal-section">
      <h3>Estimated Running CSAT Calculation</h3>
      <div class="ratio-explanation">
        <p>Each interaction receives an Interaction Score based on available ratings. If both KR and CR are provided: (KR + CR) ÷ 2. If only one rating is provided (other is empty or 0), the available rating is used directly. Empty or zero values are excluded from calculations entirely. The Running CSAT is the average of all valid Interaction Scores.</p>
        <p><strong>Example:</strong><br>
        Interaction 1: KR=5, CR=5 → Score: 5.0<br>
        Interaction 2: KR=4, CR=0 → Score: 4.0 (CR=0 excluded)<br>
        Interaction 3: KR=0, CR=3 → Score: 3.0 (KR=0 excluded)<br>
        <strong>Running CSAT = (5.0 + 4.0 + 3.0) ÷ 3 = 4.00</strong></p>
      </div>
    </div>
    <div class="modal-section">
      <h3>Estimated Running FCR Calculation</h3>
      <div class="ratio-explanation">
        <p>Only interactions with explicit YES/NO responses are counted. Percentage = (YES responses) ÷ (Total valid responses) × 100. Empty or unselected FCR values are excluded from calculation.</p>
      </div>
    </div>
    <div class="modal-section">
      <h3>PERF EQ - Performance Equalizer</h3>
      <div class="ratio-explanation">
        <p>PERF EQ automatically manages performance targets based on current metrics and predefined performance tiers. When activated, manual target input is disabled and targets are dynamically set to the next achievable performance tier using threshold values from the Performance Table.</p>
        <p><strong>Example:</strong><br>
        Current Running CSAT: 4.78<br>
        Performance Tiers: Satisfactory (4.70), Average (4.80), Exceptional (4.90)<br>
        <strong>PERF EQ automatically sets Target CSAT to 4.80</strong> - the next sequential tier</p>
        <p>Access Performance Table via: ☰ → Performance Table</p>
      </div>
    </div>
    <div class="modal-section">
      <h3>Required CSAT/FCR Calculation</h3>
      <div class="ratio-explanation">
        <p>Quantifies the effort required to achieve current targets when performance is below benchmark. Determines minimum number of perfect interactions (5/5 for CSAT, YES for FCR) needed to reach target. Only appears when current performance is below target threshold.</p>
        <p><strong>Example:</strong> Current Running CSAT: 4.60 | Target: 4.80 → <strong>Required CSAT: 4</strong> indicates need for 4 consecutive perfect scores</p>
      </div>
    </div>
  </div></div>

  <div id="analysisModal" class="modal"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Detailed Analysis</h2>
      <span class="close" onclick="closeModal('analysisModal')">&times;</span>
    </div>
    <div class="analysis-result">
      <!-- Scorecard EQ items -->
      <div class="analysis-item">
        <div>CSAT Scorecard EQ</div>
        <div class="analysis-value" id="analysisCsatScorecard">N/A</div>
      </div>
      <div class="analysis-item">
        <div>FCR Scorecard EQ</div>
        <div class="analysis-value" id="analysisFcrScorecard">N/A</div>
      </div>
      
      <!-- NEW: AHT Scorecard EQ -->
      <div class="analysis-item">
        <div>AHT Scorecard EQ</div>
        <div class="analysis-value" id="analysisAhtScorecard">N/A</div>
      </div>
      
<div class="analysis-item">
  <!-- ADD running-scorecard-label CLASS TO THE LABEL DIV -->
  <div class="running-scorecard-label">RUNNING SCORECARD EQUIVALENT</div>
  <!-- ADD running-scorecard-eq CLASS TO THE VALUE DIV -->
  <div class="analysis-value running-scorecard-eq" id="analysisRunningScorecard">N/A</div>
</div>
      
      <!-- Original items -->
      <div class="analysis-item">
        <div>Est. Running CSAT</div>
        <div class="analysis-value" id="analysisTsat">0.0</div>
      </div>
      <div class="analysis-item">
        <div>Est. Running FCR</div>
        <div class="analysis-value" id="analysisTfcr">0.0%</div>
      </div>
      <div class="analysis-item">
        <div>Required CSAT</div>
        <div class="analysis-value" id="analysisReqCsat">0</div>
      </div>
      <div class="analysis-item">
        <div>Required FCR</div>
        <div class="analysis-value" id="analysisReqFcr">0</div>
      </div>
<!-- AHT metrics -->
<div class="analysis-item">
  <div>Target Minutes per case</div>
  <div class="analysis-value" id="analysisReqAHT">0</div>
</div>
<div class="analysis-item">
  <div>Forecasted Remaining Cases</div>
  <div class="analysis-value" id="analysisAHTPerCase">0</div>
</div>
    </div>
  </div></div>

  <div id="advanceModal" class="modal"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Advance Options</h2>
      <span class="close" onclick="closeModal('advanceModal')">&times;</span>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px">
      <button class="btn primary" onclick="showPerfTableModal()">Performance Table</button>
      <button class="btn primary" onclick="showTimeConverterModal()">Time Converter</button>
      <button class="btn secondary" onclick="downloadData()">Save Data</button>
      <button class="btn secondary" onclick="confirmLoad()">Load Data</button>
      <button class="btn secondary" onclick="resetValues()">Reset Values</button>
      <input type="file" id="uploadFileHeader" style="display:none" accept=".json">
      <div style="margin-top:6px" class="small-note">Performance Table can auto-assign Target CSAT and FCR based on current running scores when enabled.</div>
    </div>
  </div></div>

  <div id="perfModal" class="modal"><div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title">Performance Table</h2>
      <span class="close" onclick="closeModal('perfModal')">&times;</span>
    </div>
    <div class="modal-section">
      <table class="perf-table" id="perfTable">
        <thead>
          <tr>
            <th>Performance Level</th>
            <th>Target CSAT Threshold</th>
            <th>CSAT Scorecard Value (%)</th>
            <th>Target FCR Threshold (%)</th>
            <th>FCR Scorecard Value (%)</th>
            <th>Target AHT Threshold (sec)</th>
            <th>AHT Scorecard Value (%)</th>
          </tr>
        </thead>
        <tbody>
          <tr data-row="exceptional">
            <td>Exceptional (Max)</td>
            <td><input type="number" step="0.01" class="perf-target-csat" data-tier="exceptional" /></td>
            <td><input type="number" step="0.01" class="perf-csat-score" data-tier="exceptional" /></td>
            <td><input type="number" step="1" class="perf-target-fcr" data-tier="exceptional" /></td>
            <td><input type="number" step="0.01" class="perf-fcr-score" data-tier="exceptional" /></td>
            <td><input type="number" step="1" class="perf-target-aht" data-tier="exceptional" /></td>
            <td><input type="number" step="0.01" class="perf-aht-score" data-tier="exceptional" /></td>
          </tr>
          <tr data-row="average">
            <td>Average (T2)</td>
            <td><input type="number" step="0.01" class="perf-target-csat" data-tier="average" /></td>
            <td><input type="number" step="0.01" class="perf-csat-score" data-tier="average" /></td>
            <td><input type="number" step="1" class="perf-target-fcr" data-tier="average" /></td>
            <td><input type="number" step="0.01" class="perf-fcr-score" data-tier="average" /></td>
            <td><input type="number" step="1" class="perf-target-aht" data-tier="average" /></td>
            <td><input type="number" step="0.01" class="perf-aht-score" data-tier="average" /></td>
          </tr>
          <tr data-row="satisfactory">
            <td>Satisfactory (T1)</td>
            <td><input type="number" step="0.01" class="perf-target-csat" data-tier="satisfactory" /></td>
            <td><input type="number" step="0.01" class="perf-csat-score" data-tier="satisfactory" /></td>
            <td><input type="number" step="1" class="perf-target-fcr" data-tier="satisfactory" /></td>
            <td><input type="number" step="0.01" class="perf-fcr-score" data-tier="satisfactory" /></td>
            <td><input type="number" step="1" class="perf-target-aht" data-tier="satisfactory" /></td>
            <td><input type="number" step="0.01" class="perf-aht-score" data-tier="satisfactory" /></td>
          </tr>
        </tbody>
      </table>
      <div class="small-note" style="margin-top:10px">Performance thresholds are automatically saved when changed.</div>
    </div>
  </div></div>

  <div id="loadConfirmModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Confirm Load</h2>
        <span class="close" onclick="closeModal('loadConfirmModal')">&times;</span>
      </div>
      <p>Warning: Loading a file will overwrite your current table and targets.</p>
      <div style="display:flex;justify-content:center;gap:10px;margin-top:12px">
        <button class="btn primary" id="proceedLoad">PROCEED</button>
        <button class="btn secondary" onclick="closeModal('loadConfirmModal')">CANCEL</button>
      </div>
    </div>
  </div>

  <div id="resetModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Reset Values</h2>
        <span class="close" onclick="closeModal('resetModal')">&times;</span>
      </div>
      <div class="modal-section">
        <p>Are you sure you want to reset all current table entries to blank defaults?</p>
        <p class="small-note">This will NOT change saved Performance Table configuration.</p>
      </div>
      <div style="display:flex;justify-content:center;gap:10px;margin-top:12px">
        <button class="btn primary" onclick="confirmReset()">CONFIRM</button>
        <button class="btn secondary" onclick="closeModal('resetModal')">CANCEL</button>
      </div>
    </div>
  </div>

  <!-- Time Converter Modal -->
  <div id="timeConverterModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Time Converter</h2>
        <span class="close" onclick="closeModal('timeConverterModal')">&times;</span>
      </div>
      
      <div class="modal-section">
        <!-- Minutes + Seconds to Seconds -->
        <div class="section">
          <h3>Minutes to Seconds</h3>
          <div class="target-inputs">
            <label>Minutes:
              <input type="number" id="minutesInput" min="0" placeholder="0">
            </label>
            <label>Seconds:
              <input type="number" id="extraSecondsInput" min="0" placeholder="0">
            </label>
          </div>
          <p><strong>Total Seconds:</strong> <span id="convertedSeconds">0</span></p>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #ddd;">

        <!-- Seconds to Minutes -->
        <div class="section">
          <h3>Seconds to Minutes</h3>
          <div class="target-inputs">
            <label>Seconds:
              <input type="number" id="secondsInput" min="0" placeholder="0">
            </label>
          </div>
          <p><strong>Result:</strong> <span id="convertedMinutes">0</span> minutes <span id="convertedRemainder">0</span> seconds</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    const tableBody = document.getElementById("tableBody");
    const targetCSAT = document.getElementById("targetCSAT");
    const targetFCR = document.getElementById("targetFCR");
    const targetAHT = document.getElementById("targetAHT");
    const RunningAHT = document.getElementById("RunningAHT");
    const TotalCI = document.getElementById("TotalCI");
    const RWD = document.getElementById("RWD");
    const perfToggle = document.getElementById("perfToggle");
    const uploadFileHeader = document.getElementById("uploadFileHeader");
    let rowToDelete = null;
    let perfEnabled = false;

    const DEFAULT_PERF = {
      exceptional: { csat: 4.90, csatScore: 45.00, fcr: 80, fcrScore: 35.00, aht: 1509, ahtScore: 20.00 },
      average:     { csat: 4.80, csatScore: 39.75, fcr: 75, fcrScore: 29.75, aht: 1643, ahtScore: 17.50 },
      satisfactory:{ csat: 4.70, csatScore: 36.25, fcr: 70, fcrScore: 26.25, aht: 1763, ahtScore: 15.50 }
    };
    const PERF_STORAGE_KEY = 'perfTableConfig_v2';

    function loadPerfConfig(){
      try{
        const raw = localStorage.getItem(PERF_STORAGE_KEY);
        if(!raw) return JSON.parse(JSON.stringify(DEFAULT_PERF));
        const parsed = JSON.parse(raw);
        return {...JSON.parse(JSON.stringify(DEFAULT_PERF)), ...parsed};
      }catch(e){
        return JSON.parse(JSON.stringify(DEFAULT_PERF));
      }
    }
    
    function savePerfConfig(cfg){
      localStorage.setItem(PERF_STORAGE_KEY, JSON.stringify(cfg));
    }
    
    function populatePerfModal(){
      const cfg = loadPerfConfig();
      document.querySelectorAll('.perf-target-csat').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].csat;
      });
      document.querySelectorAll('.perf-csat-score').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].csatScore;
      });
      document.querySelectorAll('.perf-target-fcr').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].fcr;
      });
      document.querySelectorAll('.perf-fcr-score').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].fcrScore;
      });
      document.querySelectorAll('.perf-target-aht').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].aht;
      });
      document.querySelectorAll('.perf-aht-score').forEach(inp=>{
        const tier = inp.dataset.tier;
        inp.value = cfg[tier].ahtScore;
      });
    }
    
    function formatTargetCSAT(){
      let val = parseFloat(targetCSAT.value);
      targetCSAT.value = !isNaN(val) ? val.toFixed(2) : "0.00";
    }
    
    formatTargetCSAT();
    targetCSAT.addEventListener("change", ()=>{ formatTargetCSAT(); calculate(); });
    targetFCR.addEventListener("change", calculate);
    targetAHT.addEventListener("change", calculate);
    RunningAHT.addEventListener("change", calculate);
    TotalCI.addEventListener("change", calculate);
    RWD.addEventListener("change", calculate);

    function initializeTable(){
      for(let i=0;i<5;i++) addRow(null, true);
      updateRemoveButtons();
      calculate();
    }
    
    function addRow(clickedButton, isInitial=false){
      const currentRow = clickedButton ? clickedButton.closest('tr') : null;
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td><input type="date"></td>
        <td><input type="text" placeholder="Enter ID" maxlength="15"></td>
        <td><input type="number" min="1" max="5" step="1" placeholder="0"></td>
        <td><input type="number" min="1" max="5" step="1" placeholder="0"></td>
        <td class="is">0</td>
        <td>
          <select>
            <option value="">Empty</option>
            <option value="YES">YES</option>
            <option value="NO">NO</option>
          </select>
        </td>
        <td class="actions">
          <button class="add-btn">ADD</button>
          <button class="remove-btn">REMOVE</button>
        </td>
      `;
      if(currentRow) tableBody.insertBefore(newRow, currentRow.nextSibling); else tableBody.appendChild(newRow);
      const addBtn = newRow.querySelector('.add-btn');
      const removeBtn = newRow.querySelector('.remove-btn');
      addBtn.onclick = ()=> addRow(addBtn);
      removeBtn.onclick = ()=> { rowToDelete = newRow; showModal('confirmModal'); };
      updateRemoveButtons();
      attachEvents(newRow);
      if(!isInitial){ calculate(); setTimeout(()=> newRow.scrollIntoView({behavior:'smooth',block:'nearest'}),100); }
    }
    
    function updateRemoveButtons(){
      const rows = tableBody.querySelectorAll('tr');
      const removeButtons = tableBody.querySelectorAll('.remove-btn');
      if(rows.length === 1){
        removeButtons[0].classList.add('disabled');
        removeButtons[0].onclick = null;
      } else {
        removeButtons.forEach(btn=>{
          btn.classList.remove('disabled');
          btn.onclick = ()=> { rowToDelete = btn.closest('tr'); showModal('confirmModal'); };
        });
      }
    }
    
    document.getElementById("proceedDelete").addEventListener("click", ()=>{
      if(rowToDelete){ rowToDelete.remove(); rowToDelete = null; closeModal('confirmModal'); updateRemoveButtons(); calculate(); }
    });
    
    document.getElementById("cancelDelete").addEventListener("click", ()=> closeModal('confirmModal'));

    function attachEvents(row){
      let krInput = row.cells[2].querySelector("input");
      let crInput = row.cells[3].querySelector("input");
      let fcrSelect = row.cells[5].querySelector("select");
      [krInput, crInput].forEach(input=>{
        input.addEventListener("input", ()=>{ validateAndStyleScoreInput(input); calculate(); });
        input.addEventListener("change", ()=>{ validateAndStyleScoreInput(input); calculate(); });
        input.addEventListener("blur", ()=> validateAndStyleScoreInput(input));
      });
      fcrSelect.addEventListener("change", ()=>{ styleFCRSelect(fcrSelect); calculate(); });
      row.querySelectorAll("td input[type=date], td input[type=text]").forEach(el=>{
        el.addEventListener("input", calculate); el.addEventListener("change", calculate);
      });
    }
    
    function validateAndStyleScoreInput(input){
      if(!input) return;
      let raw = input.value.trim();
      if(!/^[1-5]$/.test(raw)){
        input.value = "";
        input.style.background = ""; input.style.color=""; input.style.fontWeight="";
        return;
      }
      let n = parseInt(raw,10);
      if(n===5) { input.style.background = "#4caf50"; input.style.color="#fff"; input.style.fontWeight="700"; }
      else if(n===4){ input.style.background = "#ffeb3b"; input.style.color="#000"; input.style.fontWeight="700"; }
      else { input.style.background = "#f44336"; input.style.color="#fff"; input.style.fontWeight="700"; }
    }
    
    function styleFCRSelect(select){
      if(!select) return;
      select.style.background=""; select.style.color=""; select.style.fontWeight="";
      if(select.value==="YES"){ select.style.background="#4caf50"; select.style.color="#fff"; select.style.fontWeight="700"; }
      else if(select.value==="NO"){ select.style.background="#f44336"; select.style.color="#fff"; select.style.fontWeight="700"; }
    }
    
    function showModal(id){ const el=document.getElementById(id); if(el){ el.classList.add('show'); el.style.display='flex'; } }
    function closeModal(id){ const el=document.getElementById(id); if(el){ el.classList.remove('show'); el.style.display='none'; } }
    function showRatioModal(){ showModal('ratioModal'); }
    function showAnalysisModal(){ calculate(); showModal('analysisModal'); }

    function calculateCsatScorecard(tsat) {
      const cfg = loadPerfConfig();
      let level = "FAIL";
      let score = 0;
      let color = "red";
      
      if (tsat >= cfg.exceptional.csat) {
        level = "EXCEPTIONAL (MAX)";
        score = cfg.exceptional.csatScore;
        color = "purple";
      } else if (tsat >= cfg.average.csat) {
        level = "AVERAGE (T2)";
        score = cfg.average.csatScore;
        color = "green";
      } else if (tsat >= cfg.satisfactory.csat) {
        level = "SATISFACTORY (T1)";
        score = cfg.satisfactory.csatScore;
        color = "orange";
      }
      
      return { level, score, color };
    }

    function calculateFcrScorecard(tfcr) {
      const cfg = loadPerfConfig();
      let level = "FAIL";
      let score = 0;
      let color = "red";
      
      if (tfcr >= cfg.exceptional.fcr) {
        level = "EXCEPTIONAL (MAX)";
        score = cfg.exceptional.fcrScore;
        color = "purple";
      } else if (tfcr >= cfg.average.fcr) {
        level = "AVERAGE (T2)";
        score = cfg.average.fcrScore;
        color = "green";
      } else if (tfcr >= cfg.satisfactory.fcr) {
        level = "SATISFACTORY (T1)";
        score = cfg.satisfactory.fcrScore;
        color = "orange";
      }
      
      return { level, score, color };
    }

    function calculateAhtScorecard(aht) {
      const cfg = loadPerfConfig();
      let level = "FAIL";
      let score = 0;
      let color = "red";
      
      if (aht <= cfg.exceptional.aht) {
        level = "EXCEPTIONAL (MAX)";
        score = cfg.exceptional.ahtScore;
        color = "purple";
      } else if (aht <= cfg.average.aht) {
        level = "AVERAGE (T2)";
        score = cfg.average.ahtScore;
        color = "green";
      } else if (aht <= cfg.satisfactory.aht) {
        level = "SATISFACTORY (T1)";
        score = cfg.satisfactory.ahtScore;
        color = "orange";
      }
      
      return { level, score, color };
    }

function calculateRunningScorecard(csatScorecard, fcrScorecard, ahtScorecard) {
  const totalScore = csatScorecard.score + fcrScorecard.score + ahtScorecard.score;
  
  let level = "FAIL";
  let color = "red";
  
  if (totalScore >= 95) {
    level = "EXCEPTIONAL (MAX)";
    color = "purple";
  } else if (totalScore >= 85) {
    level = "AVERAGE (T2)";
    color = "green";
  } else if (totalScore >= 75) {
    level = "SATISFACTORY (T1)";
    color = "orange";
  }
  
  return { level, totalScore, color };
}

    function calculate(){
      const rows = Array.from(tableBody.rows);
      let totalIS = 0, count = 0;
      let fcrYesCount = 0, fcrTotalCount = 0;
      
      rows.forEach(row=>{
        const krInput = row.cells[2].querySelector("input");
        const crInput = row.cells[3].querySelector("input");
        const fcrSelect = row.cells[5].querySelector("select");
        validateAndStyleScoreInput(krInput);
        validateAndStyleScoreInput(crInput);
        styleFCRSelect(fcrSelect);
      });
      
      rows.forEach(row=>{
        const krVal = row.cells[2].querySelector("input").value;
        const crVal = row.cells[3].querySelector("input").value;
        const kr = /^[1-5]$/.test(krVal) ? parseInt(krVal,10) : null;
        const cr = /^[1-5]$/.test(crVal) ? parseInt(crVal,10) : null;
        const fcrSelect = row.cells[5].querySelector("select");
        const fcr = fcrSelect ? fcrSelect.value : "";
        const isCell = row.cells[4];
        let isValue = 0; let localCount = 0;
        
        if(kr!==null){ isValue += kr; localCount++; }
        if(cr!==null){ isValue += cr; localCount++; }
        
        if(localCount>0){
          const rowAvg = isValue / localCount;
          isCell.textContent = rowAvg.toFixed(1);
          isCell.className = "is";
          if(rowAvg >= 4) isCell.classList.add("is-green");
          else if(rowAvg >= 3) isCell.classList.add("is-yellow");
          else if(rowAvg > 0) isCell.classList.add("is-red");
          totalIS += isValue; count += localCount;
        }else{
          isCell.textContent = "0.0"; isCell.className = "is";
        }
        
        if(fcr === "YES" || fcr === "NO"){
          fcrTotalCount++;
          if(fcr === "YES") fcrYesCount++;
        }
      });
      
      const tsat = count ? (totalIS / count) : 0;
      let tsatDisplay = tsat ? tsat.toFixed(3).replace(/\.?0+$/,"") : "0.000";
      const tfcr = fcrTotalCount ? ((fcrYesCount / fcrTotalCount) * 100) : 0;
      const tfcrDisplay = fcrTotalCount ? tfcr.toFixed(3).replace(/\.?0+$/,"") : "0.000";
      const runningAHTVal = parseFloat(RunningAHT.value) || 0;
      
      document.getElementById("tsatBox").textContent = tsatDisplay;
      document.getElementById("tfcrBox").textContent = tfcrDisplay + "%";
      
      const targetCSATVal = parseFloat(targetCSAT.value) || 4.9;
      const targetFCRVal = parseFloat(targetFCR.value) || 70;
      
      // Update the visual state of the result boxes
      const csatBoxEl = document.getElementById("csatResult");
      const fcrBoxEl = document.getElementById("fcrResult");
      csatBoxEl.classList.remove("met","miss");
      fcrBoxEl.classList.remove("met","miss");
      if(tsat >= targetCSATVal) csatBoxEl.classList.add("met"); else csatBoxEl.classList.add("miss");
      if(tfcr >= targetFCRVal) fcrBoxEl.classList.add("met"); else fcrBoxEl.classList.add("miss");
      
      // Calculate required values
      let requiredCSATText = tsat >= targetCSATVal ? "PASSED" : 0;
      if(requiredCSATText === 0){
        let extra5s = 0, tempTotal = totalIS, tempCount = count;
        while((tempTotal + extra5s*5)/(tempCount + extra5s) < targetCSATVal) extra5s++;
        requiredCSATText = extra5s;
      }
      
      let requiredFCRText = tfcr >= targetFCRVal ? "PASSED" : 0;
      if(requiredFCRText === 0){
        let extraYES = 0, tempYes = fcrYesCount, tempTotal = fcrTotalCount;
        while(((tempYes + extraYES)/(tempTotal + extraYES)*100) < targetFCRVal) extraYES++;
        requiredFCRText = extraYES;
      }
      
      // Update the required boxes with visual feedback
      const dsatRatioEl = document.getElementById("dsatRatio");
      const fcrRatioEl = document.getElementById("fcrRatio");
      
      dsatRatioEl.textContent = `Required CSAT: ${requiredCSATText}`;
      fcrRatioEl.textContent = `Required FCR: ${requiredFCRText}`;
      
      // Add visual styling to required boxes
      dsatRatioEl.parentElement.classList.remove("met", "miss");
      fcrRatioEl.parentElement.classList.remove("met", "miss");
      
      if(requiredCSATText === "PASSED") {
        dsatRatioEl.parentElement.classList.add("met");
      } else {
        dsatRatioEl.parentElement.classList.add("miss");
      }
      
      if(requiredFCRText === "PASSED") {
        fcrRatioEl.parentElement.classList.add("met");
      } else {
        fcrRatioEl.parentElement.classList.add("miss");
      }
      
      // Remove individual text coloring
      dsatRatioEl.style.color = "";
      fcrRatioEl.style.color = "";
      
      const targetMinutesPerCaseResult = calculateTargetMinutesPerCase();
      const targetSecondsPerCaseResult = calculateTargetSecondsPerCase();
      
      document.getElementById("requiredAHT").textContent = `Target Minutes per case: ${targetMinutesPerCaseResult}`;
document.getElementById("targetAHTPerCase").textContent = `Forecasted Remaining Cases: ${targetSecondsPerCaseResult}`;
      
      // Style the AHT result items with green/red boxes
      const requiredAHTEl = document.getElementById("requiredAHT").parentElement;
      const targetAHTPerCaseEl = document.getElementById("targetAHTPerCase").parentElement;

      requiredAHTEl.classList.remove("met", "miss");
      targetAHTPerCaseEl.classList.remove("met", "miss");

      if (targetMinutesPerCaseResult === "PASSED") {
        requiredAHTEl.classList.add("met");
      } else if (targetMinutesPerCaseResult === "MISSING_VAL") {
        requiredAHTEl.classList.add("miss");
      } else {
        const runningAHTVal = parseFloat(RunningAHT.value) || 0;
        const targetAHTVal = parseFloat(targetAHT.value) || 0;
        if (runningAHTVal <= targetAHTVal) {
          requiredAHTEl.classList.add("met");
        } else {
          requiredAHTEl.classList.add("miss");
        }
      }

      if (targetSecondsPerCaseResult === "PASSED") {
        targetAHTPerCaseEl.classList.add("met");
      } else if (targetSecondsPerCaseResult === "MISSING_VAL") {
        targetAHTPerCaseEl.classList.add("miss");
      } else {
        const runningAHTVal = parseFloat(RunningAHT.value) || 0;
        const targetAHTVal = parseFloat(targetAHT.value) || 0;
        if (runningAHTVal <= targetAHTVal) {
          targetAHTPerCaseEl.classList.add("met");
        } else {
          targetAHTPerCaseEl.classList.add("miss");
        }
      }
      
      document.getElementById("analysisTsat").textContent = tsatDisplay;
      document.getElementById("analysisTsat").style.color = tsat >= targetCSATVal ? "green" : "red";
      document.getElementById("analysisTfcr").textContent = tfcrDisplay + "%";
      document.getElementById("analysisTfcr").style.color = tfcr >= targetFCRVal ? "green" : "red";

      // Add scorecard calculations
      const csatScorecard = calculateCsatScorecard(tsat);
      const fcrScorecard = calculateFcrScorecard(tfcr);
      const ahtScorecard = calculateAhtScorecard(runningAHTVal);
      const runningScorecard = calculateRunningScorecard(csatScorecard, fcrScorecard, ahtScorecard);

      const csatScorecardEl = document.getElementById("analysisCsatScorecard");
      csatScorecardEl.innerHTML = `<span style="color: ${csatScorecard.color}; font-weight: bold">${csatScorecard.level}</span> | ${csatScorecard.score}%`;
      csatScorecardEl.style.fontWeight = "bold";

      const fcrScorecardEl = document.getElementById("analysisFcrScorecard");
      fcrScorecardEl.innerHTML = `<span style="color: ${fcrScorecard.color}; font-weight: bold">${fcrScorecard.level}</span> | ${fcrScorecard.score}%`;
      fcrScorecardEl.style.fontWeight = "bold";

      const ahtScorecardEl = document.getElementById("analysisAhtScorecard");
      ahtScorecardEl.innerHTML = `<span style="color: ${ahtScorecard.color}; font-weight: bold">${ahtScorecard.level}</span> | ${ahtScorecard.score}%`;
      ahtScorecardEl.style.fontWeight = "bold";

      const runningScorecardEl = document.getElementById("analysisRunningScorecard");
      runningScorecardEl.innerHTML = `<span style="color: ${runningScorecard.color}; font-weight: bold">${runningScorecard.level}</span> | ${runningScorecard.totalScore}%`;
      runningScorecardEl.style.fontWeight = "bold";

      document.getElementById("analysisReqCsat").textContent = requiredCSATText;
      document.getElementById("analysisReqFcr").textContent = requiredFCRText;
      
      const analysisReqCsat = document.getElementById("analysisReqCsat");
      analysisReqCsat.textContent = requiredCSATText;
      analysisReqCsat.style.color = (requiredCSATText === "PASSED") ? "green" : "red";

      const analysisReqFcr = document.getElementById("analysisReqFcr");
      analysisReqFcr.textContent = requiredFCRText;
      analysisReqFcr.style.color = (requiredFCRText === "PASSED") ? "green" : "red";
      
      if(perfEnabled){
        autoAssignTargets(tsat, tfcr, RunningAHT.value);
      }
      
      let lastDate = null; let currentGroup = 1;
      Array.from(tableBody.rows).forEach(row=>{
        const dateVal = row.cells[0].querySelector("input").value;
        row.classList.remove("date-group-1","date-group-2");
        if(dateVal){
          if(dateVal !== lastDate){ currentGroup = currentGroup === 1 ? 2 : 1; lastDate = dateVal; }
          row.classList.add(`date-group-${currentGroup}`);
        } else {
          row.classList.add(`date-group-${currentGroup}`);
        }
      });
      
      document.getElementById("analysisReqAHT").textContent = targetMinutesPerCaseResult;
      document.getElementById("analysisAHTPerCase").textContent = targetSecondsPerCaseResult;
      
      // Style the analysis values with green/red text
      const analysisReqAHT = document.getElementById("analysisReqAHT");
      const analysisAHTPerCase = document.getElementById("analysisAHTPerCase");
      
      analysisReqAHT.style.color = "";
      analysisAHTPerCase.style.color = "";
      
      if (targetMinutesPerCaseResult === "PASSED") {
        analysisReqAHT.style.color = "green";
        analysisReqAHT.style.fontWeight = "bold";
      } else if (targetMinutesPerCaseResult === "MISSING_VAL") {
        analysisReqAHT.style.color = "red";
        analysisReqAHT.style.fontWeight = "bold";
      } else {
        const runningAHTVal = parseFloat(RunningAHT.value) || 0;
        const targetAHTVal = parseFloat(targetAHT.value) || 0;
        analysisReqAHT.style.color = runningAHTVal <= targetAHTVal ? "green" : "red";
        analysisReqAHT.style.fontWeight = "bold";
      }
      
      if (targetSecondsPerCaseResult === "PASSED") {
        analysisAHTPerCase.style.color = "green";
        analysisAHTPerCase.style.fontWeight = "bold";
      } else if (targetSecondsPerCaseResult === "MISSING_VAL") {
        analysisAHTPerCase.style.color = "red";
        analysisAHTPerCase.style.fontWeight = "bold";
      } else {
        const runningAHTVal = parseFloat(RunningAHT.value) || 0;
        const targetAHTVal = parseFloat(targetAHT.value) || 0;
        analysisAHTPerCase.style.color = runningAHTVal <= targetAHTVal ? "green" : "red";
        analysisAHTPerCase.style.fontWeight = "bold";
      }
    }

    function findNextTierTarget(currentScore, thresholds) {
      const sortedThresholds = [...thresholds].sort((a, b) => a - b);
      for (const threshold of sortedThresholds) {
        if (currentScore < threshold) {
          return threshold;
        }
      }
      return sortedThresholds[sortedThresholds.length - 1];
    }

    function autoAssignTargets(tsat, tfcr, runningAHT){
      const cfg = loadPerfConfig();
      const tsatNum = parseFloat(tsat) || 0;
      const tfcrNum = parseFloat(tfcr) || 0;
      const runningAHTNum = parseFloat(runningAHT) || 0;
      
      const csatThresholds = [
        cfg.exceptional.csat,
        cfg.average.csat,
        cfg.satisfactory.csat
      ];
      const fcrThresholds = [
        cfg.exceptional.fcr,
        cfg.average.fcr,
        cfg.satisfactory.fcr
      ];
      const ahtThresholds = [
        cfg.exceptional.aht,
        cfg.average.aht,
        cfg.satisfactory.aht
      ];
      
      const nextCSATTarget = findNextTierTarget(tsatNum, csatThresholds);
      const nextFCRTarget = findNextTierTarget(tfcrNum, fcrThresholds);
      const nextAHTTarget = findNextTierTargetForAHT(runningAHTNum, ahtThresholds);
      
      targetCSAT.value = nextCSATTarget.toFixed(2);
      targetFCR.value = nextFCRTarget;
      targetAHT.value = nextAHTTarget;
    }

    function setPerfEnabled(enabled){
      perfEnabled = enabled;
      if(perfEnabled){
        perfToggle.classList.remove('toggle-inactive'); 
        perfToggle.classList.add('toggle-active');
        perfToggle.textContent = "PERF EQ ACTIVE";
        targetCSAT.setAttribute('disabled','disabled'); 
        targetFCR.setAttribute('disabled','disabled');
        targetAHT.setAttribute('disabled','disabled');
        calculate();
      }else{
        perfToggle.classList.remove('toggle-active'); 
        perfToggle.classList.add('toggle-inactive');
        perfToggle.textContent = "PERF EQ INACTIVE";
        targetCSAT.removeAttribute('disabled'); 
        targetFCR.removeAttribute('disabled');
        targetAHT.removeAttribute('disabled');
      }
    }
    
    perfToggle.addEventListener('click', ()=>{ setPerfEnabled(!perfEnabled); });

    function showPerfTableModal(){
      populatePerfModal();
      showModal('perfModal');
    }

    function findNextTierTargetForAHT(currentAHT, thresholds) {
      // For AHT, lower is better, so we need to find the next lower threshold
      const sortedThresholds = [...thresholds].sort((a, b) => b - a); // Sort descending
      for (const threshold of sortedThresholds) {
        if (currentAHT > threshold) {
          return threshold;
        }
      }
      return sortedThresholds[sortedThresholds.length - 1];
    }

    // Auto-save performance table changes
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.perf-target-csat, .perf-csat-score, .perf-target-fcr, .perf-fcr-score, .perf-target-aht, .perf-aht-score').forEach(input => {
        input.addEventListener('change', function() {
          const cfg = { exceptional:{}, average:{}, satisfactory:{} };
          ['exceptional','average','satisfactory'].forEach(tier=>{
            const csat = parseFloat(document.querySelector(`.perf-target-csat[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].csat;
            const csatScore = parseFloat(document.querySelector(`.perf-csat-score[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].csatScore;
            const fcr = parseFloat(document.querySelector(`.perf-target-fcr[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].fcr;
            const fcrScore = parseFloat(document.querySelector(`.perf-fcr-score[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].fcrScore;
            const aht = parseFloat(document.querySelector(`.perf-target-aht[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].aht;
            const ahtScore = parseFloat(document.querySelector(`.perf-aht-score[data-tier="${tier}"]`).value) || DEFAULT_PERF[tier].ahtScore;
            cfg[tier] = { csat, csatScore, fcr, fcrScore, aht, ahtScore };
          });
          savePerfConfig(cfg);
        });
      });
    });

    function downloadData(){
      const rows = Array.from(tableBody.rows).map(row=>({
        date: row.cells[0].querySelector("input").value,
        interactionId: row.cells[1].querySelector("input").value,
        kr: row.cells[2].querySelector("input").value,
        cr: row.cells[3].querySelector("input").value,
        fcr: row.cells[5].querySelector("select").value
      }));
      
      const perfConfig = loadPerfConfig();
      const data = { 
        targetCSAT: targetCSAT.value, 
        targetFCR: targetFCR.value, 
        targetAHT: targetAHT.value,
        RunningAHT: RunningAHT.value,
        TotalCI: TotalCI.value,
        RWD: RWD.value,
        perfEnabled: perfEnabled,
        perfConfig: perfConfig,
        rows 
      };
      
      const now = new Date();
      const filename = `CSATFCR ${String(now.getMonth()+1).padStart(2,"0")}-${String(now.getDate()).padStart(2,"0")}-${now.getFullYear()}_${String(now.getHours()).padStart(2,"0")}-${String(now.getMinutes()).padStart(2,"0")}.json`;
      const blob = new Blob([JSON.stringify(data,null,2)], { type: "application/json" });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = filename;
      link.click();
    }

    function uploadData(event){
      const file = event.target.files[0];
      if(!file) return;
      const reader = new FileReader();
      reader.onload = function(e){
        try{
          const data = JSON.parse(e.target.result);
          
          // Load basic settings
          if(data.targetCSAT) targetCSAT.value = data.targetCSAT;
          if(data.targetFCR) targetFCR.value = data.targetFCR;
          if(data.targetAHT) targetAHT.value = data.targetAHT;
          if(data.RunningAHT) RunningAHT.value = data.RunningAHT;
          if(data.TotalCI) TotalCI.value = data.TotalCI;
          if(data.RWD) RWD.value = data.RWD;
          
          // Load performance table configuration if available
          if(data.perfConfig) {
            savePerfConfig(data.perfConfig);
            // Update the performance table UI if it's open
            if(document.getElementById('perfModal').classList.contains('show')) {
              populatePerfModal();
            }
          }
          
          // Load table rows
          tableBody.innerHTML = "";
          (data.rows || []).forEach(r=>{
            addRow(null, true);
            const lastRow = tableBody.lastElementChild;
            lastRow.cells[0].querySelector("input").value = r.date || "";
            lastRow.cells[1].querySelector("input").value = r.interactionId || "";
            lastRow.cells[2].querySelector("input").value = r.kr || "";
            lastRow.cells[3].querySelector("input").value = r.cr || "";
            lastRow.cells[5].querySelector("select").value = r.fcr || "";
            validateAndStyleScoreInput(lastRow.cells[2].querySelector("input"));
            validateAndStyleScoreInput(lastRow.cells[3].querySelector("input"));
            styleFCRSelect(lastRow.cells[5].querySelector("select"));
          });
          
          // DISABLE PERF EQ regardless of saved state
          setPerfEnabled(false);
          
          updateRemoveButtons();
          calculate();
          event.target.value = "";
          
          // Close the Advance Options modal after loading
          closeModal('advanceModal');

        }catch(err){
          alert("Invalid JSON file: " + err.message);
        }
      };
      reader.readAsText(file);
    }
    
    if (uploadFileHeader) uploadFileHeader.addEventListener('change', uploadData);

    function resetValues(){
      showModal('resetModal');
    }

    function confirmReset() {
      // Clear the table
      tableBody.innerHTML = "";
      
      // Add 5 empty rows
      for(let i=0;i<5;i++) addRow(null, true);
      
      // Reset input fields
      targetCSAT.value = "4.92";
      targetFCR.value = "85";
      targetAHT.value = "0";
      RunningAHT.value = "0";
      TotalCI.value = "0";
      RWD.value = "0";
      
      // Disable PERF EQ if active
      if(perfEnabled) {
        setPerfEnabled(false);
      }
      
      // Update UI and calculate
      updateRemoveButtons();
      calculate();
      
      // Close both the reset modal AND the advance options modal
      closeModal('resetModal');
      closeModal('advanceModal');
      
      // Optional: Scroll to top of page for better UX
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    document.getElementById('ham_advopt').addEventListener('click', ()=> showModal('advanceModal'));

    // Minutes to Seconds conversion
    function convertMinutesToSeconds(minutes, seconds = 0) {
      return (parseInt(minutes) * 60) + parseInt(seconds);
    }

    // Seconds to Minutes conversion
    function convertSecondsToMinutes(seconds) {
      const mins = Math.floor(seconds / 60);
      const secs = seconds % 60;
      return { minutes: mins, seconds: secs };
    }

    // Time Converter Functions
    function showTimeConverterModal() {
      document.getElementById("timeConverterModal").style.display = "flex";
      document.getElementById("timeConverterModal").classList.add("show");
    }

    // Real-time conversion for time converter
    document.addEventListener("DOMContentLoaded", () => {
      const minutesInput = document.getElementById("minutesInput");
      const extraSecondsInput = document.getElementById("extraSecondsInput");
      const secondsInput = document.getElementById("secondsInput");

      // Minutes + Seconds → Total Seconds
      function updateTotalSeconds() {
        const mins = parseInt(minutesInput.value) || 0;
        const secs = parseInt(extraSecondsInput.value) || 0;
        const totalSecs = convertMinutesToSeconds(mins, secs);
        document.getElementById("convertedSeconds").textContent = totalSecs;
      }

      // Seconds → Minutes + Seconds
      function updateMinutesAndSeconds() {
        const totalSecs = parseInt(secondsInput.value) || 0;
        const result = convertSecondsToMinutes(totalSecs);
        document.getElementById("convertedMinutes").textContent = result.minutes;
        document.getElementById("convertedRemainder").textContent = result.seconds;
      }

      if (minutesInput && extraSecondsInput) {
        minutesInput.addEventListener("input", updateTotalSeconds);
        extraSecondsInput.addEventListener("input", updateTotalSeconds);
      }

      if (secondsInput) {
        secondsInput.addEventListener("input", updateMinutesAndSeconds);
      }
    });
    
    window.addEventListener('DOMContentLoaded', ()=> {
      initializeTable();
      setPerfEnabled(false);
      populatePerfModal(); // Initialize performance table with saved/default values
    });

    window.resetValues = resetValues;
    
    function confirmLoad(){
      showModal('loadConfirmModal');
    }

    document.getElementById('proceedLoad').addEventListener('click', ()=>{
      closeModal('loadConfirmModal');
      document.getElementById('uploadFileHeader').click();
    });

function calculateTargetSecondsPerCase() {
  const totalCIVal = parseFloat(TotalCI.value) || 0;
  const rwdVal = parseFloat(RWD.value) || 0;
  
  if (!totalCIVal || !rwdVal) {
    return "MISSING_VAL";
  }
  
  const dailyInteractions = Math.ceil(totalCIVal / 22);
  const remainingCases = dailyInteractions * rwdVal;

  return remainingCases + " cases";
}

    function calculateTargetMinutesPerCase() {
      const targetAHTVal = parseFloat(targetAHT.value) || 0;
      const runningAHTVal = parseFloat(RunningAHT.value) || 0;
      const totalCIVal = parseFloat(TotalCI.value) || 0;
      const rwdVal = parseFloat(RWD.value) || 0;
      
      if (!targetAHTVal || !runningAHTVal || !totalCIVal || !rwdVal) {
        return "MISSING_VAL";
      }

      // ✅ Detect if already at/below target
      if (runningAHTVal <= targetAHTVal) {
        return "PASSED";
      }
      
      const dailyInteractions = Math.ceil(totalCIVal / 22);
      const remainingCases = dailyInteractions * rwdVal;
      const totalTimeSoFar = runningAHTVal * totalCIVal;
      const targetTotalTime = targetAHTVal * (totalCIVal + remainingCases);
      const allowedRemainingTime = targetTotalTime - totalTimeSoFar;
      const targetSecondsPerCase = allowedRemainingTime / remainingCases;
      
      // Convert seconds to minutes and seconds
      const minutes = Math.floor(targetSecondsPerCase / 60);
      const seconds = Math.round(targetSecondsPerCase % 60);
      
      return `${minutes}m ${seconds}s`;
    }
  </script>
</body>
</html>
