<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
<div class="col-12 no-padding-margin my-5">
    <div class="card">
        <div class="card-header">
            <h4>Detail Transaksi</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                @if($model->status->isPending())
                    <label><h2 class="text-weight-bold">Terima  Tiket?</h2></label>
                    <div class="row ml-1">
                        <button class="btn btn-primary button" data-message-title="menerima" data-url="{{ route('admin.validate.qr.store') . '?' . http_build_query(array_merge(["status" => \App\Enums\TransactionStatusEnum::SUCCESS->value], request()->query())) }}">Terima</button> &nbsp;&nbsp;
                        <button class="btn btn-danger button" data-message-title="menolak" data-url="{{ route('admin.validate.qr.store') . '?' . http_build_query(array_merge(["status" => \App\Enums\TransactionStatusEnum::FAILED->value], request()->query())) }}">Tidak</button>
                    </div>
                @else
                    @if($model->status->isSuccess())
                        <label><h2 class="text-weight-bold badge badge-success" style="font-size: 24px;">Tiket diterima</h2></label>
                    @elseif($model->status->isFailed())
                        <label><h2 class="text-weight-bold badge badge-danger" style="font-size: 24px;">Tiket ditolak</h2></label>
                    @endif
                @endif
            </div>
            <hr>
            <div class="form-group">
                <label>Nama Tiket</label>
                <input type="text" disabled class="form-control" value="{{ $model->name }}">
            </div>
            <div class="form-group">
                <label>Harga Tiket</label>
                <input type="text" disabled class="form-control" value="{{ format_price($model->price) }}">
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="text" disabled class="form-control" value="{{ $model->quantity }}">
            </div>
            <div class="form-group">
                <label>Qr Code</label>
                <div>
                    <a href="{{ $model->qr_code_image_url }}" class="image-zoom">
                        <img src="{{ $model->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" id="form" method="post">@csrf</form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("a.image-zoom").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });
</script>
<script>
    $('.button').click(function(){
        Swal.fire({
            title: "Yakin " + $(this).data('message-title') + "?",
            showDenyButton: true,
            confirmButtonText: "Iya",
            denyButtonText: "Tidak",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form').attr('action', $(this).data('url')).submit();
            }
        });
    });
</script>
</body>
</html>
