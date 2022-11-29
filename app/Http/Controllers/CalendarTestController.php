<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;



class CalendarTestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = [];

        $events[] = Calendar::event(
            'Event One', //event title
            false, //full day event?
            '2020-07-21 01:00:00',
            '2020-07-21 02:00:00',
            0, //optionally, you can specify an event ID
            ['a'=>'test1','b'=>'test2']
        );

        $events[] = Calendar::event(
            "Valentine's Day", //event title
            true, //full day event?
            new \DateTime('2020-07-22'), //start time (you can also use Carbon instead of DateTime)
            new \DateTime('2020-07-23'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId' //optionally, you can specify an event ID
        );
        $events[] = Calendar::event(
            "Valentine's Day2", //event title
            true, //full day event?
            new \DateTime('2020-07-22'), //start time (you can also use Carbon instead of DateTime)
            new \DateTime('2020-07-23'), //end time (you can also use Carbon instead of DateTime)
            'stringEventId2' //optionally, you can specify an event ID
        );

//        $eloquentEvent = EventModel::first(); //EventModel implements Acaronlex\LaravelCalendar\Event

        $calendar = new Calendar();
        $options=[
            'locale' => 'en',
            'timeZone'=>'America/Los_Angeles',
            'firstDay' => 0,
            'displayEventTime' => false,
            'selectable' => false,
            'initialDate'=>'2020-05-03',
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'end' => 'today prev,next dayGridMonth'
            ]
        ];
        dd($options);
        $calendar->addEvents($events)
            ->setOptions($options);
        $calendar->setId('1');
        $calendar->setCallbacks([
            'select' => 'function(selectionInfo){}',
            'eventClick' => 'function(event){calendarClickEventHandler(event);}'
        ]);

        return view('calendar-test', compact('calendar'));
    }

}
