<?php

use App\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $destination = new Destination();
        $destination->address = "Frankfurt Flughafen, Terminal 1 (Halle A, exit 2-3)";
        $destination->lat = "50.050420";
        $destination->lng = "8.572214";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Frankfurt Flughafen, Terminal 2";
        $destination->lat = "50.051827";
        $destination->lng = "8.586927";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Frankfurt Fernbahnhof (Exit REWE)";
        $destination->lat = "50.053110";
        $destination->lng = "8.569458";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Frankfurt Hauptbahnhof";
        $destination->lat = "50.106942";
        $destination->lng = "8.661990";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Wiesbaden Hauptbahnhof";
        $destination->lat = "50.071076";
        $destination->lng = "8.244443";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Mainz Hauptbahnhof";
        $destination->lat = "50.001542";
        $destination->lng = "8.259107";
        $destination->save();

        $destination = new Destination();
        $destination->address = "Hofheim Bahnhof";
        $destination->lat = "50.084406";
        $destination->lng = "8.444644";
        $destination->save();

        $destination = new Destination();
        $destination->address = "IKEA Diedenbergen";
        $destination->lat = "50.058551";
        $destination->lng = "8.415397";
        $destination->save();

        $destination = new Destination();
        $destination->address = "IKEA Wallau (Mitarbeiter-Eingang)";
        $destination->lat = "50.057664";
        $destination->lng = "8.370142";
        $destination->save();

    }
}
