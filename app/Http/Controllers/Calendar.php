<?php

namespace App\Http\Controllers;

use ICal\ICal;

class Calendar
{
    public function dispatch()
    {
        $calendar = file_get_contents('http://p53-caldav.icloud.com/published/2/MTE0MzY0MzQxNzYxMTQzNiNOV53Nv-YYu8n4AHmjfKWZDaSQNPh2NyHzu4tioPUB-69q-ByeEPHqmFZGh72nCBhmd1zGW1eusqIAtPZm3Nc');

        try {
            $iCalender = new ICal($calendar, array(
                'defaultSpan'                 => 2,     // Default value
                'defaultTimeZone'             => 'UTC',
                'defaultWeekStart'            => 'MO',  // Default value
                'disableCharacterReplacement' => false, // Default value
                'filterDaysAfter'             => null,  // Default value
                'filterDaysBefore'            => null,  // Default value
                'skipRecurrence'              => false, // Default value
            ));
        } catch (\Exception $e) {
            return json_encode($e->getMessage());
        }

        $events = $iCalender->eventsFromInterval('1 week');

        $filtered = [];

        foreach ($events as $event) {
            $filtered[] = ['summary' => $event->summary, 'start' => $event->dtstart, 'end' => $event->dtend, 'id' => $event->uid];
        }

        return json_encode($filtered);
    }
}
