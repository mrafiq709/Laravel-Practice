<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
    <body>
    <div class="rounded-t-xl overflow-hidden bg-gradient-to-r from-blue-50 to-light-blue-100 p-10">
        <table class="table-fixed">
            <thead>
            <tr>
                <th class="w-1/2 px-4 py-2 text-blue-600">#</th>
                <th class="w-1/4 px-4 py-2 text-blue-600">Name</th>
                <th class="w-1/4 px-4 py-2 text-blue-600">Item Count</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $key => $order)
                <tr>
                    <td class="border border-blue-500 px-4 py-2 text-blue-600 font-medium">{{ $order->id }}</td>
                    <td class="border border-blue-500 px-4 py-2 text-blue-600 font-medium">{{ $order->name }}</td>
                    <td class="border border-blue-500 px-4 py-2 text-blue-600 font-medium">{{ $order->item_count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </body>
</html>
