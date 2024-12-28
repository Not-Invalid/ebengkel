<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nominal Debit</th>
            <th>Nominal Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($labarugi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ formatRupiah($item->nominal_debit) }}</td>
                <td>{{ formatRupiah($item->nominal_kredit) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="font-weight: bold; text-align: right;">Total</td>
            <td>{{ formatRupiah($totalDebit) }}</td>
            <td>{{ formatRupiah($totalKredit) }}</td>
        </tr>
    </tbody>
</table>
