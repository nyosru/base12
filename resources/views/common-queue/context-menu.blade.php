<form action="https://trademarkfactory.com/mlcclients/envelope.php" method="post" target="_blank" id="shipping-label-form">
    <input type="hidden" name="tmoffer_id" value="">
    <input type="hidden" name="addy" value="">
    <input type="hidden" name="note" value="">
</form>
<ul class="dropdown-menu" id="context-menu">
    <div>
        <div class="d-inline-block float-left">
            <li><a class="dropdown-item claim-link" href="#"><i class="fas fa-file-import text-success"></i> Claim</a></li>
            <li><a class="dropdown-item unclaim-link" href="#"><i class="fas fa-file-export text-danger"></i> Unclaim</a></li>
            <li><a class="dropdown-item request-review-link" href="#"><i class="fas fa-search"></i> Request Review</a></li>
            <li><a class="dropdown-item remove-request-review-link" href="#"><i class="fas fa-ban"></i> Remove Review Request</a></li>
            <li><a class="dropdown-item change-status-link" href="#"><i class="fas fa-project-diagram"></i> Change Status</a></li>
            <li><a class="dropdown-item view-in-dashboard-link" href="#"><i class="fas fa-tachometer-alt"></i> View in Dashboard</a></li>
            <li><a class="dropdown-item view-tss-link" href="#"><i class="fas fa-eye"></i> View TSS</a></li>
            <li><a class="dropdown-item tmfentry-link" href="#"><i class="fas fa-book"></i> TMF ENTRY</a></li>
        </div>
        <div class="d-inline-block float-left">
            <li><a class="dropdown-item view-in-aa-link" href="#"><i class="fas fa-file-contract"></i> View in Accepted Agreements</a></li>
            <li><a class="dropdown-item view-in-search-report-link" href="#"><i class="fas fa-search"></i> View Search Report</a></li>
            <li><a class="dropdown-item view-tm-office-page" href="#"><i class="fas fa-binoculars"></i> View TM Office Page</a></li>
            <li><a class="dropdown-item dashboard-notes-link" href="#"><i class="fas fa-sticky-note"></i> Notes</a></li>
            <li><a class="dropdown-item show-history-link" href="#"><i class="fas fa-history"></i> History</a></li>
            <li><a class="dropdown-item edit-flags-values-link" href="#"><i class="fas fa-flag"></i> Change Flags</a></li>
            @if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1]))
                <li><a class="dropdown-item print-shipping-link" href="#"><i class="fas fa-shipping-fast"></i> Print Shipping Label</a></li>
            @endif
        </div>
    </div>
</ul>
