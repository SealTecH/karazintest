<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newbannermodal">
    Add banner
</button>

<!-- Modal -->
<div class="modal fade" id="newbannermodal" tabindex="-1" role="dialog" aria-labelledby="NewBanner">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New banner</h4>
            </div>
            <div class="modal-body">
                {include file="service.banner.tpl" banner=array()}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>