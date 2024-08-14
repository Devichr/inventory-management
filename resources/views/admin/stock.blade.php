@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card" style="padding:3%">
        <h2 class="card-header">Stock</h2>
        <div class="d-flex justify-content-between p">
            <button id="download-pdf" class="btn btn-danger mb-3">Download PDF</button>
            <a href="{{route('admin.add-stock')}}" class="btn btn-success mb-3">Add Stock</a>
        </div>
        <table id="stock-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Fabric Type</th>
                    <th>Quantity</th>
                    <th>Location</th>
                    <th class="no-export">Update Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ $stock->fabric_type }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{ $stock->location }}</td>
                        <td class="no-export">
                            <a href="{{route('admin.edit-stock', $stock->id)}}" class="btn btn-success">Update Stock</a>
                        </td>
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

            const actionCells = document.querySelectorAll('.no-export');
            actionCells.forEach(cell => cell.style.display = 'none');

            const stockTable = document.getElementById('stock-table');

            const pdf = new jsPDF('p', 'pt', 'a4');

            html2canvas(stockTable, {
                onrendered: function(canvas) {
                    const imgData = canvas.toDataURL('image/png');

                    pdf.addImage(imgData, 'PNG', 10, 10, 580, 0);

                    actionCells.forEach(cell => cell.style.display = '');

                    pdf.save('stock-list.pdf');
                }
            });
        });
    </script
@endsection
