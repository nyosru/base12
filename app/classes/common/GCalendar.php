<?php
namespace App\classes\common;
use App\Tmfsales;

if(!defined('APPLICATION_NAME'))
    define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
if(!defined('CLIENT_SECRET_PATH'))
    define('CLIENT_SECRET_PATH', storage_path('app/google-calendar/client_secret_111699364449-9gnk14hat8oj8fb57s2ucjuetklp69rt.apps.googleusercontent.com.json'));
if(!defined('SCOPES'))
    define('SCOPES', implode(' ', array(
            \Google_Service_Calendar::CALENDAR)
    ));


class GCalendar
{
    private $client;
    private $service;
    private $accessToken;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName(APPLICATION_NAME);
        $this->client->setScopes(SCOPES);
        $this->client->setAuthConfig(CLIENT_SECRET_PATH);
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');
        $this->client->setPrompt('consent');
    }

    public function getURL(){
        return $this->client->createAuthUrl();
    }

    private function access($accessToken,Tmfsales $tmfsales=null){
        $this->accessToken=$accessToken;
        $this->client->setAccessToken($this->accessToken);
        if ($this->client->isAccessTokenExpired()) {

//            $this->client->refreshToken(json_decode($tmfsales_info['google_calendar_access'])->refresh_token);
//            echo '<pre>'.print_r(,true).'</pre>';
            $token=$this->client->getRefreshToken();
            $this->client->fetchAccessTokenWithRefreshToken($token);
            $this->accessToken=$this->client->getAccessToken();
            if(!is_null($tmfsales)){
                $tmfsales->google_calendar_access=json_encode($this->accessToken);
                $tmfsales->save();
            }
            $this->client->setAccessToken($this->accessToken);
        }
        $this->service = new \Google_Service_Calendar($this->client);
        return $this;
    }

    public function authenticate($authCode){
        return $this->access($this->client->fetchAccessTokenWithAuthCode($authCode));
    }

    public function authenticateByTMFSales(Tmfsales $tmfsales){
        return $this->access(json_decode($tmfsales->google_calendar_access,true));
    }

    public function getAccessToken(){
        return $this->accessToken;
    }

    public function getCalendarList(){
        $calendarList = $this->service->calendarList->listCalendarList();
        $calendar_data=[];
        while(true) {
            foreach ($calendarList->getItems() as $calendarListEntry) {
                $calendar_data[]=[
                    'id'=>$calendarListEntry->getID(),
                    'summary'=>$calendarListEntry->getSummary(),
                ];
            }
            $pageToken = $calendarList->getNextPageToken();
            if ($pageToken) {
                $optParams = array('pageToken' => $pageToken);
                $calendarList = $this->service->calendarList->listCalendarList($optParams);
            } else {
                break;
            }
        }
        return $calendar_data;
    }

    public function getTimeZone($calendarId='primary'){
        return $this->service->calendars->get($calendarId)->getTimeZone();
    }

    public function insertEvent($calendarId,$text,$description,$datetime,$length=45){
        if(!$calendarId || !strlen($calendarId))
            $calendarId='primary';
        file_put_contents(__DIR__.'/../test.txt',$datetime);
        $event = new \Google_Service_Calendar_Event([
            'summary' => $text,
            'location' => '',
            'description' => $description,
            'start' => [
                'dateTime' => date('c',strtotime($datetime)),
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => date('c',strtotime($datetime.' + '.$length.' minutes')),
                'timeZone' => 'America/Los_Angeles',
            ],
            'recurrence' => [],

            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => array(
                    ['method' => 'email', 'minutes' => 15],
                    ['method' => 'popup', 'minutes' => 15],
                ),
            ],
        ]);

        $event = $this->service->events->insert($calendarId, $event);
        return $event->getId();
    }

    public function insertEventWithoutReminders($calendarId,$text,$description,$datetime,$length=45){
        if(!$calendarId || !strlen($calendarId))
            $calendarId='primary';
        $event = new \Google_Service_Calendar_Event([
            'summary' => $text,
            'location' => '',
            'description' => $description,
            'start' => [
                'dateTime' => date('c',strtotime($datetime)),
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => date('c',strtotime($datetime.' + '.$length.' minutes')),
                'timeZone' => 'America/Los_Angeles',
            ],
            'recurrence' => [],

            'reminders' => [],
        ]);

        $event = $this->service->events->insert($calendarId, $event);
        return $event->getId();
    }

    public function deleteEvent($calendarId,$event_id){
        $this->service->events->delete($calendarId,$event_id);
    }

    public function getItems($timeMin,$timeMax,$calendarId='primary'){


// Print the next 10 events on the user's calendar.
//        $calendarId = 'contacts@group.v.calendar.google.com';
        //$calendarId = 'vitaly.polukhin@gmail.com';
//        $calendarId = 'vib7n0mtokml6jo2bjshjueaeg@group.calendar.google.com';
        $optParams = array(
            'orderBy' => 'startTime',
            'singleEvents' => TRUE,
            'timeMin' => date('c',strtotime($timeMin)),
            'timeMax' => date('c',strtotime($timeMax)),
            'maxResults'=>10000
        );
//        var_dump($optParams);
        $results = $this->service->events->listEvents($calendarId, $optParams);
        $items=null;
//        echo "timeMin:$timeMin timeMax:$timeMax count:".count($results->getItems())."<br/>";
//        var_dump($results->getItems());
        if (count($results->getItems()) == 0) {
            return null;
//            print "No upcoming events found.<br/>";
        } else {
//            print "Upcoming events:<br/>";
            foreach ($results->getItems() as $event) {
//                echo '<pre>';
//                var_dump($event);
//                var_dump($event->end);
                if($event->start->dateTime)
                    $start = $event->start->dateTime;
                else
                    $start = $event->start->date.' 00:00:00';
                if($event->end->dateTime)
                    $end = $event->end->dateTime;
                else
                    $end = $event->end->date.' 23:59:59';
//                if (empty($start)) {
//                    $start = $event->start->date;
//                }
//                printf("%s (%s)<br/>", $event->getSummary(), $start);
//                echo "<pre>".print_r($event,true)."</pre>";
//                echo "<pre>".print_r($event->start,true)."</pre>";

                $items[]=['summary'=>$event->getSummary(),
                    'description'=>$event->getDescription(),
                    'start'=>$start,
                    'end'=>$end,
                ];
            }
        }
        return $items;
    }

    public function getEventByID($event_id){
        $event = $this->service->events->get('primary', $event_id);
        return $event->getSummary();
    }

    public function issetEvent($event_id){

        try {
            $event = $this->service->events->get('primary', $event_id);
        } catch (\Google_Service_Exception $e) {
            $event=null;
        }
        return $event;
    }

}