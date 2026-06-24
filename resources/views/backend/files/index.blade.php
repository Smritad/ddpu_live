<!doctype html>
<html lang="en">
<head>@include('components.backend.head')</head>
@include('components.backend.header')
@include('components.backend.sidebar')

<style>
/* ─── Base ───────────────────────────────────────────────────────────────── */
*{box-sizing:border-box;}
body{background:#f5f6fa;}
.card{border:none;box-shadow:0 1px 6px rgba(0,0,0,.07);border-radius:14px;}
.card-body{padding:28px 30px;}

/* ─── Page header ────────────────────────────────────────────────────────── */
.page-header{margin-bottom:24px;}
.page-header h4{font-size:20px;font-weight:800;color:#111827;margin:0 0 4px;}
.page-header p{font-size:13px;color:#6b7280;margin:0;}

/* ─── Stats row ──────────────────────────────────────────────────────────── */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-box{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px 18px;display:flex;align-items:center;gap:14px;}
.stat-box .stat-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.stat-box .stat-icon.blue{background:#dbeafe;}
.stat-box .stat-icon.green{background:#dcfce7;}
.stat-box .stat-icon.red{background:#fee2e2;}
.stat-box .stat-icon.purple{background:#ede9fe;}
.stat-box .stat-val{font-size:22px;font-weight:800;color:#111827;line-height:1;}
.stat-box .stat-lbl{font-size:11px;color:#6b7280;font-weight:600;margin-top:3px;text-transform:uppercase;letter-spacing:.4px;}

/* ─── Section panels ─────────────────────────────────────────────────────── */
.section-panel{border:1px solid #e5e7eb;border-radius:10px;margin-bottom:20px;overflow:hidden;}
.section-head{padding:13px 18px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #e5e7eb;}
.section-head.blue{background:#eff6ff;}
.section-head.green{background:#f0fdf4;}
.section-head .sh-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.section-head.blue .sh-icon{background:#dbeafe;color:#1d4ed8;}
.section-head.green .sh-icon{background:#dcfce7;color:#15803d;}
.section-head .sh-title{font-size:13px;font-weight:700;color:#111827;}
.section-head .sh-sub{font-size:11px;color:#6b7280;margin-top:1px;}
.section-body{padding:18px 20px;background:#fff;}
.section-body.filter-bg{background:#f8faff;}
.section-body.upload-bg{background:#f0fdf4;}

/* ─── Form controls ──────────────────────────────────────────────────────── */
.form-label-sm{font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;display:block;}
.fc{width:100%;padding:8px 11px;font-size:13px;border:1.5px solid #e5e7eb;border-radius:7px;background:#fff;color:#111827;transition:border-color .15s,box-shadow .15s;}
.fc:focus{outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12);}
.fc.green-focus:focus{border-color:#16a34a;box-shadow:0 0 0 3px rgba(22,163,74,.12);}
.fc-hint{font-size:10px;color:#9ca3af;margin-top:4px;}

/* ─── Buttons ────────────────────────────────────────────────────────────── */
.btn-filter{background:#1d4ed8;color:#fff;border:none;border-radius:7px;padding:9px 18px;font-size:12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:background .15s;}
.btn-filter:hover{background:#1e40af;}
.btn-reset{background:#fff;color:#374151;border:1.5px solid #e5e7eb;border-radius:7px;padding:9px 18px;font-size:12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:border-color .15s;}
.btn-reset:hover{border-color:#9ca3af;color:#111827;}
.btn-import{background:#15803d;color:#fff;border:none;border-radius:7px;padding:9px 18px;font-size:12px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:background .15s;}
.btn-import:hover{background:#166534;}

/* ─── Alert ──────────────────────────────────────────────────────────────── */
.alert-success-custom{background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:12px 16px;font-size:13px;color:#166534;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:16px;}
.alert-error-custom{background:#fff1f2;border:1px solid #fca5a5;border-radius:8px;padding:12px 16px;font-size:13px;color:#991b1b;font-weight:600;display:flex;align-items:center;gap:8px;margin-bottom:16px;}

/* ─── Table ──────────────────────────────────────────────────────────────── */
.tbl-wrap{border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;}
.tbl-header{background:#f8faff;padding:13px 18px;border-bottom:1px solid #e5e7eb;display:flex;align-items:center;justify-content:space-between;}
.tbl-header .thl{font-size:13px;font-weight:700;color:#111827;display:flex;align-items:center;gap:7px;}
.tbl-header .thr{font-size:12px;color:#6b7280;}
table.main-tbl{width:100%;border-collapse:collapse;background:#fff;}
table.main-tbl thead tr th{background:#f8faff;padding:11px 16px;font-size:11px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid #e5e7eb;white-space:nowrap;}
table.main-tbl tbody tr td{padding:12px 16px;font-size:13px;color:#374151;border-bottom:1px solid #f3f4f6;vertical-align:middle;}
table.main-tbl tbody tr:last-child td{border-bottom:none;}
table.main-tbl tbody tr:hover{background:#f8faff;}

/* ─── File name cell ─────────────────────────────────────────────────────── */
.fn-cell{display:flex;align-items:center;gap:10px;}
.fn-ico{width:32px;height:32px;background:#e0e7ff;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;}
.fn-name{font-size:12px;font-weight:600;color:#111827;line-height:1.4;}
.fn-ext{font-size:10px;color:#6b7280;font-weight:500;}

/* ─── Status badges ──────────────────────────────────────────────────────── */
.sb{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.sb .dot{width:6px;height:6px;border-radius:50%;flex-shrink:0;}
.sb.uploaded{background:#dcfce7;color:#166534;border:1px solid #86efac;}
.sb.uploaded .dot{background:#16a34a;}
.sb.failed{background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;}
.sb.failed .dot{background:#dc2626;}
.sb.pending{background:#fef3c7;color:#92400e;border:1px solid #fcd34d;}
.sb.pending .dot{background:#d97706;}

/* ─── Amount ─────────────────────────────────────────────────────────────── */
.amt{font-size:13px;font-weight:700;color:#15803d;}

/* ─── Export btn ─────────────────────────────────────────────────────────── */
.btn-exp{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#fff;color:#15803d;border:1.5px solid #86efac;border-radius:6px;font-size:11px;font-weight:700;text-decoration:none;transition:all .15s;}
.btn-exp:hover{background:#dcfce7;color:#15803d;}

/* ─── Empty state ────────────────────────────────────────────────────────── */
.empty-st{text-align:center;padding:48px 20px;}
.empty-st .ei{font-size:40px;margin-bottom:10px;}
.empty-st .et{font-size:14px;font-weight:600;color:#374151;margin-bottom:4px;}
.empty-st .es{font-size:12px;color:#9ca3af;}

/* ─── Row number ─────────────────────────────────────────────────────────── */
.row-num{font-size:11px;font-weight:700;color:#9ca3af;background:#f3f4f6;width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;}

/* ─── Responsive ─────────────────────────────────────────────────────────── */
@media(max-width:768px){
 .stats-row{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:480px){
 .stats-row{grid-template-columns:1fr;}
}
</style>

<div class="page-body">
 <div class="container-fluid">
  <div class="page-title">
   <div class="row">
    <div class="col-6"></div>
    <div class="col-6">
     <ol class="breadcrumb">
      <li class="breadcrumb-item">
       <a href="index.html">
        <svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-home"></use></svg>
       </a>
      </li>
     </ol>
    </div>
   </div>
  </div>
 </div>

 <div class="container-fluid">
  <div class="row">
   <div class="col-sm-12">
    <div class="card">
     <div class="card-body">

      {{-- ── Page header ────────────────────────────────────────────────── --}}
      <!--<div class="d-flex flex-wrap justify-content-between align-items-start page-header">-->
      <!-- <div>-->
      <!--  <h4>File Upload &amp; Management</h4>-->
      <!--  <p>Upload DDPU collection files and track all submission history</p>-->
      <!-- </div>-->
       <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
         <li class="breadcrumb-item"><a href="{{ route('files.details') }}">Home</a></li>
         <li class="breadcrumb-item active">File Details</li>
        </ol>
       </nav>
      </div>

      {{-- ── Stats row ──────────────────────────────────────────────────── --}}
      @php
       $totalFiles    = $files->count();
       $uploadedCount = $files->where('status','uploaded')->count();
       $failedCount   = $files->where('status','failed')->count();
       $totalAmount   = $files->sum('total_amount');
      @endphp
      <div class="stats-row">
       <div class="stat-box">
        <div class="stat-icon blue">📁</div>
        <div>
         <div class="stat-val">{{ $totalFiles }}</div>
         <div class="stat-lbl">Total Files</div>
        </div>
       </div>
       <div class="stat-box">
        <div class="stat-icon green">✅</div>
        <div>
         <div class="stat-val" style="color:#15803d;">{{ $uploadedCount }}</div>
         <div class="stat-lbl">Uploaded</div>
        </div>
       </div>
       <!--<div class="stat-box">-->
       <!-- <div class="stat-icon red">❌</div>-->
       <!-- <div>-->
       <!--  <div class="stat-val" style="color:#dc2626;">{{ $failedCount }}</div>-->
       <!--  <div class="stat-lbl">Failed</div>-->
       <!-- </div>-->
       <!--</div>-->
       <div class="stat-box">
        <div class="stat-icon purple">💷</div>
        <div>
         <div class="stat-val" style="color:#7c3aed;">£{{ number_format($totalAmount, 2) }}</div>
         <div class="stat-lbl">Total Amount</div>
        </div>
       </div>
      </div>

      {{-- ── Alerts ──────────────────────────────────────────────────────── --}}
      @if(session('success'))
       <div class="alert-success-custom">✅ {{ session('success') }}</div>
      @endif
      @if(session('error'))
       <div class="alert-error-custom">❌ {{ session('error') }}</div>
      @endif

      {{-- ── Filter section ──────────────────────────────────────────────── --}}
      <div class="section-panel">
       <div class="section-head blue">
        <span class="sh-icon">🔍</span>
        <div>
         <div class="sh-title">Search Files by Filter</div>
         <div class="sh-sub">Narrow results by collection date range</div>
        </div>
       </div>
       <div class="section-body filter-bg">
        <form action="{{ route('files.details') }}" method="GET">
         <div class="row g-3 align-items-end">
          <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
           <label class="form-label-sm">From Date</label>
           <input type="date" name="from_date" class="fc"
            value="{{ $fromDate ?? now()->subMonth()->format('Y-m-d') }}">
          </div>
          <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
           <label class="form-label-sm">To Date</label>
           <input type="date" name="to_date" class="fc"
            value="{{ $toDate ?? now()->format('Y-m-d') }}">
          </div>
          <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
           <button type="submit" class="btn-filter w-100" style="width:100%;justify-content:center;">
            🔍 Apply Filter
           </button>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
           <a href="{{ route('files.details') }}" class="btn-reset" style="justify-content:center;display:flex;">
            ✕ Reset
           </a>
          </div>
         </div>
        </form>
       </div>
      </div>

      {{-- ── Upload section ───────────────────────────────────────────────── --}}
      <div class="section-panel">
       <div class="section-head green">
        <span class="sh-icon">⬆</span>
        <div>
         <div class="sh-title">Upload New File to FastPayAPI</div>
         <div class="sh-sub">Supported formats: Excel, CSV, XML, TXT</div>
        </div>
       </div>
       <div class="section-body upload-bg">
        <form action="{{ route('files.import') }}" method="POST" enctype="multipart/form-data">
         @csrf
         <div class="row g-3 align-items-end">
          <div class="col-xl-4 col-lg-4 col-md-6">
           <label class="form-label-sm">Select File</label>
           <input type="file" name="file" accept=".xlsx,.xls,.csv,.ods,.xml,.txt" class="fc green-focus" required>
           <div class="fc-hint">Excel (.xlsx .xls), CSV, ODS, XML, TXT</div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6">
           <label class="form-label-sm">Collection Date</label>
           <input type="date" name="collection_date" class="fc green-focus" required value="{{ now()->format('Y-m-d') }}">
          </div>
          <div class="col-xl-3 col-lg-3 col-md-8">
           <label class="form-label-sm">Notes <span style="font-weight:400;text-transform:none;letter-spacing:0;font-size:11px;color:#9ca3af;">(optional)</span></label>
           <input type="text" name="notes" class="fc green-focus" placeholder="Add remarks if needed">
          </div>
          <div class="col-xl-2 col-lg-2 col-md-4">
           <button type="submit" class="btn-import w-100" style="width:100%;justify-content:center;">
            ⬆ Submit
           </button>
          </div>
         </div>
        </form>
       </div>
      </div>

      {{-- ── Files table ──────────────────────────────────────────────────── --}}
      <div class="tbl-wrap">
       <div class="tbl-header">
        <div class="thl">📋 Uploaded Files</div>
        <div class="thr">{{ $totalFiles }} record{{ $totalFiles !== 1 ? 's' : '' }} found</div>
       </div>
       <table class="main-tbl">
        <thead>
         <tr>
          <th>#</th>
          <th>File Name</th>
          <th>Collection Date</th>
          <th>Date Uploaded</th>
          <th>Notes</th>
          <th>Total Amount</th>
          <th>Status</th>
          <th>Action</th>
         </tr>
        </thead>
        <tbody>
@forelse($files as $key => $file)
 @php
  $formattedDate = $file->collection_date
   ? \Carbon\Carbon::parse($file->collection_date)->format('y-m-d')
   : '—';
  $fileTitle = 'DDPU (Monthly on the 10th)';
  $note      = $file->notes ? "({$file->notes})" : '';
  $extension = pathinfo($file->file_name, PATHINFO_EXTENSION) ?: 'xlsx';
  $displayName = "{$formattedDate} {$fileTitle} {$note}";
  $statusClass = match($file->status ?? 'pending') {
   'uploaded' => 'uploaded',
   'failed'   => 'failed',
   default    => 'pending',
  };
 @endphp
 <tr>
  <td><div class="row-num">{{ $key + 1 }}</div></td>
  <td>
   <div class="fn-cell">
    <div class="fn-ico">📄</div>
    <div>
     <div class="fn-name">{{ $displayName }}</div>
     <div class="fn-ext">.{{ strtoupper($extension) }}</div>
    </div>
   </div>
  </td>
  <td style="white-space:nowrap;">
   {{ $file->collection_date ? \Carbon\Carbon::parse($file->collection_date)->format('d M Y') : '—' }}
  </td>
  <td style="white-space:nowrap;font-size:12px;color:#6b7280;">
   @if($file->uploaded_date)
    {{ \Carbon\Carbon::parse($file->uploaded_date)->format('d M Y') }}<br>
    <span style="font-size:10px;">{{ \Carbon\Carbon::parse($file->uploaded_date)->format('H:i') }}</span>
   @else
    —
   @endif
  </td>
  <td style="font-size:12px;color:#6b7280;">{{ $file->notes ?? '—' }}</td>
  <td><span class="amt">£{{ number_format($file->total_amount, 2) }}</span></td>
  <td>
   <span class="sb {{ $statusClass }}">
    <span class="dot"></span>
    {{ ucfirst($file->status ?? 'pending') }}
   </span>
  </td>
  <td>
   <a href="{{ route('files.export', $file->id) }}" class="btn-exp">
    ⬇ Export
   </a>
  </td>
 </tr>
@empty
 <tr>
  <td colspan="8" style="padding:0;border:none;">
   <div class="empty-st">
    <div class="ei">📂</div>
    <div class="et">No files found</div>
    <div class="es">No uploads match the selected date range.<br>Try adjusting the filter or upload a new file above.</div>
   </div>
  </td>
 </tr>
@endforelse
        </tbody>
       </table>
      </div>

     </div>
    </div>
   </div>
  </div>
 </div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')
</body>
</html>