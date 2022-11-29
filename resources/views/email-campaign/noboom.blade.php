<style>
    .n-btn{display:inline-block;margin-right:20px;}
    .t-btn{width:100%;}

    @media (min-width: 320px) and (max-width: 480px) {
        .n-btn{display:block;margin-right:0;}
        .t-btn{width:auto;margin:auto;}
    }
</style>
<p>{{$company_info['firstname']}},</p>
<p>Andrei here, the founder of Trademark Factory<sup>®</sup>.</p>
<p>I know that it’s been awhile since {{($cancelled_or_marked_as_noshow?'you booked':'')}} your call with {{$closer->FirstName}}, so I’d like to catch up and ask how you’re doing.</p>
<p>Our mission here at Trademark Factory<sup>®</sup> is to help growth-minded entrepreneurs build amazing brands, so we genuinely care about whether you got around to protecting your brand—even if you chose not to use our services.</p>
<p>I’d greatly appreciate if you could click one of the buttons below or simply reply to this email to let me know which one applies to you:</p>
<div style="text-align:left;max-width:800px">
    <div style="text-align:center">
        <div class="n-btn" style="margin-bottom:15px;">
            <table class="t-btn" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" style="width:135px;">
                            <tr>
                                <td align="center" style="border-radius: 3px;text-align:center;" bgcolor="#46D52E">
                                    <a href="https://trademarkfactory.com/your-feedback/tm-registered/{{$tmoffer->ConfirmationCode}}" target="_blank" style="font-size: 17px; font-family: Helvetica, Arial, sans-serif; color: #000; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 3px 15px; border: 1px solid #46D52E; display: inline-block; font-weight:600;">
                                        <div style="font-size:22px;color:#bbb;text-align:center;">①</div>
                                        <div style="text-align:center;line-height:0.95">My TM was<br/>successfully<br/>registered</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="n-btn" style="margin-bottom:15px;">
            <table class="t-btn" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" style="width:135px;">
                            <tr>
                                <td align="center" style="border-radius: 3px;text-align:center;" bgcolor="#FDBC2C">
                                    <a href="https://trademarkfactory.com/your-feedback/tm-still-pending/{{$tmoffer->ConfirmationCode}}" target="_blank" style="font-size: 17px; font-family: Helvetica, Arial, sans-serif; color: #000; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 3px 15px; border: 1px solid #FDBC2C; display: inline-block; font-weight:600;">
                                        <div style="font-size:22px;color:#777;text-align:center;">②</div>
                                        <div style="text-align:center;line-height:0.95">My TM is<br/>currently<br/>pending</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="n-btn" style="margin-bottom:15px;">
            <table class="t-btn" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" style="width:135px;">
                            <tr>
                                <td align="center" style="border-radius: 3px;text-align:center;" bgcolor="#E9291E">
                                    <a href="https://trademarkfactory.com/your-feedback/tm-was-rejected/{{$tmoffer->ConfirmationCode}}" target="_blank" style="font-size: 17px; font-family: Helvetica, Arial, sans-serif; color: #000; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 3px 15px; border: 1px solid #E9291E; display: inline-block; font-weight:600;">
                                        <div style="font-size:22px;color:#888;text-align:center;">③</div>
                                        <div style="text-align:center;line-height:0.95">My<br/>trademark<br/>was rejected</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="n-btn" style="margin-bottom:15px;">
            <table class="t-btn" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" style="width:135px;">
                            <tr>
                                <td align="center" style="border-radius: 3px;text-align:center;" bgcolor="#87cefa">
                                    <a href="https://trademarkfactory.com/your-feedback/still-plan-to-file-tm/{{$tmoffer->ConfirmationCode}}" target="_blank" style="font-size: 17px; font-family: Helvetica, Arial, sans-serif; color: #000; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 3px 15px; border: 1px solid #87cefa; display: inline-block; font-weight:600;">
                                        <div style="font-size:22px;color:#888;text-align:center;">④</div>
                                        <div style="text-align:center;line-height:0.95">I still plan<br/>on filing my<br/>trademark</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="n-btn" style="margin-bottom:15px;">
            <table class="t-btn" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" style="width:135px;">
                            <tr>
                                <td align="center" style="border-radius: 3px;text-align:center;" bgcolor="#d3d3d3">
                                    <a href="https://trademarkfactory.com/your-feedback/dont-want-to-tm-brand/{{$tmoffer->ConfirmationCode}}" target="_blank" style="font-size: 17px; font-family: Helvetica, Arial, sans-serif; color: #000; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 3px 15px; border: 1px solid #d3d3d3; display: inline-block; font-weight:600;">
                                        <div style="font-size:22px;color:#888;text-align:center;">⑤</div>
                                        <div style="text-align:center;line-height:0.95">I don’t want<br/>to TM<br/>my brand</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<p>The way we see it, there are generally 5 possible outcomes:</p>
<p style="margin-left:20px;">①	You filed your application yourself or used another firm to do it for you—and your trademark was <strong>successfully registered</strong>. If that’s the case, congratulations! It’s a very important milestone for your brand! Having said that, we’d really appreciate your <a href="https://trademarkfactory.com/your-feedback/tm-registered/{{$tmoffer->ConfirmationCode}}" target="_blank">feedback</a> as to why you did not choose Trademark Factory<sup>®</sup>. <a href="https://trademarkfactory.com/your-feedback/tm-registered/{{$tmoffer->ConfirmationCode}}" target="_blank">What did we do wrong</a>?</p>
<p style="margin-left:20px;">②	You filed your application yourself or used another firm to do it for you—and your trademark is <strong>currently pending</strong>. We will keep our fingers crossed that your application goes through. <a href="https://trademarkfactory.com/your-feedback/tm-still-pending/{{$tmoffer->ConfirmationCode}}" target="_blank">Keep us posted</a> how it goes and know that our doors are always open for you in case you need our help.</p>
<p style="margin-left:20px;">③	You filed your application yourself or used another firm to do it for you—and your trademark was <strong>rejected</strong>. I’m sorry to hear that. There are a few ways we can support you at this point. I highly recommend you <a href="https://trademarkfactory.com/your-feedback/tm-was-rejected/{{$tmoffer->ConfirmationCode}}" target="_blank">speak with one of our strategy advisors</a> to see how we can help.</p>
<p style="margin-left:20px;">④	You’re still interested in trademarking your brand but you just <strong>haven’t gotten around to filing your trademark</strong>. Is now a better time for you than when you {{($cancelled_or_marked_as_noshow?'booked your call with':'spoke to')}} {{$closer->FirstName}}? If you’re ready to get the process started, you are welcome to <a href="https://trademarkfactory.com/your-feedback/still-plan-to-file-tm/{{$tmoffer->ConfirmationCode}}" target="_blank">book a new call</a> with us.</p>
<p style="margin-left:20px;">⑤	You have no interest in trademarking your brand at all. We get it: life gets in the way. But if the day comes when you have a brand you want to protect, we’ll be here for you. Simply <a href="https://trademarkfactory.com/your-feedback/dont-want-to-tm-brand/{{$tmoffer->ConfirmationCode}}" target="_blank">schedule a free call</a> with one of our strategy advisors when you’re ready.</p>
<p>We believe in constant improvement and your feedback matters to us.</p>
<p>So even if you’re dead set on never using Trademark Factory<sup>®</sup> in the future, we’d appreciate your getting back to us.</p>
<p>P.S. Once again, you can either click any of the links above to get to the appropriate feedback form or <strong>simply reply to this email</strong> if it’s easier for you.</p>
{!! $pixel !!}