<div class="content">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Field</th>
            <th>Detail</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Month</td>
            <td>{{$booking->month}}</td>
        </tr>
        <tr>
            <td>Year</td>
            <td>{{$booking->year}}</td>
        </tr>
        <tr>
            <td>Sabre Bookings</td>
            <td>{{$booking->sabre_bookings}}</td>
        </tr>
        <tr>
            <td>Amadeus</td>
            <td>{{$booking->amadeus}}</td>
        </tr>
        <tr>
            <td>Travel Port</td>
            <td>{{$booking->travel_port}}</td>
        </tr>
        <tr>
            <td>Others</td>
            <td>{{$booking->others}}</td>
        </tr>
        <tr>
            <td>Travel Id</td>
            <td>{{$booking->ta_id}}</td>
        </tr>
        <tr>
            <td>Market Share Commitment</td>
            <td>{{$booking->marketsharecommitment}}</td>
        </tr>
        <tr>
            <td>Account Manager</td>
            <td>{{$booking->accountmanager}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{$booking->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$booking->updated_at}}</td>
        </tr>
        </tbody>
    </table>
    <!-- /form inputs -->
</div>
