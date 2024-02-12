<!DOCTYPE html>
<html>
<head>
 <title>Generate And Download PDF File Using dompdf — websolutionstuff.com</title>
 <link rel="stylesheet” href=”https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</head>
<body>
    <table class="table table-sm table-bordered table-hover table-responsive small table-striped">
        <thead class="table-dark">
            <tr class="text-center ">
                <th class="align-middle" style="width: 33%">Nama Item</th>
                <th class="align-middle" style="width: 7%">Dimension</th>
                <th class="align-middle" style="width: 7%">Tolerance</th>
                <th class="align-middle" style="width: 5%">Selisih</th>
                <th class="align-middle" style="width: 5%">Onhand</th>
                <th class="align-middle" style="width: 5%">Total CSO</th>
                <th class="align-middle" style="width: 5%">Koreksi</th>
                <th class="align-middle" style="width: 5%">Deviasi</th>
                <th class="align-middle" style="width: 5%">Status CSO</th>
                <th class="align-middle" style="width: 5%">Grouping</th>
                <th class="align-middle" style="width: 18%">Analisator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemBlmProses as $barang)
                <tr>
                    <td>{{ $barang->itemname }}</td>
                    <td class="text-center">{{ $barang->dimension }}</td>
                    <td class="text-center">{{ $barang->tolerance }}</td>
                    <td class="text-center">{{ $barang->selisih }}</td>
                    <td class="text-center">{{ $barang->onhand }}</td>
                    <td class="text-center">{{ $barang->totalcso }}</td>
                    <td class="text-center">{{ $barang->koreksi }}</td>
                    <td class="text-center">{{ $barang->deviasi }}</td>
                    <td class="text-center">{{ $barang->statuscso }}</td>
                    <td class="text-center">{{ $barang->groupid }}</td>
                    <td class="text-center">{{ $barang->analisator }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>    
</body>
</html>