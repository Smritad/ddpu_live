<!doctype html>
<html lang="en">
<head>@include('components.backend.head')</head>
@include('components.backend.header')
@include('components.backend.sidebar')

<style>
*{box-sizing:border-box;}
body{background:#f5f6fa;}
.card{border:none;box-shadow:0 1px 6px rgba(0,0,0,.07);border-radius:14px;}
.card-body{padding:24px 26px;}
.page-header{margin-bottom:20px;}
.page-header h4{font-size:20px;font-weight:800;color:#111827;margin:0 0 4px;}
.page-header p{font-size:13px;color:#6b7280;margin:0;}
.fp-toolbar{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:18px;}
.fp-search{flex:1;min-width:220px;max-width:360px;padding:9px 14px;border:1px solid #d1d5db;border-radius:9px;font-size:14px;}
.fp-table{width:100%;border-collapse:collapse;font-size:13.5px;}
.fp-table th{text-align:left;padding:12px 14px;background:#f9fafb;color:#374151;font-weight:700;border-bottom:1px solid #e5e7eb;white-space:nowrap;}
.fp-table td{padding:12px 14px;border-bottom:1px solid #f1f2f4;color:#1f2937;}
.fp-table tr:hover td{background:#fafbff;}
.badge-status{display:inline-block;padding:3px 10px;border-radius:999px;font-size:11.5px;font-weight:700;}
.s-live{background:#dcfce7;color:#166534;}
.s-cancelled{background:#fee2e2;color:#991b1b;}
.s-expired{background:#fef3c7;color:#92400e;}
.s-suspended{background:#e5e7eb;color:#374151;}
.s-paid{background:#dcfce7;color:#166534;}
.s-failed{background:#fee2e2;color:#991b1b;}
.btn-view{border:1px solid #2563eb;color:#2563eb;background:#fff;border-radius:8px;padding:5px 12px;font-size:12.5px;font-weight:600;cursor:pointer;}
.btn-view:hover{background:#2563eb;color:#fff;}
.empty-st{text-align:center;padding:48px 10px;color:#6b7280;}
.empty-st .ei{font-size:34px;}
.fp-alert{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:13.5px;}

/* modal */
.fp-modal{position:fixed;inset:0;background:rgba(17,24,39,.55);display:none;align-items:flex-start;justify-content:center;z-index:1080;padding:40px 16px;overflow:auto;}
.fp-modal.open{display:flex;}
.fp-modal-box{background:#fff;border-radius:14px;width:100%;max-width:920px;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.fp-modal-head{background:#1d6fb8;color:#fff;padding:16px 22px;border-radius:14px 14px 0 0;display:flex;justify-content:space-between;align-items:center;}
.fp-modal-head h5{margin:0;font-size:16px;font-weight:700;}
.fp-modal-close{background:none;border:none;color:#fff;font-size:22px;cursor:pointer;line-height:1;}
.fp-modal-body{padding:20px 22px;}
.fp-sub{font-size:13px;color:#6b7280;margin:0 0 6px;font-weight:700;text-align:center;}
.fp-meta{font-size:14px;margin-bottom:14px;}
.fp-meta b{color:#111827;}
.fp-loading{text-align:center;padding:30px;color:#6b7280;}
</style>

<div class="page-body">
 <div class="container-fluid">
  <div class="row">
   <div class="col-12">
    <div class="card">
     <div class="card-body">

      <div class="page-header">
       <h4>FastPay Customers</h4>
       <p>Live customer list and Direct Debit history pulled directly from the FastPay portal.</p>
      </div>

      @if($error)
        <div class="fp-alert">⚠️ {{ $error }}</div>
      @endif

      <div class="fp-toolbar">
       <input type="text" id="fpSearch" class="fp-search" placeholder="Search by name, DD reference, sort code or account…">
       <span style="font-size:13px;color:#6b7280;">{{ count($customers) }} customer(s)</span>
      </div>

      <div style="overflow-x:auto;">
       <table class="fp-table" id="fpTable">
        <thead>
         <tr>
          <th>DD Reference</th>
          <th>Account Name</th>
          <th>Sort Code</th>
          <th>Account Number</th>
          <th>Effective / Suspension Date</th>
          <th>Status</th>
          <th></th>
         </tr>
        </thead>
        <tbody>
         @forelse($customers as $c)
           @php
             $status = $c['Status'] ?? '';
             $cls = 's-' . strtolower($status);
             $ref = $c['DDReference'] ?? '';
             $date = !empty($c['SuspensionDate']) && !str_starts_with($c['SuspensionDate'], '0001')
                     ? \Carbon\Carbon::parse($c['SuspensionDate'])->format('d/m/Y') : '';
           @endphp
           <tr>
            <td>{{ $ref }}</td>
            <td>{{ $c['AccountName'] ?? '' }}</td>
            <td>{{ $c['SortCode'] ?? '' }}</td>
            <td>{{ $c['AccountNumber'] ?? '' }}</td>
            <td>{{ $date }}</td>
            <td><span class="badge-status {{ $cls }}">{{ $status }}</span></td>
            <td>
             <button type="button" class="btn-view"
                     onclick="fpViewCustomer(this, @js($ref))">+ View</button>
            </td>
           </tr>
         @empty
           <tr>
            <td colspan="7">
             <div class="empty-st">
              <div class="ei">👥</div>
              <div>No customers returned from FastPay.</div>
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

<!-- Detail modal -->
<div class="fp-modal" id="fpModal">
 <div class="fp-modal-box">
  <div class="fp-modal-head">
   <h5 id="fpModalTitle">Customer details</h5>
   <button type="button" class="fp-modal-close" onclick="fpCloseModal()">&times;</button>
  </div>
  <div class="fp-modal-body" id="fpModalBody">
   <div class="fp-loading">Loading…</div>
  </div>
 </div>
</div>

<script>
const FP_SHOW_URL = @js(url('/fastpay/customers'));

// client-side search filter
document.getElementById('fpSearch').addEventListener('input', function () {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#fpTable tbody tr').forEach(tr => {
    tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
  });
});

function fpCloseModal(){ document.getElementById('fpModal').classList.remove('open'); }

function fpViewCustomer(btn, ref){
  const modal = document.getElementById('fpModal');
  document.getElementById('fpModalTitle').innerText = 'Customer details — ' + ref;
  document.getElementById('fpModalBody').innerHTML = '<div class="fp-loading">Loading…</div>';
  modal.classList.add('open');

  fetch(FP_SHOW_URL + '/' + encodeURIComponent(ref), {headers:{'Accept':'application/json'}})
    .then(r => r.json())
    .then(res => {
      if(!res.success){ throw new Error(res.message || 'Failed to load'); }
      document.getElementById('fpModalBody').innerHTML = fpRender(res.customer, res.transactions);
    })
    .catch(e => {
      document.getElementById('fpModalBody').innerHTML =
        '<div class="fp-alert">⚠️ ' + e.message + '</div>';
    });
}

function fpEsc(s){ return (s==null?'':String(s)).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c])); }

function fpRender(cust, txns){
  let html = '';
  if(cust){
    html += '<div class="fp-meta">'
      + '<b>DD Reference:</b> ' + fpEsc(cust.DDReference) + ' &nbsp;|&nbsp; '
      + '<b>Status:</b> ' + fpEsc(cust.Status) + ' &nbsp;|&nbsp; '
      + '<b>Current Collection Total:</b> £' + Number(cust.CurrentCollectionTotal||0).toFixed(2)
      + '</div>';
  }
  html += '<p class="fp-sub">Transactions</p>';
  if(!txns || !txns.length){
    html += '<div class="empty-st">No transactions for this customer yet.</div>';
    return html;
  }
  html += '<div style="overflow-x:auto;"><table class="fp-table"><thead><tr>'
        + '<th>Submission Date</th><th>Amount</th><th>BACS</th>'
        + '<th>Account Name</th><th>File</th><th>Status</th></tr></thead><tbody>';
  txns.forEach(t => {
    const sc = t.status === 'Paid' ? 's-paid' : (t.status === 'Failed' ? 's-failed' : 's-suspended');
    html += '<tr>'
      + '<td>' + fpEsc(t.submission_date) + '</td>'
      + '<td>£' + Number(t.amount||0).toFixed(2) + '</td>'
      + '<td>' + fpEsc(t.bacs_code) + '</td>'
      + '<td>' + fpEsc(t.account_name) + '</td>'
      + '<td>' + fpEsc(t.file_name) + '</td>'
      + '<td><span class="badge-status ' + sc + '">' + fpEsc(t.status) + '</span></td>'
      + '</tr>';
  });
  html += '</tbody></table></div>';
  return html;
}

document.getElementById('fpModal').addEventListener('click', function(e){
  if(e.target === this) fpCloseModal();
});
</script>

@include('components.backend.footer')
@include('components.backend.main-js')
</body>
</html>
