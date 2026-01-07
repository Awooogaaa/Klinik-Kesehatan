<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>
</head>
<body>

<button id="pay-button">Bayar Sekarang</button>

<script>
    document.getElementById('pay-button').onclick = function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function (result) {
                console.log(result);
                alert("Pembayaran berhasil");
            },
            onPending: function (result) {
                alert("Menunggu pembayaran");
            },
            onError: function (result) {
                alert("Pembayaran gagal");
            }
        });
    };
</script>

</body>
</html>
