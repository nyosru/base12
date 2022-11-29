<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 7/24/20
 * Time: 12:40 PM
 */

namespace App\classes\tmoffer;


use App\Tmoffer;
use App\TmofferTmfCountryTrademark;
use App\traits\Sanitize;
use App\TmfPackages;

abstract class InvoiceGenerator
{
    use Sanitize;

    protected $tmoffer;

    public function __construct(Tmoffer $tmoffer)
    {
        $this->tmoffer=$tmoffer;
    }

    public static function init(Tmoffer $tmoffer){
        $arr=json_decode($tmoffer->Invoices,true);
        if(json_last_error()==JSON_ERROR_NONE)
            return new InvoiceGeneratorFromJSON($tmoffer);
        else{
            if (strpos($tmoffer->Invoices, '+++') === false)
                return new InvoiceGeneratorFromSerializedArray($tmoffer);
            else
                return new InvoiceGeneratorFromOldStructure($tmoffer);
        }

    }

    abstract public function get($installment);

    protected function addZeros($number, $number_length)
    {
        $arr_numbers = str_split($number);
        $result_str = $number;
        for ($i = 0; $i < ($number_length - count($arr_numbers)); $i++)
            $result_str = '0' . $result_str;
        return $result_str;
    }

    protected function getPackageName()
    {
        $selected_packages = json_decode($this->tmoffer->selected_packages, true);
        $unique_packages = array_unique($selected_packages);
        $package_name = '';
        switch ($this->tmoffer->tmoffer_type) {
            case 'justfileit':
                $package_name = "(Just File It package)";
                break;
            case 'ifeellucky':
                $package_name = "(I-Feel-Lucky package)";
                break;
            case 'allinclusive':
            case 'allinclusive_new':
                if (!$this->tmoffer->SelectedPackageID)
                    $package_name = "(All-Inclusive package)";
                else {
                    $package_name = '(MULTIPLE PACKAGES)';
                    if (count($unique_packages) == 1) {
                        $md5_cond=sprintf('md5(tmf_packages.name)="%s"',$unique_packages[0]);
                        $package = TmfPackages::whereRaw($md5_cond)->first();
                        $package_name = "({$package->title} package)";
                    }
                }
                break;
        }
        return $package_name;
    }

    protected function getListOfTMs()
    {
        $listoftms='';
        $tmoffer_tmf_country_trademarks = TmofferTmfCountryTrademark::where([
            ['tmoffer_id',$this->tmoffer->ID],
            ['selected_flag',1],
            ['search_only',0]
        ])->get();

        foreach ($tmoffer_tmf_country_trademarks as $tmoffer_tmf_country_trademark) {
            $tmf_trademark=$tmoffer_tmf_country_trademark->tmfCountryTrademark->tmfTrademark;
            $tmf_country = $tmoffer_tmf_country_trademark->tmfCountryTrademark->tmfCountry;
//            $country = sprintf('<img src="/img/countries/%s" style="max-width: 20px;max-height: 12px" title="%s">', $tmf_country->getTmfCountryFlag(), $tmf_country->getTmfCountryName());
            if ($tmf_trademark->tmf_trademark_type_id == 1)
                $listoftms.=sprintf('<img src="https://trademarkfactory.imgix.net/offerimages/%s" class="offerimgsmall"/> (%s)<br/>',
                    $tmf_trademark->tmf_trademark_mark,
                    $tmf_country->tmf_country_code);
            else
                $listoftms.=sprintf('<b>%s</b> (%s)<br/>',
                    $tmf_trademark->tmf_trademark_mark,
                    $tmf_country->tmf_country_code);
        }
        return $listoftms;
    }

    protected function paintPaid($installment, $pnum, $invdate0, $html)
    {
        $allpaid = explode("|", $this->tmoffer->Paid);
        unset($when);
        $when = null;
        $inc = 0;
        for ($t = 0; $t < count($allpaid); $t++) {
            $allpaid1 = explode("+", $allpaid[$t]);
            if ($allpaid1[1] != "") {
                $when[$inc] = $allpaid1[0];
                $much[$inc++] = $allpaid1[1];
            }
        }
//        var_dump(($installment <= (count($when) - 1)));
        if ($installment <= (count((array)$when) - 1)) {
            if ($invdate0 < "2015-06-18 14:15:00")
                $find_str = "<b><i>mincovlaw.com</i></b>";
            else
                $find_str = "<span style='font-style: italic'><strong>TrademarkFactory.com</strong></span>";
            $text = "";
            if ($pnum > 1)
                $text = "$" . $much[$installment];
            else
                $text = "In Full";
            $replace_str = $find_str . "<div style='position: relative;top: -20px;left: -228px;'><img src='" . $this->getPaidImage($text, $when[$installment]) . "'></div>";
//            echo 'here';exit;
            $html = str_ireplace($find_str, $replace_str, $html);
        }

        return $html;
    }

    private function getPaidImage($text, $date)
    {
        $im = @imagecreatefrompng(public_path().'/img/paid.png');
        $font = public_path().'/fonts/Arial.ttf';
        $font_size = 12;
        $angle = 12;
        $text2 = $date;
        $color = imagecolorallocate($im, 187, 65, 52);

        $image_width = imagesx($im);
        $image_height = imagesy($im);

        $text_box = imagettfbbox($font_size, $angle, $font, $text);
        $text_box2 = imagettfbbox($font_size, $angle, $font, $text2);

// Get your Text Width and Height
        $text_width = $text_box[2] - $text_box[0];
        $text_height = $text_box[3] - $text_box[1];

        $text_width2 = $text_box2[2] - $text_box2[0];
        $text_height2 = $text_box2[3] - $text_box2[1];

// Calculate coordinates of the text
        $x = ($image_width / 2) - ($text_width / 2);
        $y = ($image_height / 2) - ($text_height / 2);

        $x2 = ($image_width / 2) - ($text_width2 / 2);
        $y2 = ($image_height / 2) - ($text_height2 / 2);

        imagettftext($im, $font_size, $angle, $x, 72, $color, $font, $text);
        imagettftext($im, $font_size, $angle, $x2 + 10, 92, $color, $font, $text2);
        ob_start();
        imagepng($im);
        $stringdata = ob_get_contents(); // read from buffer
        ob_end_clean(); // delete buffer
        $base64 = base64_encode($stringdata);
        return ('data:image/png;base64,' . $base64);
    }

}