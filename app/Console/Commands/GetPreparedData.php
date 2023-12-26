<?php

namespace App\Console\Commands;

use App\Models\Endpoint;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class GetPreparedData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:apidata {application_id} {country_id} {dateFrom} {dateTo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get prepared data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        $application_id = $this->argument('application_id');
        $country_id = $this->argument('country_id');
        $dateFrom = $this->argument('dateFrom');
        $dateTo = $this->argument('dateTo');

        $url = "https://api.apptica.com/package/top_history/{$application_id}/{$country_id}?date_from={$dateFrom}&date_to={$dateTo}&B4NKGg=fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l"; 

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request("GET", $url);

            if ($response->getStatusCode() != 200) {
                throw new \Exception("Get status code: {$response->getStatusCode()}");
            }

            $data = json_decode($response->getBody(), true);

            $today = Carbon::now()->toDateString();

            $endpoint = Endpoint::whereDate("created_at", $today)->updateOrCreate(
                [
                    'application_id' => $application_id,
                    'country_id' => $country_id                    
                ],
                [
                    'application_id' => $application_id,
                    'country_id' => $country_id,    
                    'data'=> $data['data'],
                ]
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
