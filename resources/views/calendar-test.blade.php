
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.0.0/main.min.js"></script>




    <style>
        /* ... */
    </style>
</head>
<body>
{!! $calendar->calendar() !!}
<script>
    function calendarClickEventHandler(event) {
        console.log(event);
    }
    function calendarSelectEventHandler(event) {
        console.log(event);
    }
</script>
{!! $calendar->script() !!}
</body>
</html>