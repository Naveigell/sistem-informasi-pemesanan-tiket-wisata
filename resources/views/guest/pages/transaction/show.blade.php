<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="container my-5">
    <h2>Catatan : tunjukkan detail pada tabel di atas untuk melakukan scan terhadap semua tiket, dan tunjukkan tabel di bawah jika ini melakukan scan tiket secara satu persatu</h2>
    <p>Status: <span class="badge-warning badge">Belum divalidasi</span></p>
    <div class="row">
        <div class="col-12 no-padding-margin my-5">
            <div class="card">
                <div class="card-header">
                    <h4>Pemesanan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                    <div class="form-group">
                        <label>Nik Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->identity_number : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_name : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Email Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_email : '' }}">
                    </div>
                    <div class="form-group">
                        <label>No Telp Customer</label>
                        <input type="text" disabled class="form-control" value="{{ @$transaction ? $transaction->customer_phone : '' }}">
                    </div>
                    <div class="form-group">
                        <label>Qr Code</label>
                        <div>
                            <a href="{{ $transaction->qr_code_image_url }}" class="image-zoom">
                                <img src="{{ $transaction->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                            </a>
                        </div>
                        <small class="text text-muted mt-2 d-block">* Digunakan oleh customer jika ingin scan transaksinya (click untuk memperbesar)</small>
                    </div>
                </div>
            </div>
        </div>
        @foreach($transaction->transactionTickets as $ticket)
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Tiket - {{ $loop->iteration }}</h4>
                        <span>{!! $ticket->status->toHtmlBadge() !!}</span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Tiket</label>
                            <input type="text" disabled class="form-control" value="{{ $ticket->name }}">
                        </div>
                        <div class="form-group">
                            <label>Harga Tiket</label>
                            <input type="text" disabled class="form-control" value="{{ format_price($ticket->price) }}">
                        </div>
                        <div class="form-group">
                            <label>Qr Code</label>
                            <div>
                                <a href="{{ $ticket->qr_code_image_url }}" class="image-zoom">
                                    <img src="{{ $ticket->qr_code_image_url }}" alt="" style="width: 250px; height: 250px;">
                                </a>
                            </div>
                            <small class="text text-muted mt-2 d-block">* Klik untuk memperbesar</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
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
</body>
</html>
