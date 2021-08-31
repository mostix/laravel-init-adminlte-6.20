<div class="modal fade" id="modal-delete-resource" role="dialog" aria-hidden=" true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="fa fa-exclamation"></i> {{__('custom.remove')}}  {{$resource}} <span
                        class="resource-name"></span>
                </h4>
            </div>
            <div class="modal-body">
                Сигурни ли сте, че искате да изтриете {{$resource}}
                <b><span id="resource_label" class="resource-name"></span></b>
                от системата ?
            </div>
            <div class="modal-footer">
                <form method="POST" action="" class="pull-left mr-4">
                    @csrf
                    <input name="id" value="" id="resource_id" type="hidden">
                    <button type="submit" class="btn btn-danger js-delete-resource"><i
                            class="fa fa-ban"></i>&nbsp; {{__('custom.delete')}} {{strtoupper($resource)}}</button>
                </form>
                <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">{{__('custom.cancel')}}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
