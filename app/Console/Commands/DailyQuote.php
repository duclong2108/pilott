<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DOMDocument;
use DOMXPath;
use App\Models\Winner;
class DailyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

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
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->get('https://www.minhngoc.net.vn/xo-so-truc-tiep/mien-bac.html');
        $htmlString = (string) $response->getBody();
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($htmlString);
        $xpath = new DOMXPath($doc);
        #
        $titles = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giaidb"]//div');
        $zzz=array();
        array_push($zzz, substr($titles[0]->textContent, -2));
        $title1s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai1"]//div');
        array_push($zzz, substr($title1s[0]->textContent, -2));
        $title2s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai2"]//div');
        array_push($zzz, substr($title2s[0]->textContent, -2));
        array_push($zzz, substr($title2s[1]->textContent, -2));
        $title3s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai3"]//div');
        foreach($title3s as $title){
            array_push($zzz, substr($title->textContent, -2));
        }
        $title4s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai4"]//div');
        foreach($title4s as $title){
            array_push($zzz, substr($title->textContent, -2));
        }
        $title5s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai5"]//div');
        foreach($title5s as $title){
            array_push($zzz, substr($title->textContent, -2));
        }
        $title6s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai6"]//div');
        foreach($title6s as $title){
            array_push($zzz, substr($title->textContent, -2));
        }
        $title7s = $xpath->evaluate('//div[@class="box_kqxs box_kqxstt_mienbac"]//div[@class="content"]//div[@class="bkqmienbac"]//table//tbody//tr//td[@class="giai7"]//div');
        foreach($title7s as $title){
            array_push($zzz, substr($title->textContent, -2));
        }
        $zzz=implode(",",$zzz);
        // print($zzz);
        $winnerdbs=Winner::where('created_at', date('Y-m-d', strtotime(Carbon::now())))->where('result_prediction', substr($titles[0]->textContent, -2))->where('type',1)->orderBy('id', 'desc')->get();
        if(!empty($winnerdbs)){
            foreach($winnerdbs as $winner){
                $winner->update(['check'=>1, 'status'=>1]);
            }
        }
        $winnerlts=Winner::where('created_at', date('Y-m-d', strtotime(Carbon::now())))->whereIn('result_prediction', explode(",",$zzz))->where('type',0)->orderBy('id', 'desc')->get();
        if(!empty($winnerlts)){
            foreach($winnerlts as $winner){
                $winner->update(['check'=>1, 'status'=>1, 'count'=>count($winnerlts)]);
            }
        }
        $losedbs=Winner::where('created_at', date('Y-m-d', strtotime(Carbon::now())))->where('result_prediction','!=', substr($titles[0]->textContent, -2))->orderBy('id', 'desc')->get();
        if(!empty($losedbs)){
            foreach($losedbs as $lose){
                $lose->update(['status'=>0]);
            }
        }
        $loselts=Winner::where('created_at', date('Y-m-d', strtotime(Carbon::now())))->whereNotIn('result_prediction',explode(",",$zzz))->orderBy('id', 'desc')->get();
        if(!empty($loselts)){
            foreach($loselts as $lose){
                $lose->update(['status'=>0]);
            }
        }
    }
}
