<?php

namespace App\Http\Controllers;

use App\classes\tmoffer\ExpeditedPayInFullEmail;
use App\Mail\TmofferInvoiceSchedultedEmailSent;
use App\TmofferInvoiceScheduledEmail;
use App\TmofferInvoiceScheduledEmailBlock;
use App\traits\SaveToSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use App\Tmoffer;
use App\TmofferBin;
use App\TmfCompany;
use App\TmfSubject;
use App\TmfSubjectContact;
use App\Tmfsales;
use App\classes\tmoffer\CompanySubjectInfo;
use Illuminate\Support\Facades\DB;
use App\Mail\ExpeditedEmailSent;
use App\Mail\FailedEmailSent;
use App\classes\common\InvoicePDFGenerator;
use App\classes\tmoffer\InvoiceGenerator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class PaymentsCalendarController extends Controller
{
    use SaveToSent;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //2020-07-22 15:23:37
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

//        echo 'test';exit;
//        $tmoffer=Tmoffer::where('ID',146665)->first();
//        dd(CompanySubjectInfo::init($tmoffer)->get());
//        $tmf_company=TmfCompany::find(3801);
//        dd($tmf_company->tmfSubjects[0]->tmfSubjectContacts->toArray());

//        echo (new ExpeditedPayInFullEmail(Tmoffer::find(115725)))->getBody();
//        exit;
        $today = new \DateTime();
//        $today = new \DateTime('2020-11-30');


        $calendar = $this->getCalendar($this->getEvents($today), $today);

        $tmfsales = Tmfsales::where([
            ['Visible', '=', 1],
            ['ID', '!=', 70]
        ])
            ->orderBy('Level', 'desc')
            ->get();

        $tmfsales1=Tmfsales::whereIn('Login',Tmoffer::distinct()
            ->select('Sales')
            ->where('Sales','!=','""')
            ->where('DateConfirmed','!=','0000-00-00'))
            ->get();
        $tmfsales2=Tmfsales::whereIn('ID',Tmoffer::distinct()
            ->select('sales_id')
            ->where('sales_id','!=',0)
            ->whereNotIn('ID',Tmoffer::select('ID')
                ->where('Sales','!=','""')
                ->where('DateConfirmed','!=','0000-00-00')
            )
            ->where('DateConfirmed','!=','0000-00-00'))
            ->get();
        $tmfsales1=$tmfsales1->merge($tmfsales2);


        $boom_sources = [];
        foreach ($tmfsales1 as $el)
            if ($el->sales_calls || $el->ID == 1)
                $boom_sources[] = $el;

        $calendar_options_json = $calendar->getOptionsJson();
        $next_date = (clone $today)->add(\DateInterval::createFromDateString('1 month'))->format('Y-m-') . '01';
        $prev_date = (clone $today)->sub(\DateInterval::createFromDateString('1 month'))->format('Y-m-') . '01';
        return view('payments-calendar.index',
            compact('calendar_options_json',
                'tmfsales', 'boom_sources',
                'today',
                'prev_date',
                'next_date')
        );
    }

    private function getCalendar($events, \DateTime $datetime)
    {
        $calendar = new Calendar();

        $calendar->addEvents($events)
            ->setOptions([
                'locale' => 'en',
                'timeZone' => 'America/Los_Angeles',
                'themeSystem' => 'bootstrap',
                'initialDate' => $datetime->format('Y-m-d'),
                'firstDay' => 0,
                'dayMaxEvents' => 2,
                'displayEventTime' => false,
                'selectable' => false,
                'showNonCurrentDates' => false,
                'initialView' => 'dayGridMonth',
            ]);
        $calendar->setId('1');
        $calendar->setCallbacks([
            'select' => 'function(selectionInfo){}',
            'eventClick' => 'function(info){calendarClickEventHandler(info);}',
            'eventMouseEnter' => 'function(info){calendarSetCurrentEvent(info);}',
            'eventMouseLeave' => 'function(info){calendarMouseLeaveEvent(info);}',
            'eventContent' => 'function(info){return renderContentEvent(info);}',
            'eventOrder' => 'function(arg1,arg2){return calendarEventOrder(arg1,arg2);}'

        ]);
        return $calendar;
    }

    public function loadMonthData(Request $request)
    {
//        dd($request);
        $date = new \DateTime($request->start);
//        $calendar=$this->getCalendar();
//        $calendar_options=$calendar->getOptionsJson();
//        $next_date=(clone $date)->add(\DateInterval::createFromDateString('1 month'))->format('Y-m-').'01';
//        $prev_date=(clone $date)->sub(\DateInterval::createFromDateString('1 month'))->format('Y-m-').'01';
//        dd($this->getEvents($date));
        return response()->json(
            json_encode($this->getEventsAlt($date))
        );
    }

    private function getInvoicesPaidIndex($tmoffer)
    {
        $paid_arr = explode('|', $tmoffer->Paid);
        $result = -1;
        foreach ($paid_arr as $index => $paid)
            if (strlen($paid) && $paid != '+') {
                /*                $arr=explode('+',$paid);
                                $paid_date=new \DateTime($arr[0]);
                                if($datetime->format('Y-m')==$paid_date->format('Y-m')) {
                                    $result=$index+1;
                                    break;
                                }else*/
                $result = $index;
            } else
                break;
        return $result;
    }

    private function getPaidIndexForDate($tmoffer, $datetime)
    {
        $paid_arr = explode('|', $tmoffer->Paid);
        $result = -1;
        foreach ($paid_arr as $index => $paid)
            if (strlen($paid) && $paid != '+') {
                $arr = explode('+', $paid);
                $paid_date = new \DateTime($arr[0]);
                if ($datetime->format('Y-m') == $paid_date->format('Y-m')) {
                    $result = $index;
                    break;
                } else
                    $result = $index;
            } else
                break;
        return $result;

    }

    private function getAcceptedAgreementsLink($tmoffer_id)
    {
        return sprintf('https://trademarkfactory.com/mlcclients/acceptedagreements.php?tmoffer_id=%d', $tmoffer_id);
    }

    private function getInvoicesData($invoices_str, \DateTime $date)
    {
        $data = [
            'invoices' => 0,
            'current-invoice-index' => -1
        ];
        $arr = json_decode($invoices_str, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            $arr = unserialize($invoices_str);
            $data['invoices'] = $arr['count'];
        } else {
            $data['invoices'] = count($arr);
            foreach ($arr as $index => $el)
                if ((new \DateTime($el['date']))->format('Y-m') == $date->format('Y-m')) {
                    $data['current-invoice-index'] = $index;
                    break;
                }
        }
        return $data;
    }

    private function getEvents(\DateTime $datetime)
    {
        $tmoffers = $this->getTmoffers($datetime);
        $events = [];
        foreach ($tmoffers as $tmoffer) {
            $invoices_arr = json_decode($tmoffer->Invoices, true);
            $invoices_data = $this->getInvoicesData($tmoffer->Invoices, $datetime);
            $paid_index = $this->getInvoicesPaidIndex($tmoffer);
            $arr_paid = explode('|', $tmoffer->Paid);
            $invoice_day = '';
            $invoice_paid = 0;
/*            if($tmoffer->ID==65455) {
                echo "paid_index:$paid_index<br/>";
                var_dump($arr_paid);
                echo '<br/>';
                var_dump($invoices_arr);
                echo '<br/>';
            }*/
            if ($paid_index > -1) {
                $last_paid_invoice = $invoices_arr[$paid_index];
                $last_paid_invoice_date = new \DateTime($last_paid_invoice['date']);
                $add_event = 0;
/*                if($tmoffer->ID==65455) {
                    dd($invoices_data);
                    dd($invoices_arr);
                }*/
                if ($invoices_data['current-invoice-index'] != -1 && $arr_paid[$invoices_data['current-invoice-index']] != '+') {
                    $add_event = 1;
                    $invoice_day = (new \DateTime($invoices_arr[$invoices_data['current-invoice-index']]['date']))->format('d');
                    $invoice_paid = 1;
                    $paid_index = $invoices_data['current-invoice-index'];
                } /*                if ($last_paid_invoice_date->format('Y-m') >= $datetime->format('Y-m')) {
                    //current invoice paid
                    $paid_index = $this->getPaidIndexForDate($tmoffer, $datetime);
                    $paid_arr = explode('|', $tmoffer->Paid);
                    $arr=explode('+',$paid_arr[$paid_index]);
                    $paid_date=new \DateTime($arr[0]);
                    if($paid_date->format('Y-m')==$datetime->format('Y-m')) {
                        $invoice_day = $last_paid_invoice_date->format('d');
                        $add_event = 1;
                        $invoice_paid = 1;
                    }

                }*/ elseif (($paid_index + 1) < count($invoices_arr)) {
                    $invoice = $invoices_arr[$paid_index + 1];
                    $invoice_date = new \DateTime($invoice['date']);
/*                    if($tmoffer->ID==65455) {
                        echo "invoice_date:".$invoice_date->format('Y-m-d');
                    }*/
                    if ($invoice_date->format('Y-m') == $datetime->format('Y-m')) {
                        // unpaid invoice in current month
                        $add_event = 1;
                        $invoice_day = $invoice_date->format('d');
                        $paid_index++;
                    } else {
                        foreach ($invoices_arr as $index => $invoice_arr) {
                            $invoice_date = new \DateTime($invoice_arr['date']);
/*                            if($tmoffer->ID==65455) {
                                echo "invoice_date:".$invoice_date->format('Y-m').' datetime:'.$datetime->format('Y-m').'<br/>';
                            }*/
                            if ($invoice_date->format('Y-m') == $datetime->format('Y-m')) {
                                // unpaid invoice in current month
                                $add_event = 1;
                                $invoice_day = $invoice_date->format('d');
                                $paid_index = $index;
/*                                if($tmoffer->ID==65455) {
                                    echo "invoice_day:$invoice_day paid_index:$paid_index<br/>";
                                }*/
                            }
                        }
                    }

                }
//                if($tmoffer->ID==65455)
//                    echo "add_event:$add_event<br/>";
                if ($add_event) {
                    $payment_date = new \DateTime($datetime->format('Y-m-') . $invoice_day);

                    $title = sprintf('#%s', $tmoffer->Login);
                    $options = $this->getOptions($tmoffer, $payment_date, $invoices_arr, $invoice_paid, $paid_index);
//                    if ($tmoffer->ID == 65455) {
//                        echo "payment_date:".$payment_date->format('Y-m-d').'<br/>';
//                        dd($options);
//                    }
                    $events[] = Calendar::event(
                        $title,
                        true, //full day event?
                        $payment_date->format('Y-m-d'),
                        $payment_date->format('Y-m-d'),
                        $tmoffer->ID, //optionally, you can specify an event ID
                        $options
                    );
                }
            }
        }
        return $events;
    }

    private function getOptions($tmoffer, $payment_date, $invoices_arr, $invoice_paid, $paid_index)
    {
        $tmoffer_bin = TmofferBin::where('tmoffer_id', $tmoffer->ID)->first();
        $company_info = CompanySubjectInfo::init($tmoffer)->get();
        $fn = $company_info['firstname'] . ' ' . $company_info['lastname'];
        if ($company_info['company'] == $fn)
            $client = $fn;
        else
            $client = $company_info['company'] . "<br/>($fn)";
        $amount = $invoices_arr[$paid_index]['mlcfees'] * (1 + $tmoffer_bin->gst + $tmoffer_bin->pst);

//                    echo "ID:{$tmoffer->ID}<br/>";
        $save_amount = 0;
        $next_installment = -1;
        if (!$invoice_paid) {
            $email_vars = (new ExpeditedPayInFullEmail($tmoffer))->getEmailVars();
            $save_amount = $email_vars->save_with_pay_in_full;
            $next_installment = $email_vars->next_installment;
        }

        $tmoffer_invoice_scheduled_email_block = TmofferInvoiceScheduledEmailBlock::where([
            ['tmoffer_id', '=', $tmoffer->ID],
            ['installment', '=', $paid_index],
        ])->first();
        $tmoffer_invoice_scheduled_email = TmofferInvoiceScheduledEmailBlock::where([
            ['tmoffer_id', '=', $tmoffer->ID],
            ['installment', '=', $paid_index],
        ])->first();
        $boom_source_data = $this->getBoomSource($tmoffer);
        $options = [
            'aa-link' => $this->getAcceptedAgreementsLink($tmoffer->ID),
            'textColor' => 'white',
            'borderColor' => 'grey',
            'backgroundColor' => '#3490dc',
            'selected_currency' => $tmoffer_bin->selected_currency,
            'current_invoice_data' => ($paid_index + 1) . '/' . count($invoices_arr),
            'amount' => number_format($amount, 2),
            'pnum' => (count($invoices_arr) > 1 ? 'Multipay' : '1-Pay'),
            'client' => $client,
            'invoice_paid' => $invoice_paid,
            'paid_index' => $paid_index,
            'firstname' => $company_info['firstname'],
            'email' => $company_info['email'],
            'save_amount' => $save_amount,
            'next_installment' => $next_installment,
            'payment-date' => $payment_date->format('Y-m-d'),
            'active-status' => 'Active',
            'email-blocked' => ($tmoffer_invoice_scheduled_email_block ? 1 : 0),
            'weight' => 1,
            'notes' => (is_null($tmoffer->invoice_notes) ? '' : $tmoffer->invoice_notes),
            'scheduled-email-edited' => ($tmoffer_invoice_scheduled_email ? 1 : 0),
            'boom_source' => $boom_source_data['id'],
            'boom_source_caption' => $boom_source_data['caption'],
        ];
//                if($tmoffer->ID==80999)
//                    dd($options);

        $today = new \DateTime();
        if ($today->format('Y-m-d') > $payment_date->format('Y-m-d')) {
            if ($invoice_paid) {
                $options['backgroundColor'] = $options['borderColor'] = '#3ca416';
                $options['weight'] = 2;
            } else {
                $options['backgroundColor'] = $options['borderColor'] = '#FF0000';
                $options['weight'] = 0;
            }
        } elseif ($invoice_paid) {
            $options['backgroundColor'] = $options['borderColor'] = '#3ca416';
            $options['weight'] = 2;
        }

        if (strpos($tmoffer->Status, 'voided') !== false) {
            $options['backgroundColor'] = 'gray';
            $options['active-status'] = 'Cancelled';
            $options['weight'] = 3;
        }
//        if($tmoffer_invoice_scheduled_email_block)
//            $options['textColor']='gray';
        return $options;
    }

    private function getBoomSource($tmoffer)
    {
        if ($tmoffer->sales_id) {
            $tmfsales = Tmfsales::find($tmoffer->sales_id);
            return [
                'id' => $tmoffer->sales_id,
                'caption' => 'Closed by ' . $tmfsales->FirstName . ' ' . $tmfsales->LastName
            ];
        }

        if ($tmoffer->Sales && strlen($tmoffer->Sales)) {
            $tmfsales = Tmfsales::where('Login', $tmoffer->Sales)->first();
            return [
                'id' => $tmfsales->ID,
                'caption' => 'Closed by ' . $tmfsales->FirstName . ' ' . $tmfsales->LastName
            ];
        }

        return ['id' => -1, 'caption' => 'Auto-BOOM'];
    }

    private function getEventsAlt(\DateTime $datetime)
    {
        $tmoffers = $this->getTmoffers($datetime);
        $events = [];
        foreach ($tmoffers as $tmoffer) {
            $invoices_arr = json_decode($tmoffer->Invoices, true);
            $invoices_data = $this->getInvoicesData($tmoffer->Invoices, $datetime);
            $paid_index = $this->getInvoicesPaidIndex($tmoffer);
            $arr_paid = explode('|', $tmoffer->Paid);
            $invoice_day = '';
            $invoice_paid = 0;
            if ($paid_index > -1) {
                $last_paid_invoice = $invoices_arr[$paid_index];
                $last_paid_invoice_date = new \DateTime($last_paid_invoice['date']);
                $add_event = 0;
                if ($invoices_data['current-invoice-index'] != -1 && $arr_paid[$invoices_data['current-invoice-index']] != '+') {
                    $add_event = 1;
                    $invoice_day = (new \DateTime($invoices_arr[$invoices_data['current-invoice-index']]['date']))->format('d');
                    $invoice_paid = 1;
                    $paid_index = $invoices_data['current-invoice-index'];
                } /*                if ($last_paid_invoice_date->format('Y-m') >= $datetime->format('Y-m')) {
                    //current invoice paid
                    $paid_index = $this->getPaidIndexForDate($tmoffer, $datetime);
                    $paid_arr = explode('|', $tmoffer->Paid);
                    $arr=explode('+',$paid_arr[$paid_index]);
                    $paid_date=new \DateTime($arr[0]);
                    if($paid_date->format('Y-m')==$datetime->format('Y-m')) {
                        $invoice_day = $last_paid_invoice_date->format('d');
                        $add_event = 1;
                        $invoice_paid = 1;
                    }
                }*/ elseif (($paid_index + 1) < count($invoices_arr)) {
                    $invoice = $invoices_arr[$paid_index + 1];
                    $invoice_date = new \DateTime($invoice['date']);
                    if ($invoice_date->format('Y-m') == $datetime->format('Y-m')) {
                        // unpaid invoice in current month
                        $add_event = 1;
                        $invoice_day = $invoice_date->format('d');
                        $paid_index++;
                    } else {
                        foreach ($invoices_arr as $index => $invoice_arr) {
                            $invoice_date = new \DateTime($invoice_arr['date']);
                            if ($invoice_date->format('Y-m') == $datetime->format('Y-m')) {
                                // unpaid invoice in current month
                                $add_event = 1;
                                $invoice_day = $invoice_date->format('d');
                                $paid_index = $index;
                            }
                        }
                    }
                }
                if ($add_event) {
                    $payment_date = new \DateTime($datetime->format('Y-m-') . $invoice_day);
                    $title = sprintf('#%s', $tmoffer->Login);
                    $options = $this->getOptions($tmoffer, $payment_date, $invoices_arr, $invoice_paid, $paid_index);
                    $events[] = array_merge([
                        'title' => $title,
                        'start' => $payment_date->format('Y-m-d'),
                        'end' => $payment_date->format('Y-m-d'),
                        'id' => $tmoffer->ID, //optionally, you can specify an event ID

                    ], $options);
                }
            }
        }
        return $events;
    }

    private function getTmoffers(\DateTime $datetime)
    {
        $last_month_day = $datetime->format('Y-m-t');
//        return Tmoffer::whereRaw('Status not like "%voided%"')
        return Tmoffer::whereRaw(sprintf('TIMESTAMPDIFF(month, "%s", DateConfirmed)<12', $last_month_day))
            ->where('DateConfirmed', '<=', $last_month_day)
            ->whereIn('ID', TmofferBin::select('tmoffer_id')->where('need_capture', 0))
            ->orderBy('DateConfirmed', 'asc')
            ->get();
    }

    public function setTmofferInvoicePaidUnpaid(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                $paid_arr = explode('|', $tmoffer->Paid);
                if ($request->paid)
                    $paid_arr[$request->paid_index] = '+';
                else {
                    $invoices_arr = json_decode($tmoffer->Invoices, true);
                    $paid_arr[$request->paid_index] = $invoices_arr[$request->paid_index]['date'] . '+' . $invoices_arr[$request->paid_index]['mlcfees'];
                }
                $tmoffer->Paid = implode('|', $paid_arr);
                $tmoffer->save();
                return 'DONE';
            }
        }
        return '';
    }

    public function setTmofferInvoiceBlockUnblock(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                $tmoffer_invoice_scheduled_email_block = TmofferInvoiceScheduledEmailBlock::where([
                    ['tmoffer_id', '=', $tmoffer->ID],
                    ['installment', '=', $request->paid_index],
                ])->first();

                if ($request->block) {
                    if (!$tmoffer_invoice_scheduled_email_block) {
                        $tmoffer_invoice_scheduled_email_block = new TmofferInvoiceScheduledEmailBlock();
                        $tmoffer_invoice_scheduled_email_block->tmoffer_id = $tmoffer->ID;
                        $tmoffer_invoice_scheduled_email_block->installment = $request->paid_index;
                        $tmoffer_invoice_scheduled_email_block->save();
                    }
                } else {
                    $tmoffer_invoice_scheduled_email_block->delete();
                }

                return 'DONE';
            }
        }
        return '';
    }

    public function getExpeditedPaymentEmail(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                return response()
                    ->json($this->expeditedPaymentBodyAndSubj($tmoffer));
            }
        }
        return '';
    }

    public function getFailedPaymentEmail(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {

                return response()
                    ->json([
                        'subj' => 'We could not process your recurring payment',
                        'body' => $this->getFailedPaymentEmailBody($request, $tmoffer)
                    ]);
            }
        }
        return '';
    }

    public function getScheduledEmail(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                $epfe = new ExpeditedPayInFullEmail($tmoffer);
                $email_vars = $epfe->getEmailVars();
                $tmoffer_invoice_scheduled_email = TmofferInvoiceScheduledEmail::where([
                    ['tmoffer_id', '=', $request->tmoffer_id],
                    ['installment', '=', $email_vars->next_installment - 1],
                ])
                    ->first();
                if ($tmoffer_invoice_scheduled_email)
                    return response()
                        ->json([
                            'subj' => $epfe->getSubject(),
                            'body' => $epfe->getBody(),
                            'firstname' => $tmoffer_invoice_scheduled_email->to_fn,
                            'email' => $tmoffer_invoice_scheduled_email->to_email
                        ]);
                else
                    return response()
                        ->json([
                            'subj' => $epfe->getSubject(),
                            'body' => $epfe->getBody(),
                            'firstname' => $request->firstname,
                            'email' => $request->email
                        ]);
            }
        }
        return '';
    }

    public function getReceiptEmail(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                return response()
                    ->json([
                        'subj' => 'Your receipt from Trademark Factory®',
                        'body' => view('payments-calendar.receipt',
                            compact('tmoffer', 'request')
                        )->render(),
                        'firstname' => $request->firstname,
                        'email' => $request->email
                    ]);
            }
        }
        return '';
    }

    private function getFailedPaymentEmailBody(Request $request, Tmoffer $tmoffer)
    {
        $email_vars = (new ExpeditedPayInFullEmail($tmoffer))->getEmailVars();
        $email_body = view('payments-calendar.failed-payment-email-body-' . $request->pay_by, compact('request', 'tmoffer', 'email_vars'))->render();
        return $email_body . view('payments-calendar.failed-payment-email-body-common', compact('request', 'tmoffer', 'email_vars'))->render();
    }

    private function expeditedPaymentBodyAndSubj($tmoffer)
    {
        $epfe = new ExpeditedPayInFullEmail($tmoffer);
        return [
            'subj' => $epfe->getSubject(),
            'body' => $epfe->getBody()
        ];
    }

    public function sendEmail(Request $request)
    {
        switch ($request->action) {
            case 'send-expedited-payment-email':
                return $this->sendExpeditedPaymentEmail($request);
            case 'send-failed-payment-email':
                return $this->sendFailedPaymentEmail($request);
            case 'resend-scheduled-email':
                return $this->resendScheduledEmail($request);
            case 'send-receipt-email':
                return $this->sendReceiptEmail($request);
        }
        return '';
    }

    private function sendReceiptEmail(Request $request)
    {
        $tmoffer = Tmoffer::find($request->tmoffer_id);
        $date = new \DateTime();

        $epfe = new ExpeditedPayInFullEmail($tmoffer);
        $email_vars = $epfe->getEmailVars();

        $andrei = Tmfsales::find(1);
        $from_user = Tmfsales::find($request->from);
        $data = [
            'subj' => $request->subj,
            'body' => $request->email_body,
            'firstname' => $request->dear,
            'email' => $request->email,
            'from' => $from_user
        ];

        $invoice = InvoiceGenerator::init(Tmoffer::find($tmoffer->ID))->get($email_vars->next_installment - 1);
        $invoice_file_pdf = (new InvoicePDFGenerator($invoice))->generate();

        $this->sendSEmail($data, $andrei, $invoice_file_pdf);
        return 'Sent';
    }

    private function resendScheduledEmail(Request $request)
    {
        $tmoffer = Tmoffer::find($request->tmoffer_id);
        $date = new \DateTime();

        $epfe = new ExpeditedPayInFullEmail($tmoffer);
        $email_vars = $epfe->getEmailVars();

        $andrei = Tmfsales::find(1);
        $from_user = Tmfsales::find($request->from);
        $data = [
            'subj' => $request->subj,
            'body' => $request->email_body,
            'firstname' => $request->dear,
            'email' => $request->email,
            'from' => $from_user
        ];


        $invoice = InvoiceGenerator::init(Tmoffer::find($tmoffer->ID))->get($email_vars->next_installment);
        $invoice_file_pdf = (new InvoicePDFGenerator($invoice))->generate();

        $this->sendSEmail($data, $andrei, $invoice_file_pdf);
        $invoiced_arr = explode('|', $tmoffer->Invoiced);
        $invoiced_arr[$email_vars->next_installment - 1] = $date->format('Y-m-d');
        $tmoffer->Invoiced = implode('|', $invoiced_arr);
        $tmoffer->save();
        return 'Sent';
    }

    private function sendSEmail($data, $andrei, $invoice_file_pdf)
    {
        $signature = $this->getSignature($data['from']);
        $kristine = Tmfsales::find(77);
        if ($data['from']->ID != $andrei->ID)
            Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
                ->bcc([$andrei->Email, $kristine->Email])
                ->send(new TmofferInvoiceSchedultedEmailSent($data['from']->Email,
                    $data['from']->FirstName . ' ' . $data['from']->LastName,
                    $data['subj'],
                    $data['body'] . $signature,
                    $invoice_file_pdf));
        else
            Mail::to([['email' => $data['email'], 'name' => $data['firstname']]])
                ->send(new TmofferInvoiceSchedultedEmailSent($data['from']->Email,
                    $data['from']->FirstName . ' ' . $data['from']->LastName,
                    $data['subj'],
                    $data['body'] . $signature,
                    $invoice_file_pdf));

        $this->saveToSentWithAttachment(
            $data['from'],
            $data['email'],
            $data['firstname'],
            $data['subj'],
            $data['body'] . $signature,
            $invoice_file_pdf);
    }

    private function getSignature(Tmfsales $tmfsales)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $signature_link = 'https://trademarkfactory.com/signatureall_new.php?id=' . $tmfsales->ID;
        return file_get_contents(
            $signature_link,
            false,
            stream_context_create($arrContextOptions)
        );
    }

    private function sendFailedPaymentEmail(Request $request)
    {
        $from_user = Tmfsales::find($request->from);
        $andrei = Tmfsales::find(1);
        $signature = $this->getSignature($from_user);
        $kristine = Tmfsales::find(77);
        $invoice = InvoiceGenerator::init(Tmoffer::find($request->tmoffer_id))->get($request->paid_index);
        $invoice_file_pdf = (new InvoicePDFGenerator($invoice))->generate();

        if ($from_user->ID != $andrei->ID)
            Mail::to([['email' => $request->email, 'name' => $request->dear]])
                ->bcc([$andrei->Email, $kristine->Email])
                ->send(new FailedEmailSent($from_user->Email,
                        $from_user->FirstName . ' ' . $from_user->LastName,
                        $request->subj,
                        $request->email_body . $signature,
                        $invoice_file_pdf)
                );
        else
            Mail::to([['email' => $request->email, 'name' => $request->dear]])
                ->send(new FailedEmailSent($from_user->Email,
                        $from_user->FirstName . ' ' . $from_user->LastName,
                        $request->subj,
                        $request->email_body . $signature, $invoice_file_pdf)
                );

        $this->saveToSentWithAttachment($from_user, $request->email, $request->dear, $request->subj, $request->email_body . $signature, $invoice_file_pdf);

        return 'Sent';
    }

    public function scheduleEmail(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                $epfe = new ExpeditedPayInFullEmail($tmoffer);
                $email_vars = $epfe->getEmailVars();
                $tmoffer_invoice_scheduled_email = TmofferInvoiceScheduledEmail::where([
                    ['tmoffer_id', '=', $request->tmoffer_id],
                    ['installment', '=', $email_vars->next_installment - 1],
                ])
                    ->first();
                if (!$tmoffer_invoice_scheduled_email) {
                    $tmoffer_invoice_scheduled_email = new TmofferInvoiceScheduledEmail();
                    $tmoffer_invoice_scheduled_email->tmoffer_id = $request->tmoffer_id;
                    $tmoffer_invoice_scheduled_email->installment = $email_vars->next_installment - 1;
                }
                $tmoffer_invoice_scheduled_email->tmfsales_id = $request->from;
                $tmoffer_invoice_scheduled_email->to_fn = $request->dear;
                $tmoffer_invoice_scheduled_email->to_email = $request->email;
                $tmoffer_invoice_scheduled_email->subject = $request->subj;
                $tmoffer_invoice_scheduled_email->message = $request->email_body;
                $tmoffer_invoice_scheduled_email->created_at = Carbon::now();
                $tmoffer_invoice_scheduled_email->save();
                return 'DONE';
            }
        }
        return '';
    }

    private function sendExpeditedPaymentEmail(Request $request)
    {
        $from_user = Tmfsales::find($request->from);
        $andrei = Tmfsales::find(1);
        $kristine = Tmfsales::find(77);
        $signature = $this->getSignature($from_user);
        if ($from_user->ID != $andrei->ID)
            Mail::to([['email' => $request->email, 'name' => $request->dear]])
                ->bcc([$andrei->Email, $kristine->Email])
                ->send(new ExpeditedEmailSent($from_user->Email,
                    $from_user->FirstName . ' ' . $from_user->LastName,
                    $request->subj,
                    $request->email_body . $signature));
        else
            Mail::to([['email' => $request->email, 'name' => $request->dear]])
                ->send(new ExpeditedEmailSent($from_user->Email,
                    $from_user->FirstName . ' ' . $from_user->LastName,
                    $request->subj,
                    $request->email_body . $signature));

        $this->saveToSent($from_user, $request->email, $request->dear, $request->subj, $request->email_body . $signature);

        return 'Sent';
    }

    public function saveInvoiceNotes(Request $request)
    {
        if ($request->tmoffer_id) {
            $tmoffer = Tmoffer::find($request->tmoffer_id);
            if ($tmoffer) {
                $tmoffer->invoice_notes = $request->notes;
                $tmoffer->save();
                return 'DONE';
            }
        }
        return '';
    }
}
