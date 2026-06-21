<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use App\Models\PopularNews;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\MinuteRange;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;

class PullGAData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:pullGAData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $propertyId = env('ANALYTICS_PROPERTY_ID');
        $client = new BetaAnalyticsDataClient();

        $request = (new RunReportRequest())
        ->setProperty('properties/' . $propertyId)
        ->setDateRanges([
            new DateRange([
                'start_date' => 'yesterday',
                'end_date' => 'today',
            ]),
        ])
        ->setDimensions([new Dimension(['name' => 'pageTitle']), new Dimension(['name' => 'pagePath'])])
        ->setMetrics([new Metric(['name' => 'screenPageViews'])])
        ->setLimit(20);
        $response = $client->runReport($request);

        $analyticsResult = Null;
        $pageTitles[] = Null;
        if(!empty($response->getRows())){
            foreach ($response->getRows() as $key => $row) {
                $explode = explode('/', $row->getDimensionValues()[1]->getValue());
                if(count($explode)-1 >= 2){
                    if(!array_search($row->getDimensionValues()[0]->getValue(), $pageTitles)){
                        $pageTitles[] = $row->getDimensionValues()[0]->getValue();
                        $analyticsResult[] = array(
                            'pageTitle' => $row->getDimensionValues()[0]->getValue(),
                            'pagePath' => $row->getDimensionValues()[1]->getValue(),
                            'pageView' => $row->getMetricValues()[0]->getValue(),
                        );
                    }
                }
            }
        }
        

        if(!empty($analyticsResult) && (count($analyticsResult)>0)){
            PopularNews::where('type', 1)->delete();

            $analyticsResult = array_slice($analyticsResult, 0, 10);
            $analyticsResult = array_reverse($analyticsResult);
            foreach ($analyticsResult as $key => $analyticsResultItem) {
                $dataInfo = new PopularNews;
                $dataInfo->title = $analyticsResultItem['pageTitle'];
                $dataInfo->link = env('Domain').$analyticsResultItem['pagePath'];
                $dataInfo->total_hit = $analyticsResultItem['pageView'];
                $dataInfo->type = 1;
                $dataInfo->order_id = $this->orderID();
                $dataInfo->status = 1;
                $dataInfo->created_by = 2;
                $dataInfo->created_at = date('Y-m-d H:i:s');
                $dataInfo->save();
            }
        }

        return 'done';
    }

    public function orderID()
    {
        $orderIDInfo = PopularNews::orderBy('order_id', 'desc')->first();
        if(!empty($orderIDInfo)){
            $orderID = $orderIDInfo->order_id+1;
        }else{
            $orderID = 1;
        }
        return $orderID;
    }


}
