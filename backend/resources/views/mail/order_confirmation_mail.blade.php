<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        li {
            list-style: none;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <h1>Hi {{ $newbooking->booking_details->user_name }} here is your order summary.</h1>
    <ul>
        <li><strong>User Name : </strong> {{ $newbooking->booking_details->user_name }}</li>
        <li><strong>User Email : </strong> {{ $newbooking->booking_details->email }}</li>
        <li><strong>Room Name : </strong> {{ $newbooking->booking_details->room_name }}</li>
        <li><strong>Room Unique ID : </strong> {{ $newbooking->room_id }}</li>
        <li><strong>Room No : </strong> {{ $newbooking->booking_details->room_no }}</li>
        <li><strong>Order Id : </strong>{{ $newbooking->id }}</li>
        <li><strong>Trasection Id : </strong>{{ $newbooking->tran_id }}</li>
        <li><strong>Check In : </strong>{{ date('d/m/Y', strtotime($newbooking->checkin)) }}</li>
        <li><strong>Check Out : </strong>{{ date('d/m/Y', strtotime($newbooking->checkout)) }}</li>
        <li><strong>Price : </strong>{{ $newbooking->booking_details->price }} {{ $newbooking->currency }} Per Night
        </li>
        <li><strong>Total Amount : </strong>{{ $newbooking->amount }} {{ $newbooking->currency }}</li>
        <li><strong>Paid Amount : </strong>{{ $newbooking->amount }} {{ $newbooking->currency }}</li>
        <li><strong>Order Place Date & Time :
            </strong>{{ date('d/m/Y | h:i:s A', strtotime($newbooking->created_at)) }}</li>
    </ul>
</body>

</html>
