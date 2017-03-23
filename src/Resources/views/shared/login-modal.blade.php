<div class="modal fade modal-primary" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="delete-confirmation-title">Login to {{$setting['site_abbreviation']}}</h3>
            </div>
            <div class="modal-body">
                @include('connexion::shared.loginform')
            </div>
        </div>
    </div>
</div>