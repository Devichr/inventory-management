@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card" style="padding:3%">
        <h2 class="card-header">Stock</h2>
        <div class="d-flex justify-content-between p">
            <button id="download-pdf" class="btn btn-danger mb-3">Download PDF</button>
        </div>
        <table id="stock-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Fabric Type</th>
                    <th>Quantity</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ $stock->fabric_type }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{ $stock->location }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('download-pdf').addEventListener('click', function() {
            const { jsPDF } = window.jspdf;


            const stockTable = document.getElementById('stock-table');

            const pdf = new jsPDF('p', 'pt', 'a4');

            html2canvas(stockTable, {
                onrendered: function(canvas) {
                    const imgData = canvas.toDataURL('image/png');

                    pdf.addImage(imgData, 'PNG', 10, 10, 580, 0);


                    pdf.save('stock-list.pdf');
                }
            });
        });
    </script
@endsection
