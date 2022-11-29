@if($email_vars->save_with_pay_in_full>=50 && $email_vars->next_installment<$email_vars->total_installments)
<p>Alternatively, you can <a href="https://trademarkfactory.com/expedited-payment/{{$tmoffer->Login}}" target="_blank">save ${{$email_vars->save_with_pay_in_full}} if you consolidate the remaining {{$email_vars->payments_remaining}} payments of ${{$request->amount}} into a single payment of ${{$email_vars->expedited_pay_in_full}}</a>.</p>
<p>If you choose this option, we will cancel your recurring invoices upon receipt of the expedited payment.</p>
@endif
<p>Either way, thank you for taking care of this at your earliest convenience.</p>