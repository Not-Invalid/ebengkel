@extends('layouts.app')
@section('title')
    eBengkelku | Pesanan Service
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/daftar-event.css') }}">
@endpush
<style>
    .title-header {
        color: var(--main-blue);
        position: relative;
        z-index: 10;
    }

    /* Main Service Image */
    .img-fluid.object-fit-cover {
        object-fit: cover;
        height: 300px;
        border-radius: 10px;
    }

    /* Service Details */
    .fw-bold {
        font-weight: 600;
    }

    /* Price Card */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card h5 {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .text-success {
        font-size: 24px;
        color: #28a745;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        color: #fff;
        padding: 12px 20px;
        font-size: 16px;
        text-transform: uppercase;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    /* Contact Info */
    .row.py-5 {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .row.py-5 p {
        font-size: 16px;
        color: #333;
        margin-bottom: 15px;
    }

    .row.py-5 i {
        font-size: 20px;
        color: #3498db;
    }

    /* Background Overlay */
    .bg-white {
        opacity: 0.7;
        background-color: #fff;
    }

    .section-white {
        padding-top: 100px;
        padding-bottom: 20px;
    }

    /* Phone and Contact Info */
    .contact-icon {
        margin-right: 10px;
        color: #3498db;
    }
</style>
@section('content')
    <section class="section section-white"
        style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
        <div
            style="background-image: url('{{ asset('assets/images/bg/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
        </div>
        <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h4 class="title-header">Detail Pesan Services</h4>
                </div>
            </div>
        </div>
    </section>
    <div class="container daftar">
        <div class="wrapper">
            <h2 class="text-center">Pesan Services</h2>
            <form
                action="{{ route('store.pesanan-services', ['id_bengkel' => $id_bengkel, 'id_services' => $id_services]) }}"
                method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Masukkan nama Anda" required>
                </div>
                <div class="input-box">
                    <input type="tel" name="telp_pelanggan" placeholder="Masukkan nomor telepon Anda" required
                        oninput="validatePhoneNumber(this)" maxlength="15">
                </div>

                <div class="input-box">
                    <input type="text" id="nama_services" name="nama_services" placeholder="Masukkan nama layanan"
                        value="{{ isset($service) ? $service->nama_services : '' }}" readonly>
                </div>

                <!-- Tanggal Pesanan -->
                <div class="input-box">
                    <input type="date" id="tgl_pesanan" name="tgl_pesanan" min="{{ now()->format('Y-m-d') }}"
                        max="{{ now()->addDays(2)->format('Y-m-d') }}" required>
                    <span id="stock-info" class="text-sm"></span>
                </div>

                <div class="input-box mt-4">
                    <input type="text" id="total_pesanan" name="total_pesanan"
                        value="Rp {{ isset($service) ? number_format($service->harga_services, 2, ',', '.') : '' }}"
                        required>
                </div>

                <!-- Tombol Kirim -->
                <div class="input-box button">
                    <input type="submit" value="Pesan Sekarang">
                </div>
            </form>

            <script>
                function validatePhoneNumber(input) {
                    input.value = input.value.replace(/[^0-9]/g, '');

                    if (input.value.length > 15) {
                        input.value = input.value.slice(0, 15);
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const stockPerDate = @json($stockPerDate);
                    const dateInput = document.getElementById('tgl_pesanan');
                    const stockInfo = document.getElementById('stock-info');

                    // Get min and max dates
                    const minDate = new Date(dateInput.min);
                    const maxDate = new Date(dateInput.max);

                    // Handle date change
                    dateInput.addEventListener('change', handleDateChange);

                    // Handle keyboard navigation
                    dateInput.addEventListener('keydown', function(e) {
                        if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                            const currentDate = new Date(this.value || new Date());
                            let newDate;

                            if (e.key === 'ArrowUp') {
                                newDate = new Date(currentDate.setDate(currentDate.getDate() + 1));
                                if (newDate > maxDate) {
                                    e.preventDefault();
                                    alert('Stock belum tersedia untuk tanggal selanjutnya');
                                    return;
                                }
                            } else {
                                newDate = new Date(currentDate.setDate(currentDate.getDate() - 1));
                                if (newDate < minDate) {
                                    e.preventDefault();
                                    alert('Stock sudah habis untuk tanggal sebelumnya');
                                    return;
                                }
                            }
                        }
                    });

                    function handleDateChange() {
                        const selectedDate = dateInput.value;
                        const remainingStock = stockPerDate[selectedDate];

                        if (remainingStock !== undefined) {
                            if (remainingStock > 0) {
                                stockInfo.textContent = `Sisa stock: ${remainingStock}`;
                                stockInfo.style.color = 'green';
                                dateInput.style.backgroundColor = 'white';
                                dateInput.removeAttribute('disabled');
                            } else {
                                stockInfo.textContent = 'Stock habis untuk tanggal ini';
                                stockInfo.style.color = 'red';
                                dateInput.style.backgroundColor = 'white';
                                dateInput.value = '';
                                alert('Stock untuk tanggal ini sudah habis, silakan pilih tanggal lain');
                            }
                        } else {
                            // Cek apakah tanggal yang dipilih lebih dari maxDate
                            const selectedDateObj = new Date(selectedDate);
                            if (selectedDateObj > maxDate) {
                                alert('Stock belum tersedia untuk tanggal ini');
                            }
                            // Cek apakah tanggal yang dipilih kurang dari minDate
                            else if (selectedDateObj < minDate) {
                                alert('Stock sudah habis untuk tanggal sebelumnya');
                            }
                            // Untuk tanggal tidak tersedia lainnya
                            else {
                                alert('Tanggal tidak tersedia, silakan pilih tanggal lain');
                            }

                            stockInfo.textContent = 'Tanggal tidak tersedia';
                            stockInfo.style.color = 'red';
                            dateInput.style.backgroundColor = 'white';
                            dateInput.value = '';
                        }
                    }
                });
            </script>

        </div>
    </div>
@endsection
