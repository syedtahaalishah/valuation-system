<table class="table-bordered table">
    <tbody>
        <tr>
            <th>Serial Number</th>
            <td>{{ $report->serial_number }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $report->location }}</td>
        </tr>
        <tr>
            <th>Suburb</th>
            <td>{{ $report->suburb }}</td>
        </tr>
        <tr>
            <th>Plot Number</th>
            <td>{{ $report->plot_number }}</td>
        </tr>
        <tr>
            <th>Valuation Date</th>
            <td>{{ $report->valuation_date }}</td>
        </tr>
        <tr>
            <th>Signing Valuer</th>
            <td>{{ $report->signing_valuer }}</td>
        </tr>
        <tr>
            <th>Market Value</th>
            <td>{{ $report->market_value }}</td>
        </tr>
        <tr>
            <th>Forced Sale Value</th>
            <td>{{ $report->forced_sale_value }}</td>
        </tr>
        <tr>
            <th>GPS Coordinates</th>
            <td>{{ $report->gps_coordinates }}</td>
        </tr>
        <tr>
            <th>Valuing Company</th>
            <td>{{ $report->valuing_company }}</td>
        </tr>
        <tr>
            <th>QR Code</th>
            <td>
                <img src="{{ $report->qr_code_url }}" width="100">
                <br>
                <a href="{{ $report->qr_code_url }}" target="_blank" download>Download QR Code</a>
            </td>
        </tr>
    </tbody>
</table>
