<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            width: 16.66%; /* 6 par ligne */
            text-align: center;
            padding: 5px 5px;
            vertical-align: top;
            border: 1px dashed #888; /* pour découpage */
        }

        .code {
            font-size: 8px;
            margin-top: 3px;
        }
    </style>
</head>
<body>

<h3 style="text-align:center; margin-bottom: 20px;">{{ $title }}</h3>

<table>
    <tr>
        @foreach ($barcodes as $index => $barcode)

            <td style="text-align: center">
                {!! $barcode['image'] !!}   <!-- Code-barres HTML -->
                <br>
                <span class="code">{{ $barcode['text'] }}</span>  <!-- Texte scanné -->
            </td>

            {{-- 6 par ligne (ta disposition originale) --}}
            @if(($index + 1) % 5 == 0)
                </tr><tr>
            @endif

        @endforeach
    </tr>
</table>

</body>
</html>
