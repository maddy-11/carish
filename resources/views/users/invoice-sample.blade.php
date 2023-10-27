  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8"/>
    <title>Sample Invoice</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <style type="text/css">
      @page {size: auto;   /* auto is the initial value */
        margin: 5mm;}
    	  table { font-size: 10px; }
    table tr td 
    {
      vertical-align: top; padding-bottom: 3px;
    }
    table 
    {
      border-collapse: collapse;
      font-size:12px;
      border-spacing: 0px;}
      .invoicetable tr td, .invoicetable tr th {
      /*border: 1px solid skyblue;*/
      padding: 4px 7px;
    }
    .main-table > tbody > tr > td  { padding-right: 10px; padding-left: 10px;  }

    .invoicetable tr.inv-total-tr td {
        border: none;
        padding: 10px 2px 5px;
    }
    .inv-total-td span {
        font-weight: bold;
        border-bottom: 2px solid #000;
        display: inline-block;
        padding: 0px 5px 2px;
    }

    .my_table tr td{
      border: none;
    }
    .my_table {
      border: 1px solid black;
    }

    .my_table tr th{
      border: 1px solid black;
    }
    .my_table tr td:last-child{
      border-left: 1px solid black;
    }
    </style>

  </head>
  @php 
    $setting = App\GeneralSetting::select('bank_detail')->first();
    $arr = explode("\r\n", @$setting->bank_detail);
  @endphp
  <body style="font-family: sans-serif;padding: 70px 70px 0px;">
    <table class="main-table" style="max-width: 970px;width: 100%;margin-left: auto;margin-right: auto;margin: 0px auto;">
      <tbody>
        <tr>
          <td width="30%">
            <table class="table" style="width: 100%">
              <tbody>
                <tr>
                  <td colspan="2">
                    <img src="{{asset('public/assets/img/logo2.png')}}" width="150" style="margin-bottom: 20px;">
                   <!--  <h5 style="text-transform: uppercase; font-size: 18px; margin: 0px 0px 6px;"><strong>
                      {{$user->customer_company}}
                    </strong></h5> -->
                  </td>
                  <td>
                    <p> Invoice Number : <b>1234</b></p>
                    <p> Invoice Date : --</p>
                    <!-- <p> Pay Until : <b>--</b></p> -->
                  </td>
                </tr>
                <tr>
                  <td style="width: 50%;">
                    <p style="margin: 0px 0px 6px;">
                      Payer : <b>{{(@$invoice_setting->invoice_name != null) ? @$invoice_setting->invoice_name : '---------'}}</b>
                    </p>
                    <p>Reg No : <b>{{(@$user->customer_registeration != null) ? @$user->customer_registeration : '---------'}}</b></p>
                    <p>Address : <b>{{(@$invoice_setting->address != null) ? @$invoice_setting->address : '---------'}}</b></p>
                    <p>Contact Person : {{(@$invoice_setting->contact_person != null) ? @$invoice_setting->contact_person : '---------'}}</p>
                    <p>Vat No : {{(@$user->customer_vat != null) ? @$user->customer_vat : '---------'}}</p>
              
                  </td>

                </tr>
                <tr style="height: 40px;">
                  <td height="15px;"></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </td>
      
</tr>
        <tr>
          <td align="center" style="padding-top: 0px;">
           
            <table class="table invoicetable my_table" style="width: 100%;text-align: center;">
              <thead align="left">
                <tr>
                  <th width="80%">Content</th>
                  <th>
                  Amount
                </th>
                </tr>
              </thead>
             
              <tbody align="left">
               <tr>
                 <td>
                   AD Balance 
                 </td>
                 <td>
                   <b>20 €</b>
                 </td>
               </tr>

               <tr>
                 <td>
                   Feature Ad (3 Days) 
                 </td>
                 <td>
                   <b>7.5 €</b>
                 </td>
               </tr>

               <tr>
                 <td>
                   Post Ad (7 Days) 
                 </td>
                 <td>
                   <b>11 €</b>
                 </td>
               </tr>
              </tbody>
            </table>

          </td>
          
        </tr>
        <tr>
      <div style="padding: 0 10px;">
           <p><strong>Note: </strong>
Please mention invoice number while paying this invoice
</p>
           <p><strong>Status: </strong><span><b>Not Paid</b></span></p><br>
           </div>
        </tr>
       
        
  
      </tbody>
    </table>

    <div style="position: absolute;bottom: 100px;padding: 0 10px;">
      <div style="border-top: 1px solid black;">
        <p>The invoice was automatically created by: Carish OÜ</p>
      </div>
      <div style="margin-top: 40px;">
        <table width="100%">
          <tr>
            <td width="50%">
              Carish OÜ
            </td>
            <td>
              <b>Bank accounts</b>
            </td>
          </tr>
          <tr>
            <td>www.Carish.ee</td>
            <td>
              <span>{!! nl2br(e(@$arr[0])) !!}</b></span>
            </td>
          </tr>
          <tr>
            <td>Registry number:14584163</td>
            <td>
              <span>{{@$arr[1]}}</b></span>
            </td>
          </tr>
        </table>
      </div>
    </div>
      
  </body>
</html>