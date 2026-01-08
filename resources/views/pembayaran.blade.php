<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Detail Pembayaran</h2>
    
    <p>Pasien: {{ $pembayaran->kunjungan->pasien->nama }}</p>
    <p>Dokter: {{ $pembayaran->kunjungan->dokter->user->name ?? $pembayaran->kunjungan->dokter->nama }}</p>
    <p>Total Tagihan: Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</p>
    
    <button id="pay-button" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
        Bayar Sekarang
    </button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // Gunakan token dari variabel controller
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Pembayaran Berhasil!");
                window.location.href = "/landingpage-pasien"; // Redirect setelah sukses
            },
            onPending: function(result){
                alert("Menunggu pembayaran!");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>