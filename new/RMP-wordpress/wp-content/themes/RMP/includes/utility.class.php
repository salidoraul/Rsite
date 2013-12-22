<?php

class utility {
    public function utility(){
        global $form, $includes;

//        function lcwords($str){
//            return preg_replace('#\b([a-z])#ie', "strtolower($1)", $str);
//        }

        // clear file_exists cache incase file is added or removed
        clearstatcache();

//        $browser = new Browser();
//        $mobile = new Mobile_Detect();

//        if($browser && $mobile){
//
//            $this->html_classes($browser->getBrowser(), $browser->getPlatform(), $browser->getVersion(), $mobile->isMobile(), $mobile->isTablet());
//        }

    }

    /*
     * adds GA embed code to $includes
     *
     * @param   string  $ga_account - (required) Account name
     *
     */
    public function google_analytics($ga_account){
        global $includes;

        $includes .= <<<GACODE
            <script type="text/javascript">
              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', '$ga_account']);
              _gaq.push(['_trackPageview']);

              (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();
            </script>

GACODE;

    }


    /*
     * creates $html_classes variable
     *
     * @param   string  $browser_name       - (required) Browser name from Browser PHP class
     * @param   string  $browser_platform   - (required) Browser platform from Browser PHP class
     * @param   string  $browser_version    - (required) Browser version from Browser PHP class
     * @param   boolean $is_mobile          - Boolean response from Mobile_Detect PHP class if request is from mobile
     * @param   boolean $is_tablet          - Boolean response from Mobile_Detect PHP class if request is from tablet
     *
     */
    public function html_classes($browser_name, $browser_platform, $browser_version, $is_mobile = false, $is_tablet = false){
        global $html_classes;
        $browser_name = lcwords(str_replace(" ","-", $browser_name));
        $browser_platform = lcwords(str_replace(" ","-", $browser_platform));
        $browser_platform = ($browser_platform == "apple")?"mac":$browser_platform;
        $browser_version = explode(".",$browser_version);
        $browser_version = $browser_version[0];
        $browser_version = $browser_name."-".$browser_version;
        $is_mobile = ($is_mobile)?"mobile":"";
        $is_tablet = ($is_tablet)?"tablet":"";
        $is_phone = ($is_mobile && !$is_tablet)?"phone":"";

        $html_classes = $browser_name." ".$browser_platform." ".$browser_version." ".$is_phone." ".$is_tablet." ".$is_mobile;
    }


    /*
     * If ZZID is found, store it as a cookie incase the user navigates to other pages or comes back to the page and insert the ZZID into the form array to be passed along with the DB and email.
     *
     */
    public function zzid(){
        global $form;
        $zzid = $_GET['zzid'];

        if($zzid){
            if($_COOKIE['zzid'] != $zzid){
                setcookie('zzid', $zzid, time()+3600*24*365, '/'); // 365 day expiration
            }

            $form["zzid"] = array(
                "type"		=>		"hidden",
                "db_name"	=>		"zzid",
                "value" 	=>		$zzid
            );

            return $zzid;
        }
    }


    /*
     * Adds Callcap embed code to $includes variable
     *
     * @param   string  $callcap_id - (required) Callcap ID to be passed into the embed code
     *
     * @return returnVar
     */
    public function callcap($callcap_id){
        if($callcap_id){
            global $includes;
            $zzid = $this->zzid();

            $includes .= <<<CALLCAP
                <!-- CALLCAP CODE -->
                <script src="//reports.callcap.com/track/v1.js" type="text/javascript"></script>
                <script language="javascript">
                    webcap({u : '$callcap_id', k : '', c : '$zzid', a : '', p : ''});
                </script>
                <!-- END CALLCAP CODE -->
CALLCAP;
        }else{
            echo('<!-- ERROR: called callcap() without the ID parameter -->');
        }

    }


    /*
     * Adds Callcap rotator embed code to $includes variable, callcap writes phone number result into #callcap_phone_number
     *
     * @param   string  $callcap_id     - (required) Callcap ID used to determine rotator group
     * @param   number  $polling_int    - the number of seconds you want to check callcap for a phonecall, defaults to 5
     * @param   string  $class_name     - class name where callcap will output the phone number, defaults to 'callcap_phone_number'
     *
     */
    public function callcap_rotator($callcap_id, $pollingInt = 5, $class_name = 'callcap_phone_number'){
        if($callcap_id){
            global $includes;
            $zzid = $this->zzid();

            $includes .= <<<CCROTATOR
                <!-- CALLCAP ROTATOR -->
                <script src="//api.callcap.com/track/webmatch.js" type="text/javascript"></script>
                <script language="javascript">
                    var timingInt = $pollingInt;
                    var webmatch = new Webmatch( {
                        phone_format: 'paren',
                        instance_name: 'webmatch',
                        instance_class: '$class_name',
                        rotate: '$callcap_id',
                        k: '', //Keyword ID (This is generally used to track keyword campaigns. This is separate from the organic search term automatically captured)
                        c: '$zzid', //Creative ID (This is generally used to track different versions of an ad or landing page, such as for A/B testing, etc.)
                        a: '', //Ad Group (Can be used to track multiple ads in the same Ad Group.)
                        p: '', //Ad Placement (This can be used to track different placement options for ads.)
                        pull_parameters: false,
                        pollinginterval: timingInt*1000
                    } ).init();

                    function callcap_webmatch_callback(data) {
                        if(console){
                            console.log(data);
                        }
                        if (!data.error) {
                            if (data.lastcall < timingInt+10) {
                                  if(!window.callSuccess){
                                        if(console){
                                            console.log('likely call');
                                        }

                                        ga('send', 'event', 'phone_number', 'likely_dialed', {'nonInteraction': 1});
                                        _gaq.push(['_trackPageview', '/likely_phone_call']);

                                        window.callSuccess = true;
                                  }
                            }
                        } else {
                            logevent(data.error);
                        }
                    }
                </script>
                <!-- END CALLCAP ROTATOR -->

CCROTATOR;
        }else{
            echo('<!-- ERROR: called callcap_rotator() without the ID parameter -->');
        }

    }


    /*
     * Description of the function
     *
     * @param   string  $chart  - (required) FusionChart name for the type of chart you wish to render
     *
     * @return returnVar
     */
    public function clicktale(){
        global $clicktale;

        $clicktale .= <<<CLICKTALE
        <!-- ClickTale -->
        <div id="ClickTaleDiv" style="display: none;"></div>
        <script type='text/javascript'>
            var WRInitTime=(new Date()).getTime();
            document.write(unescape("%3Cscript%20src='"+
                    (document.location.protocol=='https:'?
                            'https://clicktalecdn.sslcs.cdngc.net/www/':
                            'http://s.clicktale.net/')+
                    "WRd.js'%20type='text/javascript'%3E%3C/script%3E"));


            var ClickTaleSSL=1;
            if(typeof ClickTale=='function') ClickTale(11337,1,"www07");

            function ClickTaleOnRecording(){
                    _gaq.push(['_setCustomVar', 1, "CTUID", ClickTaleGetUID(), 1]);
                    _gaq.push(['_setCustomVar', 2, "CTSID", ClickTaleGetSID(), 3]);
                    _gaq.push(['_trackEvent', 'Flush_Custom_Var_From_Queue', 'Flush_Custom_Var_From_Queue', 'Flush_Custom_Var_From_Queue',0,true]);
            }
        </script>
        <!-- End ClickTale -->

CLICKTALE;

    }
}

$utility = new utility();


?>