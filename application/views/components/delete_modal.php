<div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">
                        Do you really want to delete these records? <br>
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <a href="#" id="btn-delete-confirm" class="btn btn-danger w-24">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "[data-url]", function () {
        var url = $(this).data("url");
        $("#btn-delete-confirm").attr("href", url);
    });
</script>
